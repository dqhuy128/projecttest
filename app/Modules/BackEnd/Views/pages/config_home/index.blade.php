@extends('BackEnd::layouts.default')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            {!! Form::open(['url' => route('admin.config_home.post'), 'files' => true ]) !!}

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
                    <a class="nav-link active" data-toggle="tab" href="#section3" role="tab" aria-controls="section3" aria-expanded="true">Nguyên nhân loãng xương</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#section4" role="tab" aria-controls="section4" aria-expanded="false">Nguyên nhân bổ xung</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#section5" role="tab" aria-controls="section5" aria-expanded="false">Khác</a>
                </li>
            </ul>

            <div class="tab-content mb-4">
                <div class="tab-pane active" id="section3" role="tabpanel" aria-expanded="true">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="title">Tiêu đề</label>
                                <input type="text" class="form-control{{ $errors->has('title_sec3') ? ' is-invalid' : '' }}" id="title_sec3" name="title_sec3" value="{{ old('title_sec3', @$data['title_sec3']) }}" >
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="title">Nội dung</label>
                                <textarea class="form-control {{ $errors->has('des_sec3') ? ' is-invalid' : '' }}" name="des_sec3" id="des_sec3" cols="30" rows="10">{{old('des_sec3', @$data['des_sec3'])}}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="title">Ảnh</label>
                                <input type="file" id="image_sec3" name="image_sec3" class="dropify form-control {{ $errors->has('image_sec3') ? ' is-invalid' : '' }}" data-default-file="{{ old('image_sec3_medium',@$data['image_sec3_medium']) }}">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="tab-pane" id="section4" role="tabpanel" aria-expanded="false">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="title">Tiêu đề</label>
                                <input type="text" class="form-control{{ $errors->has('title_sec4') ? ' is-invalid' : '' }}" id="title_sec4" name="title_sec4" value="{{ old('title_sec4', @$data['title_sec4']) }}" >
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="title">Nội dung <small class="text-danger">(Phân tách nhau bởi dấu ' # ')</small></label>
                                <textarea class="form-control {{ $errors->has('des_sec4') ? ' is-invalid' : '' }}" name="des_sec4" id="des_sec4" cols="30" rows="5">{{old('des_sec4', @$data['des_sec4'])}}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="title">Ảnh PC</label>
                                <input type="file" id="image_sec4" name="image_sec4" class="dropify form-control {{ $errors->has('image_sec4') ? ' is-invalid' : '' }}" data-default-file="{{ old('image_sec4_medium',@$data['image_sec4_medium']) }}">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="title">Ảnh Mobile</label>
                                <input type="file" id="image_mobile_sec4" name="image_mobile_sec4" class="dropify form-control {{ $errors->has('image_mobile_sec4') ? ' is-invalid' : '' }}" data-default-file="{{ old('image_mobile_sec4_medium',@$data['image_mobile_sec4_medium']) }}">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="tab-pane" id="section5" role="tabpanel" aria-expanded="false">
                    <label for=""><strong>Tiêu Đề Lựa chọn</strong></label>
                    <br>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="title">Tiêu đề trên</label>
                                <input type="text" class="form-control{{ $errors->has('title_top_sec5') ? ' is-invalid' : '' }}" id="title_top_sec5" name="title_top_sec5" value="{{ old('title_top_sec5', @$data['title_top_sec5']) }}" >
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="title">Tiêu đề dưới</label>
                                <input type="text" class="form-control{{ $errors->has('title_bot_sec5') ? ' is-invalid' : '' }}" id="title_bot_sec5" name="title_bot_sec5" value="{{ old('title_bot_sec5', @$data['title_bot_sec5']) }}" >
                            </div>
                        </div>
                    </div>

                    <label for=""><strong>Tiêu Đề Công Thức</strong></label>
                    <br>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="title">Tiêu đề trên</label>
                                <input type="text" class="form-control{{ $errors->has('title_top_sec6') ? ' is-invalid' : '' }}" id="title_top_sec6" name="title_top_sec6" value="{{ old('title_top_sec6', @$data['title_top_sec6']) }}" >
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="title">Tiêu đề dưới</label>
                                <input type="text" class="form-control{{ $errors->has('title_bot_sec6') ? ' is-invalid' : '' }}" id="title_bot_sec6" name="title_bot_sec6" value="{{ old('title_bot_sec6', @$data['title_bot_sec6']) }}" >
                            </div>
                        </div>
                    </div>

                    <label for=""><strong>Tiêu Đề Khách hàng nói về chúng tôi</strong></label>
                    <br>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="title">Tiêu đề trên</label>
                                <input type="text" class="form-control{{ $errors->has('title_top_sec7') ? ' is-invalid' : '' }}" id="title_top_sec7" name="title_top_sec7" value="{{ old('title_top_sec7', @$data['title_top_sec7']) }}" >
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="title">Tiêu đề dưới</label>
                                <input type="text" class="form-control{{ $errors->has('title_bot_sec7') ? ' is-invalid' : '' }}" id="title_bot_sec7" name="title_bot_sec7" value="{{ old('title_bot_sec7', @$data['title_bot_sec7']) }}" >
                            </div>
                        </div>
                    </div>

                    <label for=""><strong>Tiêu Đề Sản phẩm</strong></label>
                    <br>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="title">Tiêu đề</label>
                                <input type="text" class="form-control{{ $errors->has('title_top_sec8') ? ' is-invalid' : '' }}" id="title_top_sec8" name="title_top_sec8" value="{{ old('title_top_sec8', @$data['title_top_sec8']) }}" >
                            </div>
                        </div>
{{--                        <div class="col-sm-6">--}}
{{--                            <div class="form-group">--}}
{{--                                <label for="title">Tiêu đề dưới</label>--}}
{{--                                <input type="text" class="form-control{{ $errors->has('title_bot_sec7') ? ' is-invalid' : '' }}" id="title_bot_sec7" name="title_bot_sec7" value="{{ old('title_bot_sec7', @$data['title_bot_sec7']) }}" >--}}
{{--                            </div>--}}
{{--                        </div>--}}
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