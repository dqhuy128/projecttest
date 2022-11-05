<?php

namespace App\Modules\FrontEnd\Controllers;

use App\Libs\Cart;
use App\Libs\CouponLib;
use App\Libs\Lib;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Customer;
use App\Models\Filter;
use App\Models\GeoDistrict;
use App\Models\GeoWard;
use App\Models\InstallmentBank;
use App\Models\InstallmentDetail;
use App\Models\InstallmentScenarios;
use App\Models\InstallmentSuccess;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductCombo;
use App\Models\ProductDetail;
use App\Models\Question;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Libs\CartExtra;
use App\Models\SpecialOffers;
use Illuminate\Support\Facades\Input;
use phpDocumentor\Reflection\DocBlock\Description;
use Validator;
//custom models
use App\Models\Subscriber;
use App\Modules\Core\Facades\OopsMemory;
use Illuminate\Support\Facades\Auth;


class AjaxController extends Controller
{
    public function __construct()
    {
        //
    }

    public function init(Request $request, $cmd){
        $data = [];
        switch ($cmd) {
            case 'login':
                $data = $this->login($request);
                break;
            case 'register':
                $data = $this->register($request);
                break;
            case 'change-password':
                $data = $this->changePassword($request);
                break;
            case 'email-active':
                $data = $this->emailActive($request);
                break;
            case 'subscribe':
                $data = $this->subscribe($request);
                break;
            case 'route':
                $data = $this->updateRoute($request);
                break;
            case 'cart-load':
                $data = $this->cartShow($request);
                break;
            case 'cart-number':
                $data = $this->cartLoadNumber($request);
                break;
            case 'cart-add':
                $data = $this->cartAdd($request);
                break;
            case 'cart-add-bundle':
                $data = $this->cartAddBundle($request);
                break;
            case 'cart-update':
                $data = $this->cartUpdate($request);
                break;
            case 'cart-remove':
                $data = $this->cartRemove($request);
                break;
            case 'cart-destroy':
                $data = $this->cartDestroy($request);
                break;
            case 'list-districts':
                $data = $this->listDistricts($request);
                break;
            case  'list-ward' :
                $data = $this->listWards($request);
                break;
            case 'check-coupon':
                $data = $this->checkCoupon($request);
                break;
            case 'search':
                $data = $this->search($request);
                break;
            case 'searchForm':
                $data = $this->searchForm($request);
                break;
            case 'comment':
                $data = $this->commentproduct($request);
                break;
            case 'installment':
                $data = $this->installment($request);
                break;
            case 'loadInstallmentScenariosByID':
                $data = $this->loadInstallmentScenariosByID($request);
                break;
            case 'loadPaymentByBankID':
                $data = $this->loadPaymentByBankID($request);
                break;
            case 'savePaymentByBankID':
                $data = $this->savePaymentByBankID($request);
                break;
            case 'saveInstallmentMonth':
                $data = $this->_saveSuccessInstallment($request);
                break;
            case 'searchProductCompare':
                $data = $this->searchProductCompare($request);
                break;
            case 'searchProductInstallment':
                $data = $this->searchProductInstallment($request);
                break;
            case 'loadMoreAjax':
                $data = $this->loadMoreAjax($request);
                break;
            case 'loadMoreFilterAjax':
                $data = $this->loadMoreFilterAjax($request);
                break;
            case 'loadMoreSearchAjax':
                $data = $this->loadMoreSearchAjax($request);
                break;
            case 'getDataP':
                $data = $this->ajaxgetDataP($request);
                break;
            case 'get_json':
                $data = $this->ajaxGetJson($request);
                break;
            case 'get_installment':
                $data = $this->ajaxInstallment($request);
                break;
            case 'saveComment':
                $data = $this->ajaxSaveComment($request);
                break;
            default:
                $data = $this->nothing();
        }
        return response()->json($data);
    }
    public function checkCoupon(Request $request){
        if(!empty($request->coupon)){
            $giftLib = new CouponLib();
            $cart_content = Cart::getInstance()->getLatestCart();
            $checking['category'] = Product::getAllCateFromPrdIds($cart_content['itm_ids']);
            $checking['product'] = $cart_content['itm_ids'];
            $coupon = $giftLib->checkCouponSys($request->coupon,$checking);
            if(!empty($coupon)) {
                $cart_content['code'] = $request->coupon;
                Cart::getInstance()->freshCart($cart_content);
                return \Lib::ajaxRespond(true, 'Available', $coupon);
            }
        }
        return \Lib::ajaxRespond(false,"Mã coupon không hợp lệ hoặc đã được sử dụng");
    }
    public function listWards($request) {
        $district_id = $request->get('district_id');
        $data = GeoWard::getListwards($district_id);
//        dd($data->toArray());
        if(!empty($data)) {
            return \Lib::ajaxRespond(true, 'success', $data);
        }
    }

    public function listDistricts($request) {
        $province_id = $request->get('province_id');
        $data = GeoDistrict::getListDistrictsByCity($province_id);
        if(!empty($data)) {
            return \Lib::ajaxRespond(true, 'success', $data);
        }
    }

    public function cartShow(Request $request){
        $content = Cart::getInstance()->getLatestCart();
        $coupon_code = request()->coupons_code;

        if (!empty($coupon_code)){
            $return_coupon = CouponLib::calcCoupon($coupon_code,$content['total'],$content);
            $content['gr_total'] = isset($return_coupon['gr_total']) && $return_coupon['gr_total'] > 0 ? $return_coupon['gr_total'] : $content['total'];
            $content['dccoupon'] = isset($return_coupon['dccoupon']) && $return_coupon['dccoupon'] > 0 ? $return_coupon['dccoupon'] : 0;
            $content['total_after_code'] = $content['total'] - $content['dccoupon'];
            if($content['gr_total'] > @\Lib::getSiteConfig('free_ship')) {
                $content['shipping_fee'] = 0;
            }
            $content['gr_total'] += $content['shipping_fee'];
            
            $content =  Cart::getInstance()->freshCart($content);
            return \Lib::ajaxRespond(true, 'success', $content);
        }else {
           unset($content['total_after_code']);
           unset($content['dccoupon']);
        }

        $content =  Cart::getInstance()->freshCart();
        return \Lib::ajaxRespond(true, 'success',$content);
    }

    public function cartLoadNumber(Request $request){
        $content = Cart::getInstance()->content();
        return \Lib::ajaxRespond(true, 'success', ['number_item' => $content['number_item']]);
    }

    public function cartRemove(Request $request){
        // Cart::getInstance()->remove($request->type, $request->filter_key, $request->combo_key,$request->id);
        Cart::getInstance()->removeItemInCart($request->hashId);
        $content = Cart::getInstance()->freshCart();
        return \Lib::ajaxRespond(true, 'success', $this->cartMixConent($content));
    }

    public function cartChangePackage(Request $request){
        Cart::getInstance()->remove($request->old_id);
        $return = $this->cartAdd($request,false,true);
        return \Lib::ajaxRespond(true, 'success', $this->cartMixConent($content));
    }

    public function cartUpdate(Request $request){
        return $this->cartAdd($request, true);
    }

    public function cartAdd(Request $request, $replace = false,$call_only = false) {
        if (!empty($request->accessories)) {
            $request->quan = 1;
        }
        $type = $request->type;
        if($replace) {
            $item = Cart::getInstance()->get($request->index);
            if ($type == 1){
                $product = Product::getByComboKey(@$item['id'], $request->combo_key,$request->quan);
            }elseif ($type == 2){
                $product = Product::getByPriceFilterKey(@$item['id'],$request->filter_key,$request->quan);
            }elseif ($type == 3){
                $product = Product::getByFilterAndComboKey(@$item['id'],$request->filter_key, $request->combo_key,$request->quan);
            }else{
                $product = Product::getProduct(@$item['id'], $request->quan);
            }

        }else {
            $existed = Cart::getInstance()->checkingExisted($request->id,$request->filter_key);
            if($existed !== false) {
                $item = Cart::getInstance()->get($existed);
                $current_quan = $item['quan'];
            }
            if ($type == 1) {
                $product = Product::getByComboKey($request->id, $request->combo_key, $request->quan + ( isset($current_quan) && $current_quan ? $current_quan : 0));
            }elseif ($type == 2){
                $product = Product::getByPriceFilterKey($request->id,$request->filter_key,$request->quan + ( isset($current_quan) && $current_quan ? $current_quan : 0));
            }elseif ($type == 3){
                $product = Product::getByFilterAndComboKey($request->id,$request->filter_key, $request->combo_key,$request->quan + ( isset($current_quan) && $current_quan ? $current_quan : 0));
            }else{
                $product = Product::getProduct($request->id, $request->combo_key,$request->quan + ( isset($current_quan) && $current_quan ? $current_quan : 0));
            }
        }

        if($product){
            $msg = '';
            if($replace){
                $productCart = 0;
            }else {
                if ($type == 1){
                    $productCart = Cart::getInstance()->get($request->combo_key);
                }elseif ($type == 2){
                    $productCart = Cart::getInstance()->get($request->filter_key);
                }elseif ($type == 3){
                    $productCart = Cart::getInstance()->get($request->filter_key, $request->combo_key);
                }
                $productCart = (!empty($productCart) && !empty($productCart['quan'])) ? $productCart['quan'] : 0;
            }
            $cus = Auth::guard('customer');
            if (!empty($cus->check())){
                $customer_gp = Customer::with('groups' )->where('id', $cus->user()->id)->first();
                $percent = $customer_gp['groups']->max('percent');
                $price_dl = $product->price - ($product->price/100*$percent);
            }
            $opt = [
                'po' => isset($product->price_strike) ? $product->price_strike : $product->priceStrike,
                'price_dl' => @$price_dl ,
                'img' => $product->image,
            ];

            if ($type == 1){
                $combo = ProductCombo::getWithComboID($request->combo_key);
                if (!empty($combo)){
                    $temp = [
                        'combo_title' => 'Cấu hình',
                        'combo_value' =>   $combo['title']
                    ];
                    $opt['meta'][] = $temp;
                }

            }elseif($type == 2) {
                $filters = Filter::getWithCate(explode(',',$request->filter_key));
                if(!empty($filters)) {
                    foreach($filters as $filter){
                        $temp = [
                            'filter_cate_title' => $filter->filter_cate->title,
                            'filter_value' => $filter->title
                        ];
                        $opt['meta'][] = $temp;
                    }
                }
            }elseif ($type == 3){
                $combo = ProductCombo::getWithComboID($request->combo_key);
                $filters = Filter::getWithCate(explode(',',$request->filter_key));
                if (!empty($combo)){
                    $temp = [
                        'combo_title' => 'Cấu hình',
                        'combo_value' =>   $combo['title']
                    ];
                    $opt['meta_combo'][] = $temp;
                }
                if(!empty($filters)) {
                    foreach($filters as $filter){
                        $temp = [
                            'filter_cate_title' => $filter->filter_cate->title,
                            'filter_value' => $filter->title
                        ];
                        $opt['meta_filter'][] = $temp;
                    }
                }
            }

            
            if(!empty($request->opt) && is_array($request->opt)) {
                foreach($request->opt as $k => $v){
                    $opt[$k] = $v;
                }
            }

            $priceStrike = $product->priceStrike ?? $product->price_strike; // Gía gạch thuần nếu SP ko có cấu hình || hoặc giá gạch của cấu hình
            
            if ($type == 1){
                $result = Cart::getInstance()->add($priceStrike, $product->id,'',$request->combo_key, $type, $product->title, $product->alias, $request->quan, $product->price, $product->cate_title, $opt, $replace, $product->title_combo);
            }elseif ($type == 2){
                $result = Cart::getInstance()->add($priceStrike, $product->id,$request->filter_key, '', $type, $product->title, $product->alias, $request->quan, $product->price, $product->cate_title, $opt, $replace);
            }elseif ($type == 3){
                $result = Cart::getInstance()->add($priceStrike, $product->id,$request->filter_key, $request->combo_key, $type, $product->title, $product->alias, $request->quan, $product->price, $product->cate_title, $opt, $replace);
            }else{
                $result = Cart::getInstance()->add($priceStrike, $product->id,'', '', $type, $product->title, $product->alias, $request->quan, $product->price, $product->cate_title, $opt, $replace);
            }


            if ($request->has('special_offer_id')) {
                $specialOffer = SpecialOffers::find($request->special_offer_id);
                Cart::getInstance()->updateSpecialOffer($specialOffer, $request);
            }

            if ($request->has('accessories')) {
                $accessories = Product::whereIn('id', $request->accessories)
                                      ->with(['products' => function ($q) use ($request) {
                                          $q->wherePivot('product_id', $request->id)
                                            ->select('title', 'products.id');
                                      }])
                                ->select('id', 'title', 'image')
                                ->get();
                Cart::getInstance()->updateAccessories($accessories, $request);
            }


            if($result === true) {
                if($call_only) {
                    return true;
                }else {
                    $content = Cart::getInstance()->freshCart();
                    $coupon_code = $request->coupon_code;
                    if (!empty($coupon_code)) {
                        $return_coupon = CouponLib::calcCoupon($coupon_code, $content['total'], $content);
                        $content['gr_total'] = isset($return_coupon['gr_total']) && $return_coupon['gr_total'] > 0 ? $return_coupon['gr_total'] : $content['total'];
                        $content['dccoupon'] = isset($return_coupon['dccoupon']) && $return_coupon['dccoupon'] > 0 ? $return_coupon['dccoupon'] : 0;
                        if ($content['gr_total'] > @\Lib::getSiteConfig('free_ship')) {
                            $content['shipping_fee'] = 0;
                        }
                        $content['gr_total'] += $content['shipping_fee'];
                    }

                    $content = Cart::getInstance()->freshCart($content);
                    if ($replace == true){
                        return \Lib::ajaxRespond(true, 'success', $content);
                    }else{
                        return \Lib::ajaxRespond(true, 'success', ['url' => route('cart.checkout.cart')]);
                    }
                }
            }else {
                $msg = $result === 0 ? __('site.khongtimthaythongtinsanpham') : __('site.soluongvuotqua').': '.Cart::$limitPerItem;
            }
//                return \Lib::ajaxRespond(false, 'Mỗi sản phẩm chỉ cho phép mua tối đa '.Cart::getInstance()->limitVoucher().' ecash/lần');
//            }
            if($call_only) {
                return true;
            }else {
                $content = Cart::getInstance()->content();
                $coupon_code = $request->coupon_code;
                if (!empty($coupon_code)) {
                    $return_coupon = CouponLib::calcCoupon($coupon_code, $content['total'], $content);
                    $content['gr_total'] = isset($return_coupon['gr_total']) && $return_coupon['gr_total'] > 0 ? $return_coupon['gr_total'] : $content['total'];
                    $content['dccoupon'] = isset($return_coupon['dccoupon']) && $return_coupon['dccoupon'] > 0 ? $return_coupon['dccoupon'] : 0;
                    if ($content['gr_total'] > @\Lib::getSiteConfig('free_ship')) {
                        $content['shipping_fee'] = 0;
                    }
                    $content['gr_total'] += $content['shipping_fee'];
                }
                return \Lib::ajaxRespond(false, $msg, $this->cartMixConent($content));
            }
        }
        if($call_only) {
            return true;
        }else {
            return \Lib::ajaxRespond(false, 'Sản phẩm này không còn đủ hàng số lượng bạn muốn mua!');
        }
    }

    public function updateRoute(){
        $routes = \Lib::saveRoutes();
        return \Lib::ajaxRespond(true, 'ok', $routes);
    }

    public function subscribe(Request $request){
        $subscriber = Subscriber::where('email', $request->email)->first();
        if(empty($subscriber)){
            $subscriber = new Subscriber();
            $subscriber->email = $request->email;
            $subscriber->created = time();
        }
        $customer = Customer::where('email', $request->email)->first();
        if(!empty($customer)){
            $subscriber->customer_id = $customer->id;
        }
        $subscriber->save();
        return \Lib::ajaxRespond(true, __('site.camonbandadangkyyeucaucuabandaduocghinhan'));
    }

    public function emailActive(Request $request){
        $customer = Customer::find($request->id);
        if($customer){
            $customer->token->newToken();

            event('customer.register.resend', $customer->id);

            return \Lib::ajaxRespond(true, 'success');
        }
        return \Lib::ajaxRespond(false, 'Người dùng không tồn tại hoặc đã bị khóa');
    }

    public function register(Request $request){
        $validate = \Validator::make(
            $request->all(),
            [
                'name' => 'required',
                'email' => 'required|email|unique:customers,email',
                'password' => 'required|min:8|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\X])(?=.*[!$#%@]).*$/|confirmed',
                'provinces' => 'required',
                'districts' => 'required',
                'icheck' => 'required',
            ],
            [
                'regis_name.required' => 'Chưa nhập Họ và Tên',
                'regis_name.unique' => 'Họ và Tên đã được sử dụng',
                'email.required' => 'Chưa nhập Email',
                'email.unique' => 'Email của bạn đã được sử dụng',
                'email.email' => 'Định dạng Email không đúng',
                'password.required' => 'Chưa nhập mật khẩu',
                'password.min' => 'Mật khẩu phải có từ 8 kí tự trở lên',
                'password.regex' => 'Mật khẩu phải bao gồm chữ, số và kí tự đặc biệt (!, $, #, %, @)',
                'password.confirmed' => 'Xác nhận mật khẩu sai',
                'provinces.required' => 'Chưa chọn Tỉnh/Thành phố',
                'districts.required' => 'Chưa chọn Quận/Huyện',
                'icheck.required' => 'Bạn chưa đồng ý với điều khoản của chúng tôi',
            ]
        );
        if ($validate->fails()) {
            return \Lib::ajaxRespond(false, 'error', $validate->errors()->all());
        }elseif(\Lib::isWeakPassword($request->password)){
            return \Lib::ajaxRespond(false, 'error', ['Mật khẩu quá yếu']);
        }

        $customer = Customer::where('email', $request->email)->first();
        if($customer){
            return \Lib::ajaxRespond(false, 'error', 'EXISTED');
        }
        $customer = Customer::createOne($request);


//        Auth::guard('customer')->login($customer);

        //gui email
        event( "customer.register", $customer->id);
        return \Lib::ajaxRespond(true, 'success', ['url' => route('register.success').'?email='.$customer->email]);
//        $this->guard()->login($customer);
//        return \Lib::ajaxRespond(true, 'success', ['url' => route('customer.active')]);
//        return redirect()->route('user.index');
    }

    public function login(Request $request){

        if(!\Auth::guard('customer')->check()){
            $customer = Customer::where('email', $request->email)->first();
            if(!empty($customer)) {
                if($customer->active > 0) {
                    if($customer->status > 0) {
                        if (\Auth::guard('customer')->attempt(['email' => $request->email, 'password' => $request->password])) {
                            $request->session()->regenerate();
                            return \Lib::ajaxRespond(true, 'success', ['url' => route('home')]);
                        }
                        return \Lib::ajaxRespond(false, 'error', 'LOGIN_FAIL');
                    }
                    return \Lib::ajaxRespond(false, 'error', 'BANNED');
                }
                return \Lib::ajaxRespond(false, 'error', 'NOT_ACTIVE');
            }
            return \Lib::ajaxRespond(false, 'error', 'NOT_EXISTED');
        }
        return \Lib::ajaxRespond(false, 'error', 'LOGINED');
    }

    protected function cartMixConent(&$content = []){
        if (\Auth::guard('customer')->check()) {
            $content['customer_id'] = \Auth::guard('customer')->id();
        } else {
            $content['url_login'] = route('login');
        }
        return $content;
    }

    public function changePassword(Request $request){
        $validate = \Validator::make(
            $request->all(),
            [
                'newPassword' => 'required|min:8|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\X])(?=.*[!$#%@]).*$/',
            ],
            [
                'newPassword.required' => 'Chưa nhập mật khẩu',
                'newPassword.min' => 'Mật khẩu phải có từ 8 kí tự trở lên',
                'newPassword.regex' => 'Mật khẩu phải bao gồm chữ, số và kí tự đặc biệt (!, $, #, %, @)',
            ]
        );
        if ($validate->fails()) {
            return \Lib::ajaxRespond(false, 'error', $validate->errors()->all());
        }elseif(\Lib::isWeakPassword($request->password)){
            return \Lib::ajaxRespond(false, 'error', ['Mật khẩu quá yếu']);
        }
        if (!(\Hash::check($request->oldPassword, \Auth::guard('customer')->user()->password))){
            return \Lib::ajaxRespond(false, 'error', ['Mật khẩu hiện tại không đúng']);
//            return session()->flash('error', 'Mật khẩu hiện tại không đúng');
        }

        Customer::changePass($request);

        return \Lib::ajaxRespond(true, 'success', ['url' => route('logout')]);

    }

    public function search(Request $request){
        $valid = [
            'search' => 'required',
        ];
        $messages = [
            'search.required' => 'Bạn ey nói hoài rồi, bạn không nhập thì tìm thế lìn nào được, rảnh háng vkl',

        ];

        $validator = Validator::make($request->all(), $valid, $messages);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        else{
            return \Lib::ajaxRespond(true, 'success', ['url' => route('product.search.key').'?key='.$request->search]);
        }
    }
    public function searchForm(Request $request){
        $valid = [
            'search' => 'required',
        ];
        $messages = [
            'search.required' => 'Nhập từ khóa bận cần tìm kiếm ... ',

        ];

        $validator = Validator::make($request->all(), $valid, $messages);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        else{
            return \Lib::ajaxRespond(true, 'success', ['url' => route('product.searchForm.key').'?key='.$request->search]);
        }
    }

    public function commentproduct(Request $request){
        $validate = \Validator::make(
            $request->all(),
            [
                'name' => 'required',
                'rate' => 'required',
                'content' => 'required',
            ],
            [
                'name.required' => 'Chưa nhập Họ và Tên',
                'rate.required' => 'Bạn chưa đánh giá',
                'content.required' => 'Chưa nhập nội dung đánh giá',
            ]
        );
        if ($validate->fails()) {
            return \Lib::ajaxRespond(false, 'error', $validate->errors()->all());
        }
        $comment = Comment::pushComment($request);

        $tpl = [];
        $tpl['comment'] =  Comment::getCommentProductById($request->type_id)->orderBy('id', 'DESC')->get();
        if(count($tpl['comment']) > 0) {
            $tpl['rating']['total'] = $tpl['comment']->count('rating');
            $tpl['rating']['total_rate'] = $tpl['comment']->where('aid', '')->count('rating');
            $tpl['rating']['avg'] = Comment::getSumRate($request->type_id);
            // dd($tpl['rating']['avg']);
            $tpl['rating']['avg'] = round($tpl['rating']['avg']/$tpl['rating']['total_rate'], 1);
            for ($i=1; $i <= 5 ; $i++) {
                $count = $tpl['comment']->where('rating', $i)->count('rating');
                // $tpl['rating']['avg'] += $count;
                $tpl['rating']['rating_'.$i] = $count/$tpl['rating']['total']*100;
            }
        }
        $rate = Product::find($request->type_id);
        $rate->rate_avg = $tpl['rating']['avg'];
        $rate->rate_count = $tpl['rating']['total_rate'];
        $rate->save();

        return \Lib::ajaxRespond(true, 'success', 'LAPVIP xin được cám ơn những đánh giá vào nhận xét của bạn');

    }


    public function installment(Request $request){
        return \Lib::ajaxRespond(true, 'success', ['url' => route('installment.scenarios', ['alias' => $request->alias, '_token' => $request->_token,'index' => $request->index, 'id' => $request->id, 'filter_key' => (string)$request->filter_key, 'combo_key' => (string)$request->combo_key, 'quan'=>$request->quan, 'option_view' => $request->option_view])]);
    }

    public function loadInstallmentScenariosByID(Request $request){
        $payment = InstallmentDetail::where('installment_scenarios_id', '=', $request->termID)->whereNull('installment_id')->first();
        return \Lib::ajaxRespond(true, 'success', $payment);
    }
    public function savePaymentByBankID(Request $request){

        $type = \request()->option_view;
        $title_support = '';
        if ($type == 1) {
            $product = Product::getByComboKey($request->id, $request->combo_key, $request->quan + ( isset($current_quan) && $current_quan ? $current_quan : 0));
            $title_support = $product->title_combo;
        }elseif ($type == 2){
            $product = Product::getByPriceFilterKey($request->id,$request->filter_key,$request->quan + ( isset($current_quan) && $current_quan ? $current_quan : 0));
        }elseif ($type == 3){
            $product = Product::getByFilterAndComboKey($request->id,$request->filter_key, $request->combo_key,$request->quan + ( isset($current_quan) && $current_quan ? $current_quan : 0));
            $title_support = $product->title_combo;
        }else{
            $product = Product::getProduct($request->id, $request->combo_key,$request->quan + ( isset($current_quan) && $current_quan ? $current_quan : 0));
        }
        if ($type == 1){
            $combo = ProductCombo::getWithComboID($request->combo_key);
            if (!empty($combo)){
                $temp = [
                    'combo_title' => 'Cấu hình',
                    'combo_value' =>   $combo['title']
                ];
                $opt['meta_combo'][] = $temp;
            }
        }elseif($type == 2) {
            $filters = Filter::getWithCate(explode(',',$request->filter_key));
            if(!empty($filters)) {
                foreach($filters as $filter){
                    $temp = [
                        'filter_cate_title' => $filter->filter_cate->title,
                        'filter_value' => $filter->title
                    ];
                    $opt['meta_filter'][] = $temp;
                }
            }
        }elseif ($type == 3){
            $combo = ProductCombo::getWithComboID($request->combo_key);
            $filters = Filter::getWithCate(explode(',',$request->filter_key));
            if (!empty($combo)){
                $temp = [
                    'combo_title' => 'Cấu hình',
                    'combo_value' =>   $combo['title']
                ];
                $opt['meta_combo'][] = $temp;
            }
            if(!empty($filters)) {
                foreach($filters as $filter){
                    $temp = [
                        'filter_cate_title' => $filter->filter_cate->title,
                        'filter_value' => $filter->title
                    ];
                    $opt['meta_filter'][] = $temp;
                }
            }
        }
        $ins_bank = InstallmentBank::where('status', '>', 1)->where('title', $request->nameBank)->first();
        $ins = InstallmentDetail::where('installment_id', $ins_bank['id'])->first();
        $properties = \GuzzleHttp\json_decode($ins['properties']);

        foreach ($properties as $item){
            if ($request->payment == $item->payment_title){
                foreach ($item->month as $key => $item_month){
                    if($item_month->month == $request->month){
                        $conversion_fee = $ins_bank->surcharge + ($product->price * ($item_month->props[$key]->conversion_fee / 100)) + ($item_month->month * ($item_month->props[$key]->interest_rate / 100)) ;
                        
                        $monthly_installments = ($product->price  + $conversion_fee) / $item_month->month;
                        $total_cost = $product->price + $conversion_fee;

                        $ins_s = new InstallmentSuccess();
                        $ins_s->_token = $request->_token;
                        $ins_s->name = $request->name;
                        $ins_s->buyer_sex = $request->buyer_sex;
                        $ins_s->date_of_birth = $request->dateofbirth;
                        $ins_s->cmtnd = $request->cmtnd;
                        $ins_s->phone = $request->phone;
                        $ins_s->product_id = $request->id;
                        $ins_s->option_view = $request->option_view;
                        $ins_s->filter_key = @$opt['meta_filter'] ? json_encode($opt['meta_filter']) : '';
                        $ins_s->combo_key = @$opt['meta_combo'] ? json_encode($opt['meta_combo']) : '';
                        $ins_s->quan = 1; // Trả góp 1 sp thôi
                        $ins_s->type = $request->type;
                        $ins_s->month = $request->month;
                        $ins_s->money_paid_by_card = intval(str_replace([',','.'], '', $request->money_paid_by_card));
                        $ins_s->bank = $request->nameBank;
                        $ins_s->payment = $request->payment;
                        $ins_s->difference = $conversion_fee;
                        $ins_s->monthly_installments = $monthly_installments;
                        $ins_s->conversion_fee = $conversion_fee;
                        $ins_s->payment_upon_receipt = $ins_s->money_paid_by_card != 0 ? $product->price - $ins_s->money_paid_by_card : 0 ;
                        $ins_s->total_cost = $total_cost;
                        $ins_s->status = 0;
                        $ins_s->created = strtotime(now());
                        $ins_s->product_option_price_raw = !empty($product->price) ? $product->price : $product->price_strike;

                        $ins_s->save();
                        return \Lib::ajaxRespond(true, 'success');
                    }
                }
            }

        }
    }

    public function _saveSuccessInstallment(Request $request){
        $type = \request()->option_view;
        $title_support = '';
        if ($type == 1) {
            $product = Product::getByComboKey($request->id, $request->combo_key, $request->quan + ( isset($current_quan) && $current_quan ? $current_quan : 0));
            $title_support = $product->title_combo;
        }elseif ($type == 2){
            $product = Product::getByPriceFilterKey($request->id,$request->filter_key,$request->quan + ( isset($current_quan) && $current_quan ? $current_quan : 0));
        }elseif ($type == 3){
            $product = Product::getByFilterAndComboKey($request->id,$request->filter_key, $request->combo_key,$request->quan + ( isset($current_quan) && $current_quan ? $current_quan : 0));
            $title_support = $product->title_combo;
        }else{
            $product = Product::getProduct($request->id, $request->combo_key,$request->quan + ( isset($current_quan) && $current_quan ? $current_quan : 0));
        }
        if ($type == 1){
            $combo = ProductCombo::getWithComboID($request->combo_key);
            if (!empty($combo)){
                $temp = [
                    'combo_title' => 'Cấu hình',
                    'combo_value' =>   $combo['title']
                ];
                $opt['meta_combo'][] = $temp;
            }
        }elseif($type == 2) {
            $filters = Filter::getWithCate(explode(',',$request->filter_key));
            if(!empty($filters)) {
                foreach($filters as $filter){
                    $temp = [
                        'filter_cate_title' => $filter->filter_cate->title,
                        'filter_value' => $filter->title
                    ];
                    $opt['meta_filter'][] = $temp;
                }
            }
        }elseif ($type == 3){
            $combo = ProductCombo::getWithComboID($request->combo_key);
            $filters = Filter::getWithCate(explode(',',$request->filter_key));
            if (!empty($combo)){
                $temp = [
                    'combo_title' => 'Cấu hình',
                    'combo_value' =>   $combo['title']
                ];
                $opt['meta_combo'][] = $temp;
            }
            if(!empty($filters)) {
                foreach($filters as $filter){
                    $temp = [
                        'filter_cate_title' => $filter->filter_cate->title,
                        'filter_value' => $filter->title
                    ];
                    $opt['meta_filter'][] = $temp;
                }
            }
        }

        \Lib::addBreadcrumb($product->title.' '.$title_support);
        $installment = InstallmentScenarios::where('id', $request->ins)->where('status', '>', 1)->first();
        $installment_detail = \GuzzleHttp\json_decode($installment->installment_scenarios->properties);

        foreach($installment_detail as $item_detail){
            if ($item_detail->company == $request->com){
                $pager = '';
                foreach ($item_detail->pagers_required as $pagers_required){
                    $pager .= $pagers_required.' + ';
                }
                $installment_scenario = [];
                $installment_scenario['month'] = $request->month;
                $installment_scenario['prepay'] = $product->price * $request->input('prepare_percent', $item_detail->prepay) / 100;
                $installment_scenario['paymonth'] = (($product->price - $installment_scenario['prepay']) / $request->month) + (($product->price - $installment_scenario['prepay']) * ($item_detail->per_pay_mo / 100)) + $item_detail->surcharge;
                $installment_scenario['total_cost'] = $installment_scenario['paymonth'] * $request->month;
                $installment_scenario['total_af_ins'] = $installment_scenario['total_cost'] + $installment_scenario['prepay'];
                $installment_scenario['difference'] = $installment_scenario['total_af_ins'] - $product->price;
            }
        }
        $data = [];
        $data['_token'] = \request()->_token;
        $data['buyer_sex'] = $request->buyer_sex;
        $data['name'] = $request->name;
        $data['date_of_birth'] = $request->time_input ?? $request->dateofbirth;
        $data['cmtnd'] = $request->cmtnd;
        $data['phone'] = $request->phone;
        $data['ProID'] = \request()->id;
        $data['option_view'] = \request()->option_view;
        $data['filter_key'] = @$opt['meta_filter'] ? json_encode($opt['meta_filter']) : '';
        $data['combo_key'] = @$opt['meta_combo'] ? json_encode($opt['meta_combo']) : '';
        $data['quan'] = 1; // Tra gop thi chi duoc mua 1 
        $data['type'] = \request()->index ?? $request->type;
        $data['installment_scenarios_id'] = \request()->ins;
        $data['installment_scenarios_company'] = \request()->com;
        $data['month'] = $installment_scenario['month'];
        $data['prepaid_amount'] = $installment_scenario['prepay'];
        $data['difference'] = $installment_scenario['difference'];
        $data['monthly_installments'] = $installment_scenario['paymonth'];
        $data['total_cost'] = $installment_scenario['total_af_ins'];
        @$data['point_shop'] = @$request->delivery_address;
        $data['prepare_percent'] = $request->prepare_percent;
        $data['product_option_price_raw'] = $product->price;
        $saveSuccess = InstallmentSuccess::pushInstallmentSuccess($data);
        if (empty($saveSuccess)){
            return \Lib::ajaxRespond(true, 'success');
        }
        else{
            return \Lib::ajaxRespond(false, 'đã có lỗi trong quá trình lưu giữ liệu');
        }
    }

    public function loadPaymentByBankID(Request $request){
        $payment = InstallmentDetail::where('installment_id', '=', $request->idBank)->whereNull('installment_scenarios_id')->first();
        return \Lib::ajaxRespond(true, 'success', $payment);
    }
    public function searchProductCompare(Request $request){
        $product = Product::getByAlias($request->AliasP)->first();
        $proChild = OopsMemory::call('Product@GetProductCompareAction', [$product, '', 3]);
        $html = \View::make('FrontEnd::layouts.components.search_compare',['productChild' => $proChild, 'alias' => $request->AliasP] )->render();
        return \Lib::ajaxRespond(true,'success',$html);
    }

    public function searchProductInstallment(Request $request){
        $product = Product::getByAlias($request->alias)->first();
        $cate_product = $product->category->id;

        $data = Product::getProductsInstallment($cate_product, $product['id'],$request->data, 20);
        $html = \View::make('FrontEnd::layouts.components.search_product_installment',['data' => $data, 'index' => $request->index] )->render();
        return \Lib::ajaxRespond(true,'success',$html);
    }

    public function loadMoreAjax(Request $request){
        $page = $request->page;
        $pid = $request->pid;
        $sort_by = isset($request->sort_by) ? $request->sort_by : 3;
        $filter_ids = $request->filter_ids;
        $filter_ids = $filter_ids ? explode(',', $filter_ids) : '';
        $product['data'] = OopsMemory::call('Product@GetPrdByCateAction', [
            [
                'cate_ids' => $pid,
                'ins' => '',
                'filter_child' => '',
                'with_filter' => $filter_ids,
                'keyword' => '',
                'order_by' => $sort_by,
            ],
            '',
            [16, ['*'], 'page', $page]
        ]);
        
        $product['count'] = $product['data']->lastPage() - $product['data']->currentPage();
        return \Lib::ajaxRespond(true, 'success', ['product' => $product]);


    }
    public function loadMoreFilterAjax(Request $request){
        $page = $request->page;
//        $id = $request->id;
//        $pid = $request->pid;
        $arr_id = isset($request->arr_id) && !empty($request->arr_id) ?  explode(',', $request->arr_id) : [0];
        $sort_by = isset($request->sort_by) ? $request->sort_by : 1;
        $filter_ids = $request->filter_ids;
        $filter_ids = $filter_ids ? explode(',', $filter_ids) : '';
        
        $product['data'] = OopsMemory::call('Product@GetPrdByCateAction', [
            [
                'cate_ids' => $arr_id,
                'ins' => '',
                'filter_child' => '',
                'with_filter' => $filter_ids,
                'keyword' => '',
                'order_by' => $sort_by,
            ],
            '',
            [16, ['*'], 'page', $page]
        ]);

        $product['count'] = $product['data']->lastPage() - $product['data']->currentPage();
        return \Lib::ajaxRespond(true, 'success', ['product' => $product]);


    }

    public function loadMoreSearchAjax(Request $request){
        $page = $request->page;
        $key = $request->key;
        $sort_by = isset($request->sort_by) ? $request->sort_by : 3;
        $arr_key = explode(' ', $request->key);
        $only_integers = array_filter($arr_key,'ctype_digit');
        $product['data'] = Product::getProductsByKey($key, $only_integers, $sort_by)->paginate(16, ['*'], 'page', $page)->appends(Input::except('page'));
        $product['count'] = $product['data']->lastPage() - $product['data']->currentPage();
        return \Lib::ajaxRespond(true, 'success', ['product' => $product]);

    }
    public function ajaxgetDataP(Request $request){
        $product = Product::where('id', $request->id)->select('id', 'title', 'title_sub', 'price', 'priceStrike', 'out_of_stock')->first();
        if (!empty($product)){
            $prd_have_sale = ProductDetail::where('product_id', $product['id'])->first();
            return \Lib::ajaxRespond(true, 'success', ['product' => $product, 'prd_have_sale' => $prd_have_sale['properties']]);
        }
    }

    public function ajaxGetJson(Request $request){
        switch ($request->action) {
            case 'product_by_tabid':
                if (isset($request->cate) && !empty($request->cate)){
                    $data = OopsMemory::call('Home@GetPrdByCateIdAction', [
                        is_array($request->cate) ? $request->cate : [$request->cate],
                        isset($request->show) && !empty($request->show) ? $request->show : 8,
                        true
                    ]);
                    // $data = Product::getProductsByArrCate([$request->cate], isset($request->show) && !empty($request->show) ? $request->show : 8, true);
                }
                if (isset($request->style) && $request->style == 'slide'){
                    $html = \View::make('FrontEnd::pages.home.components.product_by_cate_slide_ajax',['data' => @$data??[]] )->render();
                } else{
                    $html = \View::make('FrontEnd::pages.home.components.product_by_cate_ajax',['data' => @$data??[]] )->render();
                }
                return $html;
                break;
            case 'question_by_page':
                $question_ans = OopsMemory::call('Product@GetQuestionAction', [$request->id, $request->page]);
                $html = \View::make('FrontEnd::pages.product.components.list_question_answer',['question' => $question_ans['question'], 'answer' => $question_ans['answer']] )->render();
                $paginate = \View::make('FrontEnd::layouts.components.render_pagination_ajax',['question' => $question_ans['question'], 'product_id' => $request->id, 'current_page' => $request->page ] )->render();

                return ['html' => $html, 'pagin' => $paginate];
                break;
        }
    }


    public function ajaxInstallment(Request $request){
        switch ($request->action) {
            case 'payment_card':
                $payment = InstallmentDetail::where('installment_id', '=', $request->idBank)->whereNull('installment_scenarios_id')->first();
                $html = '';
                if ($payment){
                    $html = \View::make('FrontEnd::pages.installment.component_render_js.payment_card',['data' => $payment] )->render();
                }
                return $html;
                break;
            case 'get_month_pay':
                $bank = InstallmentBank::find($request->idBank);
                if ($bank){
                    $payment = InstallmentDetail::where('installment_id', '=', $request->idBank)->whereNull('installment_scenarios_id')->first();
                    $data = [
                        'month' => [], //số tháng cho phép trả góp (kỳ hạn)
                        'conversion_fee' => [], // phí chuyển đổi: phụ phí + (giá * % phí chuyển đổi) + (kỳ hạn * % lãi suất)
                        'pay_a_m' => [], //góp mỗi tháng =  (giá + phí chuyển đổi) / kỳ hạn
                        'total' => [], //tổng trả góp = giá + phí chuyển đổi
                        'price_product' => [],
                        'need' => [],
                        'button' => [],
                    ];
                    if ($payment){
                        if (isset($request->cardName) && !empty($request->cardName)){
                            foreach(json_decode($payment->properties, true) as $itm){
                                if ($itm['payment_title'] === $request->cardName){
                                    foreach ($itm['month'] as $key => $item){
                                        $data['month'][$key] = $item['month'];
                                        $data['conversion_fee'][$key] = round((int)$bank['surcharge'] + ((int)$request->priceProduct * ((int)$item['props'][0]['conversion_fee'] / 100)) + ((int)$data['month'][$key] * ((int)$item['props'][0]['interest_rate'] / 100))) ;
                                        $data['pay_a_m'][$key] = round(((int)$request->priceProduct + $data['conversion_fee'][$key]) / (int)$data['month'][$key]);
                                        $data['total'][$key] = round((int)$request->priceProduct + $data['conversion_fee'][$key]);
                                        $data['price_product'][$key] = $request->priceProduct;
                                        $data['need'][$key] = isset($request->prepay) && !empty($request->prepay) ? (int)$request->priceProduct - (int)$request->prepay : 0;
                                        $data['button'][$key] = '<a href="javascript:;" class="js-select-tra-gop" data-month="'.$data['month'][$key].'">Chọn</a>';
                                    }
                                }
                            }
                        }
                    }
                    $html = '';
                    if ($payment){
                        $html = \View::make('FrontEnd::pages.installment.component_render_js.get_month_pay',['data' => $data, 'prepay' => isset($request->prepay) && !empty($request->prepay) ? $request->prepay : 0] )->render();
                    }
                    return $html;
                }

                break;
            case 'choose_month':
                $payment = InstallmentDetail::where('installment_scenarios_id', '=', $request->termID)->whereNull('installment_id')->first();

                $data = [
                    'image_com' => [],
                    'package' => [],
                    'price' => [],
                    'giay_to' => [],
                    'prepay' => [], //trả trước = giá máy * % trả trước / 100
                    'pay_a_month' => [], //trả mỗi tháng = ((giá máy - trả trước) / số tháng) + ((giá máy - trả trước) * (% tháng / 100 )) + phụ phí
                    'total_pay' => [], // tổng tiền trả góp = trả mỗi tháng * số tháng
                    'total_after_pay' => [],  //tổng tiền sau trả góp = tổng tiền trả góp + trả trước
                    'difference' => [], //chênh lệch = tổng tiền sau trả góp - giá máy
                    'button' => []
                ];
                $html = '';
                if ($payment && !empty($payment->properties)){
                    $pro = json_decode($payment->properties, true);
                    if (!empty($pro)){
                        foreach ($pro as $key => $itm){
                            $papers = '';
                            $prepay = isset($request->percent) && !empty($request->percent) ? $request->percent : $itm['prepay'];
                            if (!empty($itm['pagers_required'])){
                                foreach ($itm['pagers_required'] as $pap){
                                    $papers = $papers == '' ? $pap : $papers .' + '.$pap;
                                }
                            }
                            $data['image_com'][$key] = \ImageURL::getImageUrl($itm['image'], 'installment_scenarios', '');
                            $data['package'][$key] = $itm['des'];
                            $data['price'][$key] = (int)$request->priceProduct;
                            $data['giay_to'][$key] = $papers;
                            $data['prepay'][$key] = round((int)$request->priceProduct * (int)$prepay / 100) ;
                            $data['pay_a_month'][$key] = round((( (int)$request->priceProduct - $data['prepay'][$key] ) / $request->month) + (((int)$request->priceProduct - $data['prepay'][$key]) * ($itm['per_pay_mo'] / 100)) + $itm['surcharge']);
                            $data['total_pay'][$key] = round($data['pay_a_month'][$key] * $request->month);
                            $data['total_after_pay'][$key] = round($data['total_pay'][$key] + $data['prepay'][$key]);
                            $data['difference'][$key] = round($data['total_after_pay'][$key] - (int)$request->priceProduct);
                            $data['button'][$key] = '<a href="javascript:;" class="js-select-tra-gop-sc" data-company="'.$itm['company'].'" data-ins="'.$request->termID.'" data-sc="'.$request->month.'">Chọn</a>';
                            $data['percent'][$key] = $prepay;
                        }
                    }
                }
                if (!empty($data['image_com'])){
                    $html = \View::make('FrontEnd::pages.installment.component_render_js.chon_cong_ty_tra_gop',['data' => $data, 'percent' => isset($request->percent) && !empty($request->percent) ? $request->percent : 0] )->render();
                }
                return $html;
                break;
        }
    }

    public function ajaxSaveComment(Request $request){
        if (isset($request->id) && !empty($request->id) 
            && isset($request->comment) 
            && !empty($request->comment)
            && !empty($request->email)
            && !empty($request->name)){

            $comment = new Question();
            $comment->type = $request->type;
            $comment->product_id = $request->id;
            $comment->question = $request->comment;
            $comment->email = $request->email;
            $comment->name = $request->name;
            $comment->status = 0;
            $comment->created = time();
            $comment->save();

            if ($comment){
                return \Lib::ajaxRespond(true, 'success');
            }
        }

        return \Lib::ajaxRespond(false, 'Hãy nhập đủ thông tin');
    }


    public function nothing(){
        return "Nothing...";
    }


    public function cartDestroy(Request $request) {
        Cart::getInstance()->destroy();
        return Lib::ajaxRespond(true, 'success');
    }
} // End class
