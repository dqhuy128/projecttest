<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feature extends Model
{
    //
    protected $table = 'features';
    public $timestamps = false;

    const OPTIONS = [
        'big_home' => 'Banner to website - 1920 x 762 px',
    ];

    const SIZE = [
        'big_home' => ['width' => 1920, 'height' => 762],
    ];

    public static function getSize($type = 'big_home'){
        if(isset(self::SIZE[$type])){
            return (object)self::SIZE[$type];
        }
        return false;
    }

    public function getImageUrl($size = 'original'){
        return \ImageURL::getImageUrl($this->image, 'feature', $size);
    }

    public function lang(){
        $lang = config('app.locales');
        return isset($lang[$this->lang]) ? $lang[$this->lang] : 'vi';
    }

    public static function getSlides($position = 'fae_home', $lang = '', $limit = 0){
        if(empty($lang)){
            $lang = \Lib::getDefaultLang();
        }
        $data = self::where('lang', $lang)
            ->where('status', '>', 0)
            ->where('positions', 'LIKE', '%'.$position.'%');
        if($limit > 0){
            $data = $data->limit($limit);
        }
        return $data->get();
    }

    public static function getSlideByLangByOption($lang = 'vi'){
        return self::where([
            ['lang', '=', $lang],
            ['status', '>', 0],
        ])->get();
    }
    public static function getSlideByPositions($lang = '', $position = ''){
        $wery = self::where('status','>',0);
        $wery->where('lang', $lang);
        $wery->whereRaw("CONCAT(',',positions,',') like '%,".$position.",%'");
        return $wery;
    }

    public function getLink(){
        return \Lib::isUrl($this->link) ? $this->link : '#';
    }

    public function positions(){
        $all = explode(',', $this->positions);
        if(!empty($all)){
            $tmp = [];
            foreach ($all as $a){
                if(isset(self::OPTIONS[$a])){
                    $tmp[$a] = self::OPTIONS[$a];
                }
            }
            return $tmp;
        }
        return false;
    }
}
