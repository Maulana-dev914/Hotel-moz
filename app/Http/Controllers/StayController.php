<?php

namespace App\Http\Controllers;

use App\Models\Stay;
use App\Models\Room;
use App\Models\Guest;
use App\Models\Reservation;
use App\Http\Requests\StoreStayRequest;
use App\Http\Requests\UpdateStayRequest;
use Illuminate\Http\Request;

class StayController extends Controller
{
    public function index()
    {
        $stays = Stay::with(['guest', 'room'])->orderBy('created_at', 'desc')->paginate(15);
        return view('admin.stays.index', compact('stays'));
    }

    public function create()
    {
        $guests = Guest::orderBy('name')->get();
        $rooms = Room::where('status', 'available')->orderBy('number')->get();
        $reservations = Reservation::where('status', 'confirmada')
            ->whereDoesntHave('stay')
            ->with(['guest', 'room', 'rooms'])
            ->orderBy('check_in_date')
            ->get();
        
        $reservation = null;
        if (request('reservation_id')) {
            $reservation = Reservation::with(['guest', 'room', 'rooms'])->find(request('reservation_id'));
        }
        
        return view('admin.stays.create', compact('guests', 'rooms', 'reservations', 'reservation'));
    }

    public function store(StoreStayRequest $request)
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

        // Criar estadia com o primeiro quarto (para compatibilidade)
        $stayData = $request->validated();
        $stayData['room_id'] = $roomIds[0]; // Manter para compatibilidade
        unset($stayData['room_ids']);
        
        $stay = Stay::create($stayData);
        
        // Adicionar todos os quartos à estadia
        $stay->rooms()->attach($roomIds);
        
        // Atualizar status de todos os quartos para ocupado
        foreach ($rooms as $room) {
            $room->update(['status' => 'occupied']);
        }

        // Se veio de uma reserva, atualizar status da reserva
        if ($request->reservation_id) {
            $reservation = Reservation::find($request->reservation_id);
            if ($reservation) {
                $reservation->update(['status' => 'confirmada']);
            }
        }

        $roomsCount = count($roomIds);
        $message = $roomsCount > 1 
            ? "Check-in de {$roomsCount} quartos realizado com sucesso!"
            : "Check-in realizado com sucesso!";

        return redirect()->route('admin.stays.index')->with('success', $message);
    }

    public function show(Stay $stay)
    {
        $stay->load(['guest', 'room', 'reservation']);
        return view('admin.stays.show', compact('stay'));
    }

    public function checkout(Stay $stay)
    {
        if ($stay->status === 'completed') {
            return back()->with('error', 'Esta estadia já foi finalizada.');
        }

        $stay->update([
            'actual_check_out_at' => now(),
            'status' => 'completed'
        ]);

        // Liberar todos os quartos da estadia
        $stay->room->update(['status' => 'available']);
        foreach ($stay->rooms as $room) {
            $room->update(['status' => 'available']);
        }

        return redirect()->route('admin.stays.index')->with('success', 'Check-out realizado com sucesso!');
    }

    public function destroy(Stay $stay)
    {
        if ($stay->status === 'active') {
            $stay->room->update(['status' => 'available']);
            foreach ($stay->rooms as $room) {
                $room->update(['status' => 'available']);
            }
        }
        $stay->delete();
        return redirect()->route('admin.stays.index')->with('success', 'Estadia excluída com sucesso!');
    }
}
