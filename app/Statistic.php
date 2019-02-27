<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Statistic extends Model
{
    public function Team(){
        return $this->belongsTo(Team::Class);
    }
}
