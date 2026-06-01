<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Room;
use App\Models\Guest;
use App\Http\Requests\StoreReservationRequest;
use App\Http\Requests\UpdateReservationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReservationController extends Controller
{
    public function index()
    {
        $reservations = Reservation::with(['guest', 'room', 'rooms'])->orderBy('created_at', 'desc')->paginate(15);
        return view('admin.reservations.index', compact('reservations'));
    }

    public function create()
    {
        $guests = Guest::orderBy('name')->get();
        $rooms = Room::orderBy('number')->get();
        return view('admin.reservations.create', compact('guests', 'rooms'));
    }

    public function store(StoreReservationRequest $request)
    {
        $roomIds = $request->room_ids ?? [];
        
        // Verificar se todos os quartos estão disponíveis
        $rooms = Room::whereIn('id', $roomIds)->get();
        if ($rooms->count() !== count($roomIds)) {
            return back()->withErrors(['room_ids' => 'Um ou mais quartos selecionados não foram encontrados.'])->withInput();
        }

        foreach ($rooms as $room) {
            if ($room->status === 'occupied') {
                return back()->withErrors(['room_ids' => "O quarto {$room->number} está ocupado."])->withInput();
            }
        }

        // Verificar conflito de datas para cada quarto
        foreach ($roomIds as $roomId) {
            $conflictReservations = Reservation::where('status', '!=', 'cancelada')
                ->where(function($query) use ($request) {
                    $query->whereBetween('check_in_date', [$request->check_in_date, $request->check_out_date])
                        ->orWhereBetween('check_out_date', [$request->check_in_date, $request->check_out_date])
                        ->orWhere(function($q) use ($request) {
                            $q->where('check_in_date', '<=', $request->check_in_date)
                              ->where('check_out_date', '>=', $request->check_out_date);
                        });
                })
                ->with('rooms')
                ->get();

            foreach ($conflictReservations as $reservation) {
                $hasRoomInPivot = $reservation->rooms->contains('id', $roomId);
                $isMainRoom = $reservation->room_id == $roomId;
                
                if ($hasRoomInPivot || $isMainRoom) {
                    $room = Room::find($roomId);
                    return back()->withErrors(['room_ids' => "O quarto {$room->number} já está reservado para essas datas."])->withInput();
                }
            }
        }

        // Criar reserva com o primeiro quarto (para compatibilidade)
        $reservation = Reservation::create([
            'guest_id' => $request->guest_id,
            'room_id' => $roomIds[0], // Manter para compatibilidade
            'check_in_date' => $request->check_in_date,
            'check_out_date' => $request->check_out_date,
            'status' => $request->status ?? 'pendente',
            'notes' => $request->notes,
        ]);

        // Adicionar todos os quartos à reserva
        $reservation->rooms()->attach($roomIds);

        $roomsCount = count($roomIds);
        $message = $roomsCount > 1 
            ? "Reserva de {$roomsCount} quartos criada com sucesso!"
            : "Reserva criada com sucesso!";

        return redirect()->route('admin.reservations.index')->with('success', $message);
    }

    public function show(Reservation $reservation)
    {
        $reservation->load(['guest', 'room', 'rooms']);
        return view('admin.reservations.show', compact('reservation'));
    }

    public function edit(Reservation $reservation)
    {
        $reservation->load('rooms');
        $guests = Guest::orderBy('name')->get();
        $rooms = Room::orderBy('number')->get();
        return view('admin.reservations.edit', compact('reservation', 'guests', 'rooms'));
    }

    public function update(UpdateReservationRequest $request, Reservation $reservation)
    {
        $roomIds = $request->room_ids ?? [];
        
        // Verificar se todos os quartos estão disponíveis
        $rooms = Room::whereIn('id', $roomIds)->get();
        if ($rooms->count() !== count($roomIds)) {
            return back()->withErrors(['room_ids' => 'Um ou mais quartos selecionados não foram encontrados.'])->withInput();
        }

        // Verificar conflito de datas para cada quarto (exceto a própria reserva)
        foreach ($roomIds as $roomId) {
            $conflictReservations = Reservation::where('id', '!=', $reservation->id)
                ->where('status', '!=', 'cancelada')
                ->where(function($query) use ($request) {
                    $query->whereBetween('check_in_date', [$request->check_in_date, $request->check_out_date])
                        ->orWhereBetween('check_out_date', [$request->check_in_date, $request->check_out_date])
                        ->orWhere(function($q) use ($request) {
                            $q->where('check_in_date', '<=', $request->check_in_date)
                              ->where('check_out_date', '>=', $request->check_out_date);
                        });
                })
                ->with('rooms')
                ->get();

            foreach ($conflictReservations as $conflictReservation) {
                $hasRoomInPivot = $conflictReservation->rooms->contains('id', $roomId);
                $isMainRoom = $conflictReservation->room_id == $roomId;
                
                if ($hasRoomInPivot || $isMainRoom) {
                    $room = Room::find($roomId);
                    return back()->withErrors(['room_ids' => "O quarto {$room->number} já está reservado para essas datas."])->withInput();
                }
            }
        }

        // Atualizar reserva
        $reservation->update([
            'guest_id' => $request->guest_id,
            'room_id' => $roomIds[0], // Manter para compatibilidade
            'check_in_date' => $request->check_in_date,
            'check_out_date' => $request->check_out_date,
            'status' => $request->status,
            'notes' => $request->notes,
        ]);

        // Sincronizar quartos na tabela pivot
        $reservation->rooms()->sync($roomIds);

        $roomsCount = count($roomIds);
        $message = $roomsCount > 1 
            ? "Reserva de {$roomsCount} quartos atualizada com sucesso!"
            : "Reserva atualizada com sucesso!";

        return redirect()->route('admin.reservations.index')->with('success', $message);
    }

    public function destroy(Reservation $reservation)
    {
        $reservation->delete();
        return redirect()->route('admin.reservations.index')->with('success', 'Reserva excluída com sucesso!');
    }
}
