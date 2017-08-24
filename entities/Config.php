<?php

namespace Entity;

use Illuminate\Database\Eloquent\Model;

class Config extends Model {

    protected $table = 'config';

    public static $config;

    public static function getConfig() {
        return self::where('active', 1)->first()->toArray();
    }

}