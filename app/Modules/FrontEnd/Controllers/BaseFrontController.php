<?php
/**
 * Created by PhpStorm.
 * Filename: BaseFrontController.php
 * User: Thang Nguyen Nhan
 * Date: 04-Jun-19
 * Time: 10:53
 */
namespace App\Modules\FrontEnd\Controllers;

use App\Http\Controllers\Controller;
use App\Libs\ImageURL;
use App\Libs\Lib;
use Illuminate\Http\Request;

class BaseFrontController extends Controller
{
    protected $ajax = [];
    public function __construct(){
        $this->config = Lib::getSiteConfig();
    }

    public function ajax(Request $request, $cmd){
        $data = Lib::ajaxRespond(false, 'Nothing...');
        if(!empty($this->ajax) && !empty($this->ajax[$cmd])){
            $data = call_user_func( array($this, $this->ajax[$cmd]['func']), $request);
        }
        return response()->json($data);
    }
    protected function registerAjax($cmd, $func, $perm = ''){
        $this->ajax[$cmd] = ['func' => $func, 'perm' => $perm];
    }

    protected function uploadImg(Request $request,$img_field_name = '',$folder_upload = '')
    {
        if ($request->hasFile($img_field_name)) {
            $image = $request->file($img_field_name);
            if ($image->isValid()) {
                $title = basename($image->getClientOriginalName(), '.'.$image->getClientOriginalExtension());
                $fname = ImageURL::makeFileName($title, $image->getClientOriginalExtension());
                $upload = ImageURL::upload($image, $fname, $folder_upload);
                if($upload) {
                    return $fname;
                }
            }
        }
        return false;
    }
}