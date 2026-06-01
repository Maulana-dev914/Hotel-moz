<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Guest;

class GuestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $guests = [
            [
                'name' => 'João Silva',
                'document' => '12345678900',
                'phone' => '(11) 98765-4321',
                'email' => 'joao.silva@email.com',
            ],
            [
                'name' => 'Maria Santos',
                'document' => '98765432100',
                'phone' => '(11) 91234-5678',
                'email' => 'maria.santos@email.com',
            ],
            [
                'name' => 'Pedro Oliveira',
                'document' => '11122233344',
                'phone' => '(21) 99876-5432',
                'email' => 'pedro.oliveira@email.com',
            ],
            [
                'name' => 'Ana Costa',
                'document' => '55566677788',
                'phone' => '(31) 98765-1234',
                'email' => 'ana.costa@email.com',
            ],
            [
                'name' => 'Carlos Ferreira',
                'document' => '99988877766',
                'phone' => '(41) 91234-5678',
                'email' => 'carlos.ferreira@email.com',
            ],
            [
                'name' => 'Juliana Alves',
                'document' => '44433322211',
                'phone' => '(51) 99876-5432',
                'email' => 'juliana.alves@email.com',
            ],
            [
                'name' => 'Roberto Lima',
                'document' => '77788899900',
                'phone' => '(61) 98765-4321',
                'email' => 'roberto.lima@email.com',
            ],
            [
                'name' => 'Fernanda Rocha',
                'document' => '22233344455',
                'phone' => '(71) 91234-5678',
                'email' => 'fernanda.rocha@email.com',
            ],
            [
                'name' => 'Lucas Martins',
                'document' => '66677788899',
                'phone' => '(81) 99876-5432',
                'email' => 'lucas.martins@email.com',
            ],
            [
                'name' => 'Patricia Gomes',
                'document' => '33344455566',
                'phone' => '(85) 98765-1234',
                'email' => 'patricia.gomes@email.com',
            ],
        ];

        foreach ($guests as $guest) {
            Guest::create($guest);
        }
    }
}
