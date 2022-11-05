<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    protected $table = 'recipe';
    public $timestamps = false;


    public static function getRecipe(){
        $wery = self::where('status','>',1)->orderByRaw('sort ASC')->get();
        return $wery;
    }
}