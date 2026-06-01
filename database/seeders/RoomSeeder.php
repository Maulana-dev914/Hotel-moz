<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Room;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Quartos Solteiro
        for ($i = 101; $i <= 110; $i++) {
            Room::create([
                'number' => (string)$i,
                'type' => 'single',
                'price' => rand(150, 200),
                'status' => 'available',
                'max_adults' => 1,
                'max_children' => 0,
            ]);
        }

        // Quartos Duplo
        for ($i = 201; $i <= 215; $i++) {
            Room::create([
                'number' => (string)$i,
                'type' => 'double',
                'price' => rand(250, 300),
                'status' => 'available',
                'max_adults' => 2,
                'max_children' => 0,
            ]);
        }

        // Quartos Casal
        for ($i = 301; $i <= 320; $i++) {
            Room::create([
                'number' => (string)$i,
                'type' => 'matrimonial',
                'price' => rand(350, 450),
                'status' => 'available',
                'max_adults' => 2,
                'max_children' => 1,
            ]);
        }

        // Alguns quartos ocupados para exemplo
        Room::whereIn('number', ['201', '205', '301', '305'])->update(['status' => 'occupied']);

        // Um quarto em manutenção
        Room::where('number', '103')->update(['status' => 'maintenance']);
    }
}
