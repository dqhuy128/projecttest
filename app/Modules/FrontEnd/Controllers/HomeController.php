<?php

namespace App\Modules\FrontEnd\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\GeoDistrict;
use App\Models\News;
use App\Models\Warehouse;
use App\Modules\Core\Facades\OopsMemory;
use App\Modules\FrontEnd\Requests\ContactFormRequest;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\DocBlock\Description;
use PhpParser\Node\Stmt\DeclareDeclare;

class HomeController extends BaseFrontController
{   //
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        return view('FrontEnd::pages.home.index', [
            'site_title' => 'Trang chủ',
            'slide' => OopsMemory::call('Feature@SlideByPositionAction',['big_home', 1]),
            'recipe' => OopsMemory::call('Home@RecipeAction'),
            'choose' => OopsMemory::call('Home@ChooseAction'),
            'customer_talk' => OopsMemory::call('Home@CustomerTalkAction', [21]),
            'product' => OopsMemory::call('Home@ProductByKeyAction'),
            'intro' => OopsMemory::call('Home@IntroHomeAction'),
            'config_home' => OopsMemory::call('Home@ConfigHomeAction')
        ]);
    }

    public function success(Request $request){
        if (isset($request->_token) && !empty($request->_token)){
            $data = Contact::where('access_token', $request->_token)->first();
            if (!empty($data)){
                return view('FrontEnd::pages.home.success', [
                    'site_title' => 'Thank you',
                ]);
            }
            return redirect(route('home'));
        }
        return redirect(route('home'));
    }

    public function sendcontact(ContactFormRequest $request){
        $data_request = [];
        $data_request['fullname'] = $request->contact_name;
        $data_request['phone'] = $request->contact_phone;
        $data_request['support'] = $request->contact_support;
        $data = OopsMemory::call('Home@pushDataContactAction',[$data_request]);
        if (!empty($data)){
            return \Lib::ajaxRespond(true, 'success', ['url' => route('success').'?_token='.$data->access_token]);
        }
        return \Lib::ajaxRespond(false, 'Error');
    }
}
