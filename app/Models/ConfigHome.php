<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\DocBlock\Description;

class ConfigHome extends Model
{
    //
    protected $table = '__configs_home';
    public $timestamps = false;
    protected $primaryKey = 'key';

    public static function setConfig($key = '', $value = '') {
        $record = ConfigHome::where('key', $key)->first();
        if(empty($record)){
            $record = new ConfigHome();
            $record->key = $key;
        }
        $record->value = $value;
        return $record->save();
    }

    public static function getConfig($key = '', $def = '') {

        $record = ConfigHome::where('key', $key)->first();
        if(!empty($record)){
            $data = $record->value;
            $value = !empty($data) ? json_decode($data, true) : null;
            if(!empty($value['image_sec3'])){
                $value['image_sec3_medium'] = \ImageURL::getImageUrl($value['image_sec3'], 'config_home', '570x570');
                $value['570x570'] = \ImageURL::getImageUrl($value['image_sec3'], 'config_home', '570x570');
            }
            if(!empty($value['image_sec4'])){
                $value['image_sec4_medium'] = \ImageURL::getImageUrl($value['image_sec4'], 'config_home', 'medium_seo');
                $value['1170x916'] = \ImageURL::getImageUrl($value['image_sec4'], 'config_home', '1170x916');
            }
            if(!empty($value['image_mobile_sec4'])){
                $value['image_mobile_sec4_medium'] = \ImageURL::getImageUrl($value['image_mobile_sec4'], 'config_home', 'medium_seo');
                $value['330x258'] = \ImageURL::getImageUrl($value['image_mobile_sec4'], 'config_home', '330x258');
                $value['350x350'] = \ImageURL::getImageUrl($value['image_mobile_sec4'], 'config_home', '350x350');
                $value['original'] = \ImageURL::getImageUrl($value['image_mobile_sec4'], 'config_home', 'original');
            }

            return json_encode($value);
        }
        return $def;
    }


}
