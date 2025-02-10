<?php

namespace Database\Seeders;

use App\Models\Game;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $games = [
            [
                'sport_type' => 'Basketball',
                'home_team' => 'Lakers',
                'away_team' => 'Warriors',
                'home_score' => 0,
                'away_score' => 0,
                'status' => 'in_progress',
                'started_at' => now(),
                'ended_at' => null, // Tambahkan null untuk konsistensi
            ],
            [
                'sport_type' => 'Soccer',
                'home_team' => 'Real Madrid',
                'away_team' => 'Barcelona',
                'home_score' => 0,
                'away_score' => 0,
                'status' => 'in_progress',
                'started_at' => now(),
                'ended_at' => null, // Tambahkan null
            ],
            [
                'sport_type' => 'Football',
                'home_team' => 'Patriots',
                'away_team' => 'Steelers',
                'home_score' => 0,
                'away_score' => 0,
                'status' => 'finished',
                'started_at' => now(),
                'ended_at' => now()->addHours(2),
            ],
        ];

        Game::insert($games);
    }
}
