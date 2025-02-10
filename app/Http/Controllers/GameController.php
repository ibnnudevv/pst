<?php

namespace App\Http\Controllers;

use App\Events\ScoreUpdated;
use App\Models\Game;
use App\Models\ScoreLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class GameController extends Controller
{
    public function index()
    {
        $games = Game::where('status', Game::STATUS_IN_PROGRESS)->get();
        return view('games.index', compact('games'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'sport_type' => 'required|string',
            'home_team' => 'required|string',
            'away_team' => 'required|string',
        ]);

        $game = Game::create([
            ...$validated,
            'home_score' => 0,
            'away_score' => 0,
            'status' => 'active',
            'started_at' => now(),
        ]);

        return redirect()->route('games.show', $game);
    }

    public function updateScore(Request $request, Game $game)
    {
        $validated = $request->validate([
            'home_score' => 'required|integer|min:0',
            'away_score' => 'required|integer|min:0',
            'note' => 'nullable|string',
        ]);

        $game->update([
            'home_score' => $validated['home_score'],
            'away_score' => $validated['away_score'],
        ]);

        // Reload game untuk mendapatkan data terbaru
        $game = $game->fresh();

        ScoreLog::create([
            'game_id' => $game->id,
            'home_score' => $validated['home_score'],
            'away_score' => $validated['away_score'],
            'updated_by' => Auth::user()->id,
            'note' => $validated['note'] ?? null,
        ]);

        Log::info('Broadcasting score update', ['game' => $game->toArray()]);

        broadcast(new ScoreUpdated($game))->toOthers();

        return response()->json($game);
    }

    public function operator()
    {
        $games = Game::all();
        return view('games.operator', compact('games'));
    }
}
