<?php

namespace LurdesBot\Games\LeagueOfLegends\Entity;

use Illuminate\Database\Eloquent\Model;

class Champion extends Model {

    protected $table = 'champions';

    public function playTips() {
        return $this->hasMany(ChampionTip::class, 'champion', 'id');
    }

}