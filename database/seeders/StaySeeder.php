<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Stay;
use App\Models\Guest;
use App\Models\Room;
use App\Models\Reservation;
use Carbon\Carbon;

class StaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $guests = Guest::all();
        $rooms = Room::where('status', 'available')->get();

        if ($guests->isEmpty() || $rooms->isEmpty()) {
            return;
        }

        // Criar algumas estadias ativas
        for ($i = 0; $i < 3; $i++) {
            $checkIn = Carbon::now()->subDays(rand(1, 5));
            $checkOut = $checkIn->copy()->addDays(rand(2, 7));

            $room = $rooms->random();
            
            Stay::create([
                'guest_id' => $guests->random()->id,
                'room_id' => $room->id,
                'reservation_id' => null,
                'check_in_at' => $checkIn,
                'expected_check_out_at' => $checkOut,
                'actual_check_out_at' => null,
                'status' => 'active',
                'notes' => 'Estadia criada via seeder',
            ]);

            // Atualizar status do quarto para ocupado
            $room->update(['status' => 'occupied']);
        }

        // Criar algumas estadias finalizadas
        for ($i = 0; $i < 5; $i++) {
            $checkIn = Carbon::now()->subDays(rand(10, 30));
            $checkOut = $checkIn->copy()->addDays(rand(2, 5));
            $actualCheckOut = $checkOut->copy()->addHours(rand(0, 2));

            Stay::create([
                'guest_id' => $guests->random()->id,
                'room_id' => $rooms->random()->id,
                'reservation_id' => null,
                'check_in_at' => $checkIn,
                'expected_check_out_at' => $checkOut,
                'actual_check_out_at' => $actualCheckOut,
                'status' => 'completed',
                'notes' => 'Estadia finalizada',
            ]);
        }

        // Criar estadias a partir de reservas confirmadas
        $confirmedReservations = Reservation::where('status', 'confirmada')
            ->whereDoesntHave('stay')
            ->where('check_in_date', '<=', Carbon::now())
            ->take(2)
            ->get();

        foreach ($confirmedReservations as $reservation) {
            $room = $reservation->room;
            
            Stay::create([
                'guest_id' => $reservation->guest_id,
                'room_id' => $reservation->room_id,
                'reservation_id' => $reservation->id,
                'check_in_at' => $reservation->check_in_date->startOfDay(),
                'expected_check_out_at' => $reservation->check_out_date->endOfDay(),
                'actual_check_out_at' => null,
                'status' => 'active',
                'notes' => 'Check-in realizado a partir de reserva',
            ]);

            // Atualizar status do quarto
            $room->update(['status' => 'occupied']);
        }
    }
}
