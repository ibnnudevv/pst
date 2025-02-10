<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ScoreLog extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'game_id',
        'home_score',
        'away_score',
        'updated_by',
        'note'
    ];

    public function game()
    {
        return $this->belongsTo(Game::class);
    }
}
