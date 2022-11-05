<?php

namespace App\Modules\BackEnd\Controllers;


use App\Libs\Lib;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Contact as THIS;
class ContactController extends BackendController
{
    //config controller, ez for copying and paste
    protected $timeStamp = 'created';
    protected $foods_perpage = 5;

    public function __construct()
    {
        parent::__construct(new THIS());
    }

    public function index(Request $request)
    {
        $order = 'created DESC, id DESC';
        $cond = [];

        if ($request->status != '') {
            $cond[] = ['status', $request->status];
        } else {
            $cond[] = ['status', '>', 0];
        }
        if ($request->phone != '') {
            $cond[] = ['phone', 'LIKE', '%' . $request->phone . '%'];
        }
        if ($request->full_name != '') {
            $cond[] = ['fullname', 'LIKE', '%' . $request->full_name . '%'];
        }

        if(!empty($request->time_from)){
            $time_from = Lib::getTimestampFromVNDate($request->time_from,true);

            array_push($cond, ['created_at', '>=', Carbon::createFromTimestamp($time_from)]);
        }
        if(!empty($request->time_to)){
            $time_to = Lib::getTimestampFromVNDate($request->time_to,true);
            array_push($cond, ['created_at', '<=', Carbon::createFromTimestamp($time_to)]);
        }




        $data = THIS::where($cond)->orderByRaw($order)->paginate($this->recperpage);
        return $this->returnView('index', [
            'data'           => $data,
            'search_data'    => $request,

        ]);
    }

    public function view($id)
    {
        $data = THIS::find($id)->first();

        $title = 'Xem thông tin khách hàng';
        return $this->returnView('view', [
            'site_title'       => $title,
            'data'             => $data,
        ], $title);
    }


}