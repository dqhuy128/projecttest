<?php

namespace App\Models;

use App\Libs\Lib;
use function GuzzleHttp\Psr7\str;
use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\DocBlock\Description;

class Menu extends Model
{
    //
    protected $table = 'menu';
    public $timestamps = false;
    protected static $splitKey = '_';
    const KEY = 'menu';
    public static $menuType = [
        0 => 'Admin Left Menu',
//        1 => 'Admin Top Menu',
//        2 => 'Admin Bottom Menu',
        3 => 'Public Header Menu',
//        4 => 'Public Footer Menu',
//        5 => 'Mobile Menu',
//        9 => 'Khác'
    ];
    protected static $menu = [];
    const DEF_MENU_KEY = '99999999999';

    public function lang(){
        $lang = config('app.locales');
        return isset($lang[$this->lang]) ? $lang[$this->lang] : 'vi';
    }

    public function type(){
        return self::$menuType[$this->type];
    }

    public function getLink(){
//        dd($this);
        $def = '#';
        if(!empty($this->link)) {
            if(\Lib::isUrl($this->link)){
                return $this->link;
            }
            return \Route::has($this->link) ? route($this->link) : $def.$this->link;
        }
        return $def;
    }

    public static function getMenu($type = 0, $sys_menu_ok = false, $lang = ''){
        if(empty($lang)){
            $lang = \Lib::getDefaultLang();
        }
        $key = $type . '-' . $lang;
        if(empty(self::$menu[$key])) {
            $sql = [];
            if ($type >= 0) {
                $sql[] = ['type', '=', $type];
            }
            $sql[] = ['lang', '=', $lang];
            $sql[] = ['status', '>', 0];

            $data = self::where($sql)
                ->orderByRaw('type, pid, sort DESC, title')
                ->get()
                ->keyBy('id');
            $menu = [];
            if ($type < 0) {
                foreach ($data as $k => $v) {
                    if (!isset($menu[$v->type])) {
                        $menu[$v->type] = [
                            'title' => isset(self::$menuType[$v->type]) ? self::$menuType[$v->type] : '',
                            'type' => $v->type,
                            'is_selling' => $v->is_selling,
                            'menu' => []
                        ];
                    }
                    $menu[$v->type]['menu'][$v->id] = $v;
                }
                foreach ($menu as $k => $v){
                    $menu[$k]['menu'] = self::fetchAll($v['menu'], $sys_menu_ok && ($type == 0));
                }
            } else {
//                dd($data);
                $menu = self::fetchAll($data, $sys_menu_ok && ($type == 0));
            }
            self::$menu[$key] = $menu;
        }
        return self::$menu[$key];
    }
    public static function getMenuWithFilter($type = 0, $sys_menu_ok = false, $lang = ''){
        if(empty($lang)){
            $lang = \Lib::getDefaultLang();
        }
        $key = $type . '-' . $lang;
        if(empty(self::$menu[$key])) {
            $sql = [];
            if ($type >= 0) {
                $sql[] = ['type', '=', $type];
            }
            $sql[] = ['lang', '=', $lang];
            $sql[] = ['status', '>', 0];

            $data = self::where($sql)
                ->orderByRaw('type, pid, sort DESC, title')
                ->get()
                ->keyBy('id');
            $menu = [];
            if ($type < 0) {
                foreach ($data as $k => $v) {
                    if (!isset($menu[$v->type])) {
                        $menu[$v->type] = [
                            'title' => self::$menuType[$v->type],
                            'type' => $v->type,
                            'is_selling' => $v->is_selling,
                            'menu' => []
                        ];
                    }
                    $menu[$v->type]['menu'][$v->id] = $v;
                }
                foreach ($menu as $k => $v){
                    $menu[$k]['menu'] = self::fetchAll($v['menu'], $sys_menu_ok && ($type == 0));
                }
            } else {
//                dd($data);
                $menu = self::fetchAll($data, $sys_menu_ok && ($type == 0));
            }
            self::$menu[$key] = $menu;
        }
        return self::$menu[$key];
    }

    public static function fetchAll($data, $sys_menu = false){
        $menu = [];
        foreach ($data as $k => $v) {
            if ($v->pid == 0) {
                $menu[self::$splitKey.$v->id] = self::fetchMenu($v);
                unset($data[$k]);
            } elseif (isset($menu[self::$splitKey.$v->pid])) {
                $menu[self::$splitKey.$v->pid]['sub'][self::$splitKey.$v->id] = self::fetchMenu($v);
                unset($data[$k]);
            }
        }
        foreach ($data as $v) {
            foreach ($menu as $pid => $item){
                foreach ($item['sub'] as $id => $sub){
                    if(self::$splitKey.$v->pid == $id){
                        $menu[$pid]['sub'][$id]['sub'][self::$splitKey.$v->id] = self::fetchMenu($v);
                    }
                }
            }
        }
        if($sys_menu){
            $menu[self::$splitKey.self::DEF_MENU_KEY] = self::defAdminMenu();
        }
        return $menu;
    }

    public static function fetchMenu($menu){
        $selling = [];
        if (!empty($menu->id_selling)){
            foreach (explode(',', $menu->id_selling) as $sell){
                $selling [] = $sell;
            }
        }
        // $pro  = Product::where('status', '>', 1)->whereIn('id', $selling)->limit(3)->get()->toArray();
        $out = [
            'id' => $menu->id,
            'title' => $menu->title,
            'link' => $menu->getLink(),
            'perm' => !empty($menu->perm) ? $menu->perm : '',
            'no_follow' => !empty($menu->no_follow) ? $menu->no_follow : 1,
            'newtab' => !empty($menu->newtab) ? $menu->newtab : 0,
            'icon' => !empty($menu->icon) ? $menu->icon : '',
            'sub' => [],
            'img_icon' => $menu->img_icon,
            'img_icon_mobile' => $menu->img_icon_mobile,
            'image' => $menu->image,
            'banner_link' => $menu->banner_link,
            'cat_id' => $menu->cat_id,
            'safe_title' => $menu->safe_title,
            'is_selling' => [],//$pro,
            'cat_id_footer' => $menu->cat_id_footer,
            'tab' => $menu->tab,
            'sort' => $menu->sort
        ];
        return $out;
    }

    public static function fetchResult($data)
    {
        $tmp = [];
        if(isset($data) && !empty($data)) {
            foreach ($data as $key => $item) {
                $tmp[$item['pid']][] = $item;
            }
            dd($tmp);
            $tmp = \Lib::createTree($tmp, $tmp[0]);
        }
        return $tmp;
    }

    protected static function defAdminMenu(){
        $menu = self::fetchMenu(self::createDefaultMenu([
            'id' => self::DEF_MENU_KEY,
            'title' => 'Cấu hình hệ thống',
            'perm' => ''
        ]));
        array_push($menu['sub'], self::fetchMenu(self::createDefaultMenu([
            'id' => self::DEF_MENU_KEY+1,
            'title' => 'Menu',
            'icon' => 'icon-menu',
            'perm' => 'menu-view',
            'link' => 'admin.menu'
        ])));

        array_push($menu['sub'], self::fetchMenu(self::createDefaultMenu([
            'id' => self::DEF_MENU_KEY+2,
            'title' => 'Người dùng',
            'icon' => 'icon-user',
            'perm' => 'user-view',
            'link' => 'admin.user',
        ])));

        array_push($menu['sub'], self::fetchMenu(self::createDefaultMenu([
            'id' => self::DEF_MENU_KEY+3,
            'title' => 'Phân quyền',
            'icon' => 'icon-flag',
            'perm' => 'role-view',
            'link' => 'admin.role',
        ])));

        array_push($menu['sub'], self::fetchMenu(self::createDefaultMenu([
            'id' => self::DEF_MENU_KEY+4,
            'title' => 'Cấu hình',
            'icon' => 'icon-settings',
            'perm' => 'config-change',
            'link' => 'admin.config',
        ])));
        return $menu;
    }

    protected static function createDefaultMenu($menu){
        $a = new Menu();
        foreach ($menu as $k => $v){
            $a->$k = $v;
        }
        return $a;
    }
    public function getImageUrl($size = 'original'){
        return \ImageURL::getImageUrl($this->img_icon, 'menu', $size);
    }
    public function getImageSeoUrl($size = 'original'){
        return \ImageURL::getImageUrl($this->image_seo, 'menu', $size);
    }
    public function getIconUrl($size = 'original',$type = 'img_icon'){
        return !empty($this->$type) ? \ImageURL::getImageUrl($this->$type, 'menu', $size) : 'upload/no_photo.png' ;
    }
    public function getImageBanner($size = 'original'){
        return \ImageURL::getImageUrl($this->image, 'menu', $size);
    }
    public static function getMenuIds($menu_ids, $pid){
        $data = self::where('status', '>', 0)->where('type', 3)->where(function ($query) use ($menu_ids, $pid){
            $query->orWhere('id', $pid);
            $query->orWhere('pid', $menu_ids);
            $query->orWhere('pid', $pid);
        })->select('id','pid', 'safe_title', 'title')->get()->keyBy('id')->toArray();
        $parent = '';
        $data_sub_3 = [];
        if (!empty($data)){
            if (isset($data[$pid])){
                $parent = $data[$pid];
                unset($data[$pid]);
            }
            $data_sub_3 = $data;
            foreach ($data as $key => $item){
                if($item['pid'] != $menu_ids){
                    unset($data[$key]);
                }
//                elseif ($item['pid'] == @$parent['id']){
//                    unset($data[$key]);
//                }
// elseif($item['pid'] != @$parent['id']){
//                    unset($data[$key]);
//                } elseif(empty($parent) && $item['pid'] != $menu_ids){
//                    unset($data[$key]);
//                }
//
            }
//            dd($data_sub_3);
            if (count($data) == 0){
                $data = $data_sub_3;
            }
        }
        return ['sub_menu' => $data, 'parent_menu' => $parent];
    }
    public static function getCateIdsByMenu($menu_id, &$out_menu_id = [],  &$out_arr_cate = []){
        if (is_array($menu_id)){
            $menu= self::where('status', '>', 0)->whereIn('pid', $menu_id)->select('id','pid', 'cat_id');
        }

        $result = $menu->get()->toArray();

        if(!empty($result)) {
            $arr_menu_id = [];
            foreach($result as $item) {
                $out_menu_id[] = $item['id'];
                $out_arr_cate[] = $item['cat_id'];

                if (!in_array($item['id'], $menu_id)) {
                    $arr_menu_id [] = $item['id'];
                }
            }

            self::getCateIdsByMenu($arr_menu_id,$out_menu_id, $out_arr_cate);                          
        }

        return  array_merge(array_unique($out_arr_cate));
    }

    public static function getMenuBySafeTitle($safe_title, $select){
        return self::where([
            ['status', '>', 0],
            ['type', 3],
            ['safe_title', $safe_title]
        ])->select($select)->first();
    }

    public static function getMenuByID($safe_title, $type) {
        $wery = self::where([
            ['status', '>', 0],
            ['type', $type],
            ['safe_title', $safe_title]
        ]);
        $wery->select('id', 'pid','title', 'safe_title', 'cat_id', 'type', 'type_cate', 'des', 'title_seo', 'description', 'keywords', 'image_seo');
        $data = $wery->first();

        if (!empty($data)){
            $data_seo =[
                    #region seo
                    'seo_title' => @$data->title_seo?:$data->title,
                    'seo_des' => @$data->description?:'',
                    'seo_keyword' => @$data->keywords,
                    'seo_image' => @$data->image_seo,
                    'seo_url_image' => \ImageURL::getImageUrl($data->image_seo, 'menu', 'original'),
                    #endregion
            ];

            $menu_ids[] = $data->id;
            $cat_id[] = $data->cat_id;
            $data['data_seo'] = $data_seo;

            $data_menu_related = self::getMenuIds($data->id, $data->pid);

            $data['sub_menu'] = $data_menu_related['sub_menu'];
            $data['arr_parent'] = $data_menu_related['parent_menu'];

            $data['arr_cate'] = self::getCateIdsByMenu([$data->id], $menu_ids, $cat_id);
//            $data['arr_parent'] = self::where('id', $data->pid)->select('id', 'title', 'safe_title')->first()->toArray();
//            dd($data);
//            $data['arr_child'] = self::getMenuIds([$data->id]);
        }
        return $data;
    }

    public static function getMenuByCateID($cat_id, $type){
        return self::where([
            ['type', $type],
            ['status', '>', 0],
            ['cat_id', $cat_id]
        ])->select('title', 'safe_title')->orderBy('id', 'DESC')->first();
    }
}
