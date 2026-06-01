<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Reservation;
use App\Models\Guest;
use App\Models\Room;
use Carbon\Carbon;

class ReservationSeeder extends Seeder
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

        // Reservas confirmadas
        for ($i = 0; $i < 5; $i++) {
            $checkIn = Carbon::now()->addDays(rand(1, 30));
            $checkOut = $checkIn->copy()->addDays(rand(1, 5));

            Reservation::create([
                'guest_id' => $guests->random()->id,
                'room_id' => $rooms->random()->id,
                'check_in_date' => $checkIn,
                'check_out_date' => $checkOut,
                'status' => 'confirmada',
                'notes' => 'Reserva confirmada via seeder',
            ]);
        }

        // Reservas pendentes
        for ($i = 0; $i < 3; $i++) {
            $checkIn = Carbon::now()->addDays(rand(1, 30));
            $checkOut = $checkIn->copy()->addDays(rand(1, 5));

            Reservation::create([
                'guest_id' => $guests->random()->id,
                'room_id' => $rooms->random()->id,
                'check_in_date' => $checkIn,
                'check_out_date' => $checkOut,
                'status' => 'pendente',
                'notes' => 'Aguardando confirmação',
            ]);
        }

        // Algumas reservas canceladas
        for ($i = 0; $i < 2; $i++) {
            $checkIn = Carbon::now()->subDays(rand(1, 10));
            $checkOut = $checkIn->copy()->addDays(rand(1, 5));

            Reservation::create([
                'guest_id' => $guests->random()->id,
                'room_id' => $rooms->random()->id,
                'check_in_date' => $checkIn,
                'check_out_date' => $checkOut,
                'status' => 'cancelada',
                'notes' => 'Reserva cancelada',
            ]);
        }
    }
}
