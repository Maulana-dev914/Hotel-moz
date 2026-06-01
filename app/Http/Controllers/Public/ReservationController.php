<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePublicReservationRequest;
use App\Models\Reservation;
use App\Models\Guest;
use App\Models\Room;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function create(Request $request)
    {
        $roomIds = [];
        if ($request->room_ids) {
            if (is_array($request->room_ids)) {
                $roomIds = array_map('intval', $request->room_ids);
            } else {
                // Se for string separada por vírgula
                $roomIds = array_map('intval', array_filter(explode(',', $request->room_ids)));
            }
        } elseif ($request->room_id) {
            $roomIds = [(int)$request->room_id];
        }
        
        $checkIn = $request->check_in_date;
        $checkOut = $request->check_out_date;
        $adults = $request->adults ?? 1;
        $children = $request->children ?? 0;

        $rooms = collect();
        if (!empty($roomIds)) {
            $rooms = Room::whereIn('id', $roomIds)->get();
        }

        // Se não houver quartos selecionados, mostrar todos disponíveis
        $availableRooms = Room::where('status', 'available')->orderBy('number')->get();

        return view('public.reservations.create', compact('rooms', 'availableRooms', 'checkIn', 'checkOut', 'adults', 'children'));
    }

    public function store(StorePublicReservationRequest $request)
    {
        $roomIds = $request->room_ids;
        
        // Verificar se todos os quartos estão disponíveis
        $rooms = Room::whereIn('id', $roomIds)->get();
        if ($rooms->count() !== count($roomIds)) {
            return back()->withErrors(['room_ids' => 'Um ou mais quartos selecionados não foram encontrados.'])->withInput();
        }

        foreach ($rooms as $room) {
            if ($room->status !== 'available') {
                return back()->withErrors(['room_ids' => "O quarto {$room->number} não está disponível."])->withInput();
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
                // Verificar se o quarto está na tabela pivot
                $hasRoomInPivot = $reservation->rooms->contains('id', $roomId);
                // Verificar se é o quarto principal
                $isMainRoom = $reservation->room_id == $roomId;
                
                if ($hasRoomInPivot || $isMainRoom) {
                    $room = Room::find($roomId);
                    return back()->withErrors(['room_ids' => "O quarto {$room->number} já está reservado para essas datas."])->withInput();
                }
            }
        }

        // Criar ou buscar hóspede
        if ($request->reservation_type === 'person') {
            $email = $request->email;
            $guest = Guest::firstOrNew(['email' => $email]);
            $guest->name = $request->name;
            $guest->phone = $request->phone;
            $guest->document = $request->document;
            $guest->document_type = $request->document_type;
        } else {
            $email = $request->company_email;
            $guest = Guest::firstOrNew(['email' => $email]);
            $guest->name = $request->company_name;
            $guest->phone = $request->company_phone;
            $guest->document = $request->company_document ?? null;
            $guest->document_type = $request->company_document_type ?? null;
        }
        $guest->save();

        // Criar reserva com o primeiro quarto (para compatibilidade)
        $reservation = Reservation::create([
            'guest_id' => $guest->id,
            'room_id' => $roomIds[0], // Manter para compatibilidade
            'check_in_date' => $request->check_in_date,
            'check_out_date' => $request->check_out_date,
            'status' => 'pendente',
            'reservation_type' => $request->reservation_type ?? 'person',
            'notes' => $request->notes ?? 'Reserva feita pelo website',
        ]);

        // Adicionar todos os quartos à reserva
        $reservation->rooms()->attach($roomIds);

        $roomsCount = count($roomIds);
        $message = $roomsCount > 1 
            ? "Reserva de {$roomsCount} quartos realizada com sucesso! Aguarde a confirmação do hotel."
            : "Reserva realizada com sucesso! Aguarde a confirmação do hotel.";

        return redirect()->route('public.reservation.success')->with('success', $message);
    }

    public function success()
    {
        return view('public.reservations.success');
    }
}
