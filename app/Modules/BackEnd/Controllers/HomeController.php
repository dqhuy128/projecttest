<?php

namespace App\Modules\BackEnd\Controllers;

use App\Http\Controllers\Controller;
use App\Libs\Lib;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    //
    public function __construct(){
        Lib::addBreadcrumb();
    }

    public function index(Request $request){
        return view('BackEnd::pages.home.index', [
            'site_title' => 'Trang chủ',
            'key' => 'home',
        ]);
    }

    public function checkAuth(){
        return redirect()->to(url()->full().'/login')->send();
    }
}
