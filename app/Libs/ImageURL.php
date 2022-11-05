<?php

namespace App\Libs;

use Carbon\Carbon;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\File;

define('AVATAR_SET','default'); // directory where avatars are stored
define('LETTER_INDEX', 0); // 0: first letter; 1: second letter; -1: last letter, etc.
define('IMAGES_FORMAT','png'); // file format of the avatars
define('IMAGE_UNKNOWN','unknown');
define('IMAGES_PATH','upload/avatars');
define('PROJECT_URL',config("APP_URL"));

class ImageURL
{
    const DEFAULT_DIR = 'upload';
    const DEFAULT_DIR_ORIGINAL = 'original';
    const DEFAULT_DIR_FILE = 'files';
    const DEFAULT_DIR_THUMB = 'thumb';
    const DEFAULT_NO_IMAGE = 'no_photo.png';
    const QUALITY = 80;
    public static $data = [];
    
    public static function getImageUrl($file_name, $key, $sizeName, $only_path = false)
    {
        if ($key == 'installment_bank') {
            $key = '';
        }

//        $sizeName = 'original';
        $dir  = self::getDir($key);
        $size = self::getSize($key, $sizeName);
        $width = $size['width'];
        $height = $size['height'];
        $path = self::DEFAULT_DIR . '/' . self::DEFAULT_NO_IMAGE;
        if ($file_name != '') {
            if ($width == 0 && $height == 0) {
                $path = $dir . '/' . self::DEFAULT_DIR_ORIGINAL . '/' . $file_name;
            } else {
                $path = $dir . '/' . self::DEFAULT_DIR_THUMB . '_' . $width . 'x' . $height . '/' . $file_name;
            }
        }

        if ($only_path) {
            if ($width == 0 && $height == 0) {
                $path = $dir . '/' . self::DEFAULT_DIR_ORIGINAL . '/' . ($file_name ? $file_name : '');
            } else {
                $path = $dir . '/' . self::DEFAULT_DIR_THUMB . '_' . $width . 'x' . $height . '/' . ($file_name ? $file_name : '');
            }
        }

        $env = env('APP_ENV', 'local');
        if($env == 'local' || $env == 'product-dev') {
            return env('APP_URL') .'/'. $path;
        }
        return asset($path);
    }

    public static function imageUrlTodo($file_name, $key, $sizeName, $only_path = false): string
    {
//        $sizeName = 'original';
        $dir  = self::getDir($key);
        $size = self::getSize($key, $sizeName);
        $width = $size['width'];
        $height = $size['height'];
        $path = self::DEFAULT_DIR . '/' . self::DEFAULT_NO_IMAGE;
        if ($file_name != '') {
            if ($width == 0 && $height == 0) {
                $path = $dir . '/' . self::DEFAULT_DIR_ORIGINAL . '/' . $file_name;
            } else {
                $path = $dir . '/' . self::DEFAULT_DIR_THUMB . '_' . $width . 'x' . $height . '/' . $file_name;
            }
        }

        if ($only_path) {
            if ($width == 0 && $height == 0) {
                $path = $dir . '/' . self::DEFAULT_DIR_ORIGINAL . '/' . ($file_name ? $file_name : '');
            } else {
                $path = $dir . '/' . self::DEFAULT_DIR_THUMB . '_' . $width . 'x' . $height . '/' . ($file_name ? $file_name : '');
            }
        }

        return asset($path);
    }

    public static function upload($sourceFile, $filename, $key, $time = '', &$err='') {
//        if($time == ''){
//            $time = Carbon::createFromTimestamp(1638174792);
//        }

        return self::clone($sourceFile, $filename, $key, $time, $err);
    }
    public static function clone($sourceFile, $filename, $key, $time, &$err=''){
        $dir = self::getDirByTime($key, $time, true);

        //create dir if not existed
        if (! File::exists($dir)) {
            File::makeDirectory($dir, 0755, true);
        }
        try {
            return File::copy($sourceFile, $dir . '/' . $filename);
        }catch (\Exception $e){
            $err = $e->getMessage();
        }
        return false;
    }
    protected static function getDirByTime($key, $time, $isPath = false){
        //default dir
        $dir = self::getDir($key);
        $dir .= '/' . self::DEFAULT_DIR_ORIGINAL;

//        $dir = sprintf('%s/%s', $dir, self::getFileDir());
//
//
//        //dir by time
//        $dir = sprintf('%s/%d/%d/%d', $dir, $time->year, $time->month, $time->day);

        return $isPath ? public_path($dir) : asset($dir);
    }
    protected static function getFileDir(){
        return self::getConfig('file_dir', self::DEFAULT_DIR_FILE);
    }
//    public static function upload($image, $filename, $key, &$err = '')
//    {
//        $dir = public_path(self::getDir($key));
//        $dir .= '/' . self::DEFAULT_DIR_ORIGINAL;
//
//        //create dir if not existed
//        if (!\File::exists($dir)) {
//            \File::makeDirectory($dir, 0755, true);
//        }
//
//        //create image from source
//        $image = \Image::make($image);
//
//        return $image->save($dir . '/' . $filename, self::QUALITY);
//    }

    public static function autoGenImageFromURL($path = '')
    {
        if (!empty($path)) {
            $path = explode('/', $path);
            $filename = array_pop($path);
            $thumb_str = array_pop($path);
            $key = array_pop($path);

            //process thumb_str
            $thumb_str = str_replace(self::DEFAULT_DIR_THUMB . '_', '', $thumb_str);
            $thumb_str = explode('x', $thumb_str);

            $sizeName = self::getSizeName($key, $thumb_str[0], $thumb_str[1]);
            if (!empty($sizeName)) {
                $ret = self::thumb($filename, $key, $sizeName);
                if ($ret) {
                    return $ret;
                }
            }
        }
        return \Image::make(public_path(self::DEFAULT_DIR) . '/' . self::DEFAULT_NO_IMAGE)
            ->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            });
    }

    public static function makeFileName($fname, $tail)
    {
        return substr(str_slug($fname), 0, 100) . '-' . time() . "." . $tail;
        //        return str_replace('-', '_', $fname) . '_' . time() . "." . $tail;
    }

    protected static function thumb($filename, $key, $sizeName)
    {
        $dir = public_path(self::getDir($key));
        $original = $dir . '/' . self::DEFAULT_DIR_ORIGINAL . '/' . $filename;
        if (!\File::exists($original)) {
            return false;
        }

        $size = self::getSize($key, $sizeName);
        $width = $size['width'];
        $height = $size['height'];

        $path = $dir . '/' . self::DEFAULT_DIR_THUMB . '_' . $width . 'x' . $height;
        //create dir if not existed
        if (!\File::exists($path)) {
            \File::makeDirectory($path, 0755, true);
        }

        $filename = $path . '/' . $filename;
        //create image from original
        $image = \Image::make($original);
        return $image
            ->resize($width > 0 ? $width : null, $height > 0 ? $height : null, function ($constraint) {
                $constraint->aspectRatio();
            })
            ->save($filename, self::QUALITY);
    }

    public static function getDir($key)
    {
        self::getConfig();
        $dir = self::DEFAULT_DIR;
        if (isset(self::$data[$key]['dir'])) {
            $dir .= '/' . self::$data[$key]['dir'];
        }
        return $dir;
    }

    protected static function getSize($key, $sizeName)
    {
        self::getConfig();
        if (isset(self::$data[$key]) && isset(self::$data[$key]['size'][$sizeName])) {
            return self::$data[$key]['size'][$sizeName];
        }
        return ['width' => 0, 'height' => 0];
    }

    protected static function getSizeName($key, $with = 0, $height = 0)
    {
        self::getConfig();
        if (isset(self::$data[$key])) {
            foreach (self::$data[$key]['size'] as $k => $size) {
                if ($size['width'] == $with && $size['height'] == $height) {
                    return $k;
                }
            }
        }
        return '';
    }

    protected static function maxSize($key)
    {
        self::getConfig();
        if (isset(self::$data[$key])) {
            return self::$data[$key]['max'];
        }
        return [];
    }
    static function getConfig()
    {
        if (empty(self::$data)) {
            $default = config('image.defaultImg');
            self::$data = config('image.data');
            foreach (self::$data as $k => $v) {
                self::$data[$k]['dir'] = $k;
                foreach ($default as $kd => $vd) {
                    if (!isset(self::$data[$k][$kd])) {
                        self::$data[$k][$kd] = $vd;
                    }
                }
                foreach ($v as $kk => $vv) {
                    if (isset($default[$kk])) {
                        self::$data[$k][$kk] = array_merge($default[$kk], self::$data[$k][$kk]);
                    }
                }
            }
        }
    }

    function createAvatarImage($string, $folder = 'avatars')
    {

        $imageFilePath = $folder . "/" . $string . ".png";

        //base avatar image that we use to center our text string on top of it.
        $avatar = imagecreatetruecolor(60, 60);
        $bg_color = imagecolorallocate($avatar, 211, 211, 211);
        imagefill($avatar, 0, 0, $bg_color);
        $avatar_text_color = imagecolorallocate($avatar, 0, 0, 0);
        // Load the gd font and write 
        $font = imageloadfont('gd-files/gd-font.gdf');
        imagestring($avatar, $font, 10, 10, $string, $avatar_text_color);
        imagepng($avatar, $imageFilePath);
        imagedestroy($avatar);

        return $imageFilePath;
    }

    static function generate_first_letter_avtar_url($name, $size = 90)
    {
        // get picture filename (and lowercase it) from commenter name:
        if (empty($name)) { // if, for some reason, the name is empty, set file_name to default unknown image

            $file_name = IMAGE_UNKNOWN;
        } else { // name is not empty, so we can proceed

            $file_name = substr($name, LETTER_INDEX, 1); // get one letter counting from letter_index
            $file_name = strtolower($file_name); // lowercase it...

            if (extension_loaded('mbstring')) { // check if mbstring is loaded to allow multibyte string operations
                $file_name_mb = mb_substr($name, LETTER_INDEX, 1); // repeat, this time with multibyte functions
                $file_name_mb = mb_strtolower($file_name_mb); // and again...
            } else { // mbstring is not loaded - we're not going to worry about it, just use the original string
                $file_name_mb = $file_name;
            }

            // couple of exceptions:
            if ($file_name_mb == 'ą') {
                $file_name = 'a';
                $file_name_mb = 'a';
            } else if ($file_name_mb == 'ć') {
                $file_name = 'c';
                $file_name_mb = 'c';
            } else if ($file_name_mb == 'ę') {
                $file_name = 'e';
                $file_name_mb = 'e';
            } else if ($file_name_mb == 'ń') {
                $file_name = 'n';
                $file_name_mb = 'n';
            } else if ($file_name_mb == 'ó') {
                $file_name = 'o';
                $file_name_mb = 'o';
            } else if ($file_name_mb == 'ś') {
                $file_name = 's';
                $file_name_mb = 's';
            } else if ($file_name_mb == 'ż' || $file_name_mb == 'ź') {
                $file_name = 'z';
                $file_name_mb = 'z';
            }

            // create arrays with allowed character ranges:
            $allowed_numbers = range(0, 9);
            foreach ($allowed_numbers as $number) { // cast each item to string (strict param of in_array requires same type)
                $allowed_numbers[$number] = (string)$number;
            }
            $allowed_letters_latin = range('a', 'z');
            $allowed_letters_cyrillic = range('а', 'ё');
            $allowed_letters_arabic = range('آ', 'ی');
            // check if the file name meets the requirement; if it doesn't - set it to unknown
            $charset_flag = ''; // this will be used to determine whether we are using latin chars, cyrillic chars, arabic chars or numbers
            // check whther we are using latin/cyrillic/numbers and set the flag, so we can later act appropriately:
            if (in_array($file_name, $allowed_numbers, true)) {
                $charset_flag = 'number';
            } else if (in_array($file_name, $allowed_letters_latin, true)) {
                $charset_flag = 'latin';
            } else if (in_array($file_name, $allowed_letters_cyrillic, true)) {
                $charset_flag = 'cyrillic';
            } else if (in_array($file_name, $allowed_letters_arabic, true)) {
                $charset_flag = 'arabic';
            } else { // for some reason none of the charsets is appropriate
                $file_name = IMAGE_UNKNOWN; // set it to uknknown
            }

            if (!empty($charset_flag)) { // if charset_flag is not empty, i.e. flag has been set to latin, number or cyrillic...
                switch ($charset_flag) { // run through various options to determine the actual filename for the letter avatar
                    case 'number':
                        $file_name = 'number_' . $file_name;
                        break;
                    case 'latin':
                        $file_name = 'latin_' . $file_name;
                        break;
                    case 'cyrillic':
                        $temp_array = unpack('V', iconv('UTF-8', 'UCS-4LE', $file_name_mb));
                        $unicode_code_point = $temp_array[1];
                        $file_name = 'cyrillic_' . $unicode_code_point;
                        break;
                    case 'arabic':
                        $temp_array = unpack('V', iconv('UTF-8', 'UCS-4LE', $file_name_mb));
                        $unicode_code_point = $temp_array[1];
                        $file_name = 'arabic_' . $unicode_code_point;
                        break;
                    default:
                        $file_name = IMAGE_UNKNOWN; // set it to uknknown
                        break;
                }
            }
        }
        // detect most appropriate size based on avatar size:
        if ($size <= 48) $custom_avatar_size = '48';
        else if ($size > 48 && $size <= 96) $custom_avatar_size = '96';
        else if ($size > 96 && $size <= 128) $custom_avatar_size = '128';
        else if ($size > 128 && $size <= 256) $custom_avatar_size = '256';
        else $custom_avatar_size = '512'; // create file path - $avatar_uri variable. 
        $avatar_uri = PROJECT_URL.'/' . IMAGES_PATH . '/' . AVATAR_SET . '/' . $custom_avatar_size . '/' . $file_name . '.' . IMAGES_FORMAT; // return the final first letter image url: 
        return $avatar_uri;
    }
}
