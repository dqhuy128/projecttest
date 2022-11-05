<?php

namespace App\Modules\BackEnd\Controllers;

use Illuminate\Http\Request;
use App\Models\ConfigHome as THIS;

class ConfigHomeController extends BackendController
{
    protected $folder_upload = 'config_home';
    public function __construct(){
        parent::__construct(new THIS());
        $this->bladeAdd = 'add';
        $this->registerAjax('route', 'ajaxUpdateRoute', 'change');
    }

    public function index(Request $request){
        return $this->returnView('index', [
            'site_title' => $this->title,
            'data' => $this->loadInfo()
        ]);
    }

    public function submit(Request $request){
        $default = $this->loadInfo();
        $default['image_sec3'] = $this->uploadImage($request, $request->title_sec3, 'image_sec3');
        $default['image_sec4'] = $this->uploadImage($request, $request->title_sec4, 'image_sec4');
        $default['image_mobile_sec4'] = $this->uploadImage($request, $request->title_sec4.'-mobile', 'image_mobile_sec4');
        foreach ($request->all() as $k => $v){
            if($k != '_token' && $k != 'image_sec3' && $k != 'image_sec4' && $k != 'image_mobile_sec4') {

                if (!empty($v)) {
                    $default[$k] = $v;
                } else {
                    $default[$k] = $v==0?$v:'';
                }
            }
        }
        THIS::setConfig($this->key, json_encode($default));
        return redirect()->route('admin.'.$this->key)->with('status', 'Đã cập nhật thành công');
    }

    protected function loadInfo(){
        $data = THIS::getConfig($this->key, '');
        return !empty($data) ? json_decode($data, true) : null;
    }

    protected function ajaxUpdateRoute(){
        $routes = \Lib::saveRoutes(false);
        return \Lib::ajaxRespond(true, 'ok', $routes);
    }
}
