<?php

namespace App\Modules\BackEnd\Controllers;

use Illuminate\Http\Request;

use App\Models\Intro as THIS;

class IntroController extends BackendController
{
    protected $timeStamp = 'created';

    //config controller, ez for copying and paste
    public function __construct(){
        parent::__construct(new THIS());
    }

    public function index(Request $request){
        $order = 'created DESC, id DESC';

        if($request->title != ''){
            $cond[] = ['title','LIKE','%'.$request->title.'%'];
        }
        if ($request->status != '') {
            $cond[] = ['status', $request->status];
        } else {
            $cond[] = ['status', '>', 0];
        }
        if(!empty($cond)) {
            $data = THIS::where($cond)->orderByRaw($order)->paginate($this->recperpage);
        }else{
            $data = THIS::orderByRaw($order)->paginate($this->recperpage);
        }
        return $this->returnView('index', [
            'data' => $data,
            'search_data' => $request
        ]);
    }

    public function buildValidate(Request $request){

        if($this->editMode){
            $this->ignoreValidate('image');
            if ($request->hasFile('image')) {
                $this->addValidate(['image' => 'mimes:jpeg,jpg,png,gif']);
            }
        }
    }

    public function beforeSave(Request $request, $ignore_ext = [])
    {
        parent::beforeSave($request); // TODO: Change the autogenerated stub

    }
}