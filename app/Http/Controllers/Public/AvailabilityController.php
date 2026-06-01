<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\Reservation;
use App\Models\Stay;
use Illuminate\Http\Request;

class AvailabilityController extends Controller
{
    public function index()
    {
        return view('public.availability.index');
    }

    public function search(Request $request)
    {
        $request->validate([
            'check_in_date' => 'required|date|after_or_equal:today',
            'check_out_date' => 'required|date|after:check_in_date',
            'adults' => 'required|integer|min:1|max:50',
            'children' => 'required|integer|min:0|max:50',
        ]);

        $checkIn = $request->check_in_date;
        $checkOut = $request->check_out_date;
        $adults = (int)$request->adults;
        $children = (int)$request->children;
        $totalGuests = $adults + $children;

        // Quartos com reservas no período (incluindo tabela pivot)
        $reservations = Reservation::where('status', '!=', 'cancelada')
            ->where(function($query) use ($checkIn, $checkOut) {
                $query->whereBetween('check_in_date', [$checkIn, $checkOut])
                    ->orWhereBetween('check_out_date', [$checkIn, $checkOut])
                    ->orWhere(function($q) use ($checkIn, $checkOut) {
                        $q->where('check_in_date', '<=', $checkIn)
                          ->where('check_out_date', '>=', $checkOut);
                    });
            })
            ->with('rooms')
            ->get();
        
        $reservedRoomIds = collect();
        foreach ($reservations as $reservation) {
            // Quartos da tabela pivot
            if ($reservation->rooms->count() > 0) {
                $reservedRoomIds = $reservedRoomIds->merge($reservation->rooms->pluck('id'));
            }
            // Quarto principal (compatibilidade)
            if ($reservation->room_id) {
                $reservedRoomIds->push($reservation->room_id);
            }
        }
        $reservedRoomIds = $reservedRoomIds->unique();

        // Quartos com estadias ativas no período
        $occupiedRoomIds = Stay::where('status', 'active')
            ->where(function($query) use ($checkIn, $checkOut) {
                $query->whereBetween('check_in_at', [$checkIn, $checkOut])
                    ->orWhereBetween('expected_check_out_at', [$checkIn, $checkOut])
                    ->orWhere(function($q) use ($checkIn, $checkOut) {
                        $q->where('check_in_at', '<=', $checkIn)
                          ->where('expected_check_out_at', '>=', $checkOut);
                    });
            })
            ->pluck('room_id');

        // Quartos indisponíveis
        $unavailableRoomIds = $reservedRoomIds->merge($occupiedRoomIds)->unique();

        // Quartos disponíveis - filtrar apenas os que não estão reservados ou ocupados
        $availableRooms = Room::where('status', 'available')
            ->whereNotIn('id', $unavailableRoomIds->toArray())
            ->get();

        // Filtrar quartos por capacidade e criar sugestões
        $suggestedRooms = collect();
        $otherRooms = collect();

        foreach ($availableRooms as $room) {
            $roomCapacity = $room->max_adults + $room->max_children;
            
            // Quarto adequado se:
            // - Pode acomodar todos os adultos E
            // - Pode acomodar todas as crianças E
            // - Capacidade total é suficiente ou próxima
            if ($room->max_adults >= $adults && 
                $room->max_children >= $children && 
                $roomCapacity >= $totalGuests) {
                $suggestedRooms->push($room);
            } else {
                $otherRooms->push($room);
            }
        }

        // Ordenar sugestões: primeiro por capacidade total (menor primeiro), depois por preço
        $suggestedRooms = $suggestedRooms->sortBy(function($room) {
            return ($room->max_adults + $room->max_children) * 1000 + $room->price;
        })->values();

        // Combinar: sugestões primeiro, depois outros quartos
        $availableRooms = $suggestedRooms->merge($otherRooms);

        return view('public.availability.index', compact('availableRooms', 'suggestedRooms', 'checkIn', 'checkOut', 'adults', 'children', 'totalGuests'));
    }
}
