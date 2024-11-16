<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Giveback extends Model
{
    use HasFactory;

    protected $table = 'givebacks';

    public function game_record()
    {
        return $this->belongsTo(GameRecord::class, 'game_record_id', 'id');
    }
}
