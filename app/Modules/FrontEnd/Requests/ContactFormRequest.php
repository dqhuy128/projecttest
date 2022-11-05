<?php

namespace App\Modules\FrontEnd\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return
            [
                'contact_name' => 'required',
//                'contact_product' => 'required',
                'contact_phone' => ['required', 'numeric', 'regex:/^(03|02|05|07|08|09|01[2|6|8|9])+([0-9]{8})$/'],
            ];
    }

    /**
     * Custom message for validation
     *
     * @return array
     */
    public function messages()
    {
        return [
            'contact_name.required' => 'Họ và tên không được để trống',
//            'contact_product.required' => 'Lựa chọn sản phẩm bạn quan tâm',
            'contact_phone.required' => 'Số điện thoại không được để trống',
            'contact_phone.regex'        => 'Số điện thoại không hợp lệ',
            'contact_phone.numeric' => 'Số điện thoại không đúng định dạng',
        ];
    }
}
