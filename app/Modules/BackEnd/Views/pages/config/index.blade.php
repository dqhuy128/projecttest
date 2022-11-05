@extends('BackEnd::layouts.default')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            {!! Form::open(['url' => route('admin.config.post'), 'files' => true ]) !!}

            @if( count($errors) > 0)
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <div>{!! $error !!}</div>
                    @endforeach
                </div>
            @endif

            @if (session('status'))
                <div class="alert alert-success">
                    {!! session('status') !!}
                </div>
            @endif

            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#website" role="tab" aria-controls="website" aria-expanded="true"><i class="icon-globe"></i> Website</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-expanded="false"><i class="icon-phone"></i> Liên hệ</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#social" role="tab" aria-controls="social" aria-expanded="false"><i class="icon-star"></i> Mạng XH</a>
                </li>
{{--                <li class="nav-item">--}}
{{--                    <a class="nav-link" data-toggle="tab" href="#route" role="tab" aria-controls="route" aria-expanded="false"><i class="icon-directions"></i> Định tuyến</a>--}}
{{--                </li>--}}
{{--                <li class="nav-item">--}}
{{--                    <a class="nav-link" data-toggle="tab" href="#security" role="tab" aria-controls="security" aria-expanded="false"><i class="icon-shield"></i> Bảo mật</a>--}}
{{--                </li>--}}
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#other" role="tab" aria-controls="other" aria-expanded="false"><i class="icon-settings"></i> Khác</a>
                </li>
            </ul>

            <div class="tab-content mb-4">
                <div class="tab-pane active" id="website" role="tabpanel" aria-expanded="true">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="title">Tiêu đề website</label>
                                <input type="text" class="form-control{{ $errors->has('site_name') ? ' is-invalid' : '' }}" id="site_name" name="site_name" value="{{ old('site_name', $data['site_name']) }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="title">Từ khóa</label>
                                <input type="text" class="form-control{{ $errors->has('keywords') ? ' is-invalid' : '' }}" id="keywords" name="keywords" value="{{ old('keywords', $data['keywords']) }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="title">Mô tả website</label>
                                <textarea rows="9" class="form-control{{ $errors->has('keywords') ? ' is-invalid' : '' }}" id="description" name="description">{{ old('description', $data['description']) }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="title">Ảnh seo</label>
                                <input type="file" id="image" name="image" class="dropify form-control {{ $errors->has('image') ? ' is-invalid' : '' }}" data-default-file="{{ old('image_medium_seo',@$data['image_medium_seo']) }}">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="tab-pane" id="contact" role="tabpanel" aria-expanded="false">
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="title">Email liên hệ</label>
                                <input type="text" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" id="email" name="email" value="{{ old('email', $data['email']) }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="title">Hotline</label>
                                <input type="text" class="form-control{{ $errors->has('hotline') ? ' is-invalid' : '' }}" id="hotline" name="hotline" value="{{ old('hotline', $data['hotline']) }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-9">
                            <div class="form-group">
                                <label for="title">Address</label>
                                <input type="text" class="form-control{{ $errors->has('address_wh') ? ' is-invalid' : '' }}" id="address_wh" name="address_wh" value="{{ old('address_wh', @$data['address_wh'])}}">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="tab-pane" id="social" role="tabpanel" aria-expanded="false">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="facebook">Facebook Message</label>
                                <input type="text" class="form-control{{ $errors->has('facebook_message') ? ' is-invalid' : '' }}" id="facebook_message" name="facebook_message" value="{{ old('facebook_message', !empty($data['facebook_message']) ? $data['facebook_message'] : '') }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="facebook">Facebook</label>
                                <input type="text" class="form-control{{ $errors->has('facebook') ? ' is-invalid' : '' }}" id="facebook" name="facebook" value="{{ old('facebook', !empty($data['facebook']) ? $data['facebook'] : '') }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="youtube">Youtube</label>
                                <input type="text" class="form-control{{ $errors->has('youtube') ? ' is-invalid' : '' }}" id="youtube" name="youtube" value="{{ old('youtube', !empty($data['youtube']) ? $data['youtube'] : '') }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="facebook">Link Shopee</label>
                                <input type="text" class="form-control{{ $errors->has('shopee') ? ' is-invalid' : '' }}" id="shopee" name="shopee" value="{{ old('shopee', isset($data['shopee']) && !empty($data['shopee']) ? $data['shopee'] : '') }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="youtube">Link Lazada</label>
                                <input type="text" class="form-control{{ $errors->has('lazada') ? ' is-invalid' : '' }}" id="lazada" name="lazada" value="{{ old('lazada', isset($data['lazada']) && !empty($data['lazada']) ? $data['lazada'] : '') }}">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="tab-pane" id="route" role="tabpanel" aria-expanded="false">
                    <div class="row">
                        <div class="col-sm-12">
                            <div id="result"></div>
                            <button type="button" class="btn btn-sm btn-primary" onclick="shop.updateRoutes()"><i class="fa fa-dot-circle-o"></i> Cập nhật định tuyến</button>
                        </div>
                    </div>
                </div>

                <div class="tab-pane" id="security" role="tabpanel" aria-expanded="false">
                    <div class="row">
                        <div class="col-sm-9">
                            <div class="form-group">
                                <label for="weakpass">Blacklist mật khẩu (cách nhau dấu ";")</label>
                                <textarea rows="10" class="form-control{{ $errors->has('weakpass') ? ' is-invalid' : '' }}" id="weakpass" name="weakpass">{{ old('weakpass', !empty($data['weakpass']) ? $data['weakpass'] : '') }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="tab-pane" id="other" role="tabpanel" aria-expanded="false">
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="title">Phiên bản JS/CSS</label>
                                <input type="text" class="form-control{{ $errors->has('version') ? ' is-invalid' : '' }}" id="version" name="version" value="{{ old('version', $data['version']) }}" required>
                            </div>
                        </div>
                    </div>
{{--                    <div class="row">--}}
{{--                        <div class="col-sm-3">--}}
{{--                            <label class="checkbox-inline" for="mobile_active">--}}
{{--                                <input type="checkbox" id="mobile_active" name="mobile_active" value="1" @if(old('mobile_active', isset($data['mobile_active']) ? $data['mobile_active'] : 0) == 1) checked @endif> Kích hoạt Mobile Wrap--}}
{{--                            </label>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="row">--}}
{{--                        <div class="col-sm-3">--}}
{{--                            <div class="form-group">--}}
{{--                                <label for="title"> Page_Name Messeage</label>--}}
{{--                                <input type="text" class="form-control{{ $errors->has('page_name_mess') ? ' is-invalid' : '' }}" id="page_name_mess" name="page_name_mess" value="{{ old('page_name_mess', @$data['page_name_mess']) }}" >--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="row">--}}
{{--                        <div class="col-sm-9">--}}
{{--                            <div class="form-group">--}}
{{--                                <label for="script_box_fb">Code nhúng Messages</label>--}}
{{--                                <textarea rows="9" class="form-control{{ $errors->has('script_box_fb') ? ' is-invalid' : '' }}" id="script_box_fb" name="script_box_fb">{{ old('script_box_fb', @$data['script_box_fb']) }}</textarea>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="row">--}}
{{--                        <div class="col-sm-9">--}}
{{--                            <div class="form-group">--}}
{{--                                <label for="script_box_zalo">Code nhúng Zalo</label>--}}
{{--                                <textarea rows="9" class="form-control{{ $errors->has('script_box_zalo') ? ' is-invalid' : '' }}" id="script_box_zalo" name="script_box_zalo">{{ old('script_box_zalo', @$data['script_box_zalo']) }}</textarea>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
                    <div class="row">
                        <div class="col-sm-9">
                            <div class="form-group">
                                <label for="site_chatbot">Code nhúng Chatbot</label>
                                <textarea rows="9" class="form-control{{ $errors->has('site_chatbot') ? ' is-invalid' : '' }}" id="site_chatbot" name="site_chatbot">{{ old('site_chatbot', isset($data['site_chatbot']) ? $data['site_chatbot'] : '') }}</textarea>
                            </div>
                        </div>
                    </div>

{{--                    <div class="row">--}}
{{--                        <div class="col-sm-9">--}}
{{--                            <div class="form-group">--}}
{{--                                <label for="site_chatbot">Embed Code Web Push Notifications One Signal</label>--}}
{{--                                <textarea rows="9" class="form-control{{ $errors->has('web_push_notifications') ? ' is-invalid' : '' }}" id="web_push_notifications" name="web_push_notifications">{{ old('web_push_notifications', isset($data['web_push_notifications']) ? $data['web_push_notifications'] : '') }}</textarea>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}

                    <div class="row">
                        <div class="col-sm-9">
                            <div class="form-group">
                                <label for="script_head">Code nhúng Head</label>
                                <textarea rows="9" class="form-control{{ $errors->has('script_head') ? ' is-invalid' : '' }}" id="script_head" name="script_head">{{ old('script_head', isset($data['script_head']) ? $data['script_head'] : '') }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-9">
                            <div class="form-group">
                                <label for="script_body">Code nhúng Body</label>
                                <textarea rows="9" class="form-control{{ $errors->has('script_body') ? ' is-invalid' : '' }}" id="script_body" name="script_body">{{ old('script_body', isset($data['script_body']) ? $data['script_body'] : '') }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-dot-circle-o"></i> Cập nhật</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@stop

@section('css')
    {!! \Lib::addMedia('admin/js/library/tag/jquery.tag-editor.css') !!}
    {!! \Lib::addMedia('admin/js/library/uploadifive/uploadifive.css') !!}
@stop

@section('js_bot')
    {!! \Lib::addMedia('admin/js/library/uploadifive/jquery.uploadifive.min.js') !!}
    {!! \Lib::addMedia('admin/js/library/uploadifive/multiupload.js') !!}
    {!! \Lib::addMedia('admin/js/library/ckeditor/ckeditor.js') !!}
    {!! \Lib::addMedia('admin/js/library/tag/jquery.caret.min.js') !!}
    {!! \Lib::addMedia('admin/js/library/tag/jquery.tag-editor.min.js') !!}

    <script type="text/javascript">
        shop.ready.add(function(){
            shop.admin.system.ckEditor([
                'address'
            ], 870, 200, 'moono',[
                ['Undo','Redo','-'],
                ['Bold','Italic','Underline','Strike'],
                ['Link','Unlink','Anchor'],['Image','Youtube','Table'],
                ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock','-','NumberedList','BulletedList','-','Outdent','Indent','Blockquote'],
                '/',
                ['Font','FontSize'],
                ['TextColor','BGColor','SelectAll','RemoveFormat'],['PasteFromWord','PasteText'],['Subscript','Superscript','SpecialChar'],['Source'],['Maximize']
            ]);
        //
        //     // $('#published').datepicker({ dateFormat: 'dd/mm/yy' });
        //     shop.multiupload_ele('mail_forgotpass_vi','','#uploadify_mail_forgotpass_vi');
        //     shop.multiupload_ele('mail_register_vi','','#uploadify_mail_register_vi');
        //     shop.multiupload_ele('mail_order_vi','','#uploadify_mail_order_vi');
        //
        //     shop.multiupload_ele('mail_forgotpass_en','','#uploadify_mail_forgotpass_en');
        //     shop.multiupload_ele('mail_register_en','','#uploadify_mail_register_en');
        //     shop.multiupload_ele('mail_order_en','','#uploadify_mail_order_en');
        }, true);
        shop.admin.system.ckEditor('commitment', 100 +'%', 200, 'moono',[
            ['Undo','Redo','-'],
            ['Bold','Italic','Underline','Strike'],
            ['Link','Unlink','Anchor'],['Image','Youtube','Table'],
            ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock','-','NumberedList','BulletedList','-','Outdent','Indent','Blockquote'],
            '/',
            ['Font','FontSize', 'Format'],
            ['TextColor','BGColor','SelectAll','RemoveFormat'],['PasteFromWord','PasteText'],['Subscript','Superscript','SpecialChar'],['Source'],['ImgUploadBtn']
        ]);

        shop.updateRoutes = function () {
            shop.ajax_popup('route', 'POST', {}, function(json) {
                console.log(json);
                var html,i;
                html = '<div><b>PUBLIC ROUTES: </b></div>';
                for(i in json.data){
                    html += '<p>'+json.data[i]+'</p>';
                }
                $('#result').html(html);
                shop.ajax_popup('config/route', 'POST', {}, function(json) {
                    console.log(json);
                    html = '<div><b>ADMIN ROUTES: </b></div>';
                    for(i in json.data){
                        html += '<p>'+json.data[i]+'</p>';
                    }
                    $('#result').append(html);
                });
            },{
                baseUrl: ENV.PUBLIC_URL
            });
        };
    </script>
@stop

@section('js_bot')
    <script type="text/javascript">

    </script>
@stop