<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{

    protected $fillable = [
        'id', 'id_game','name'
    ];

    public function Game(){
        return $this->belongsTo(Game::Class);
    }

    public function Statistic(){
        return $this->hasOne(Statistic::Class, 'id_team');
    }

}
