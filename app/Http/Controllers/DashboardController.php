<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Reservation;
use App\Models\Stay;
use App\Models\Guest;
use App\Models\Review;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Verificação adicional de autenticação (já protegido pelo middleware, mas garantia extra)
        if (!session()->has('user_id')) {
            return redirect()->route('admin.login')->with('error', 'Você precisa fazer login para acessar o painel administrativo.');
        }
        $availableRooms = Room::where('status', 'available')->count();
        $occupiedRooms = Room::where('status', 'occupied')->count();
        $maintenanceRooms = Room::where('status', 'maintenance')->count();
        $totalRooms = Room::count();
        
        $pendingReservations = Reservation::where('status', 'pendente')->count();
        $confirmedReservations = Reservation::where('status', 'confirmada')->count();
        $totalReservations = Reservation::count();
        
        // Calcular quartos reservados (através de reservas ativas no período atual)
        $activeReservations = Reservation::whereIn('status', ['pendente', 'confirmada'])
            ->where(function($query) {
                $query->where('check_in_date', '<=', now()->toDateString())
                      ->where('check_out_date', '>=', now()->toDateString());
            })
            ->with('rooms')
            ->get();
        
        $reservedRoomsCount = 0;
        foreach ($activeReservations as $reservation) {
            if ($reservation->rooms->count() > 0) {
                $reservedRoomsCount += $reservation->rooms->count();
            } else {
                // Se não tiver na pivot, conta o quarto principal
                $reservedRoomsCount += 1;
            }
        }
        
        $activeStays = Stay::where('status', 'active')->count();
        $completedStays = Stay::where('status', 'completed')->count();
        
        $totalGuests = Guest::count();
        $totalReviews = Review::count();
        $approvedReviews = Review::where('approved', true)->count();
        $pendingReviews = Review::where('approved', false)->count();
        
        $recentReviews = Review::orderBy('created_at', 'desc')->take(5)->get();
        $recentReservations = Reservation::with(['guest', 'room', 'rooms'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
        
        $recentStays = Stay::with(['guest', 'room'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('admin.dashboard.index', compact(
            'availableRooms',
            'occupiedRooms',
            'maintenanceRooms',
            'totalRooms',
            'pendingReservations',
            'confirmedReservations',
            'totalReservations',
            'reservedRoomsCount',
            'activeStays',
            'completedStays',
            'totalGuests',
            'totalReviews',
            'approvedReviews',
            'pendingReviews',
            'recentReviews',
            'recentReservations',
            'recentStays'
        ));
    }
}
