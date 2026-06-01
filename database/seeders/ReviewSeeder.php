<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Review;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $reviews = [
            [
                'name' => 'João Silva',
                'email' => 'joao.silva@email.com',
                'rating' => 5,
                'comment' => 'Excelente hotel! Atendimento impecável, quartos limpos e confortáveis. Recomendo muito!',
                'approved' => true,
            ],
            [
                'name' => 'Maria Santos',
                'email' => 'maria.santos@email.com',
                'rating' => 5,
                'comment' => 'Experiência maravilhosa! O hotel superou todas as expectativas. Voltarei com certeza.',
                'approved' => true,
            ],
            [
                'name' => 'Pedro Oliveira',
                'email' => 'pedro.oliveira@email.com',
                'rating' => 4,
                'comment' => 'Ótimo hotel, bem localizado. O café da manhã estava delicioso. Única ressalva foi o Wi-Fi um pouco lento.',
                'approved' => true,
            ],
            [
                'name' => 'Ana Costa',
                'email' => 'ana.costa@email.com',
                'rating' => 5,
                'comment' => 'Perfeito! Quarto espaçoso, cama confortável e equipe muito atenciosa. Nota 10!',
                'approved' => true,
            ],
            [
                'name' => 'Carlos Ferreira',
                'email' => 'carlos.ferreira@email.com',
                'rating' => 4,
                'comment' => 'Bom hotel, preço justo. A localização é excelente e o atendimento foi cordial.',
                'approved' => true,
            ],
            [
                'name' => 'Juliana Alves',
                'email' => 'juliana.alves@email.com',
                'rating' => 5,
                'comment' => 'Adorei minha estadia! Tudo perfeito, desde o check-in até o check-out. Muito organizado!',
                'approved' => true,
            ],
            [
                'name' => 'Roberto Lima',
                'email' => 'roberto.lima@email.com',
                'rating' => 3,
                'comment' => 'Hotel razoável, mas poderia melhorar alguns detalhes. O quarto estava limpo, mas o banheiro precisava de manutenção.',
                'approved' => false,
            ],
            [
                'name' => 'Fernanda Rocha',
                'email' => 'fernanda.rocha@email.com',
                'rating' => 5,
                'comment' => 'Simplesmente perfeito! Melhor hotel que já me hospedei. Equipe excepcional!',
                'approved' => true,
            ],
            [
                'name' => 'Lucas Martins',
                'email' => 'lucas.martins@email.com',
                'rating' => 4,
                'comment' => 'Boa experiência geral. O hotel é moderno e bem cuidado. Recomendo!',
                'approved' => true,
            ],
            [
                'name' => 'Patricia Gomes',
                'email' => 'patricia.gomes@email.com',
                'rating' => 5,
                'comment' => 'Excelente! Superou todas as expectativas. Com certeza voltarei!',
                'approved' => true,
            ],
            [
                'name' => 'Ricardo Souza',
                'email' => 'ricardo.souza@email.com',
                'rating' => 4,
                'comment' => 'Ótimo custo-benefício. Hotel limpo e organizado, equipe prestativa.',
                'approved' => false,
            ],
            [
                'name' => 'Camila Ribeiro',
                'email' => 'camila.ribeiro@email.com',
                'rating' => 5,
                'comment' => 'Perfeito em todos os aspectos! Quarto lindo, atendimento de primeira. Nota máxima!',
                'approved' => true,
            ],
        ];

        foreach ($reviews as $review) {
            Review::create($review);
        }
    }
}
