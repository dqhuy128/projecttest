@extends('BackEnd::layouts.default')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            {!! Form::open(['url' => route('admin.'.$key.'.edit.post', $data->id), 'files' => true ]) !!}

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
            <style>
                .nav.nav-tabs a {
                    font-size: 14px !important;
                }
            </style>

            <div class="row">
                <div class="col-md-12 mb-4">
                    <div class="nav-tabs-boxed">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#info_basic" role="tab" aria-controls="info" aria-selected="true">Thông tin cơ bản</a></li>
                            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#info_type" role="tab" aria-controls="parameter" aria-selected="false">Thông tin phân loại Menu</a></li>
                            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#info_des" role="tab" aria-controls="parameter" aria-selected="false">Thông tin mô tả</a></li>
                            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#info_other_and_seo" role="tab" aria-controls="parameter" aria-selected="false">Thông tin phụ và SEO</a></li>
                        </ul>

                        <div class="tab-content">
                            <div class="tab-pane active" id="info_basic" role="tabpanel">
                                <div class="card-body" >
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="title">Tiêu đề</label>
                                                <input type="text" class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" id="title" name="title" value="{{ old('title', $data->title) }}" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="link">URL hoặc Route name</label>
                                                <input type="text" class="form-control{{ $errors->has('link') ? ' is-invalid' : '' }}" id="link" name="link" value="{{ old('link', $data->link) }}">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="sort">Sắp xếp</label>
                                                <input type="text" class="form-control{{ $errors->has('sort') ? ' is-invalid' : '' }}" id="sort" name="sort" value="{{ old('sort', $data->sort) }}">
                                            </div>

                                            {{--<div class="form-group">--}}
                                                {{--<label for="lang">Ngôn ngữ</label>--}}
                                                {{--<select id="lang" name="lang" class="form-control{{ $errors->has('lang') ? ' is-invalid' : '' }}" onchange="shop.getMenu($('#type').val(), this.value)">--}}
                                                    {{--@foreach($langOpt as $k => $v)--}}
                                                        {{--<option value="{{ $k }}" @if(old('lang', $data->lang) == $k) selected="selected" @endif>{{ $v }}</option>--}}
                                                    {{--@endforeach--}}
                                                {{--</select>--}}

                                            {{--</div>--}}

                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane" id="info_type" role="tabpanel">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="type">Loại Menu</label>
                                            <select id="type" name="type" class="form-control{{ $errors->has('type') ? ' is-invalid' : '' }}" onchange="shop.getMenu(this.value, $('#lang').val())">
                                                <option value="-1">-- Chọn --</option>
                                                @foreach($allType as $k => $v)
                                                    <option value="{{ $k }}" @if(old('type', $data->type) == $k) selected="selected" @endif>{{ $v }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="pid">Menu cha</label>
                                            <select id="pid" name="pid" class="form-control{{ $errors->has('pid') ? ' is-invalid' : '' }}">
                                                <option value="0">-- Chọn --</option>
                                            </select>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane" id="info_des" role="tabpanel">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <textarea name="des" id="des" class="form-control" cols="30" rows="10">{{old('des', $data->des)}}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="imgContainer">
                                            <div id="queue"></div>
                                            <input id="uploadify_body" name="uploadify_body" type="file" multiple="true">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane" id="info_other_and_seo" role="tabpanel">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="card">
                                            <div class="card-header">
                                                <i class="fe-menu"></i>THÔNG TIN PHỤ
                                            </div>
                                            <div class="card-body">
                                                <div class="form-group">
                                                    <label for="icon">Icon Class</label>
                                                    <input type="text" class="form-control{{ $errors->has('icon') ? ' is-invalid' : '' }}" id="icon" name="icon" value="{{ old('icon', $data->icon) }}">
                                                </div>
                                                <label class="checkbox-inline mr-2" for="no_follow">
                                                    <input type="checkbox" id="no_follow" name="no_follow" value="1" @if(old('no_follow', $data->no_follow) == 1) checked @endif>  No Follow
                                                </label>
                                                <label class="checkbox-inline" for="newtab">
                                                    <input type="checkbox" id="newtab" name="newtab" value="1" @if(old('newtab', $data->newtab) == 1) checked @endif>  Bật Tab mới
                                                </label>
                                                <div class="form-group">
                                                    <label for="perm">Phân quyền</label>
                                                    <select id="perm" name="perm" class="form-control{{ $errors->has('perm') ? ' is-invalid' : '' }}">
                                                        <option value="">-- Chọn --</option>
                                                        @foreach($permList as $k => $v)
                                                            <optgroup label="{{ $v['title'] }}">
                                                                @foreach($v['perm'] as $p => $t)
                                                                    <option value="{{ $k.'-'.$p }}" @if(old('perm', $data->perm) == $k.'-'.$p) selected="selected" @endif>{{ $k.'.'.$p.' - '.$t }}</option>
                                                                @endforeach
                                                            </optgroup>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="card">
                                            <div class="card-header">
                                                <i class="fe-menu"></i>THÔNG TIN SEO
                                            </div>
                                            <div class="card-body">
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label for="type">Tiêu đề</label>
                                                        <input type="text" name="title_seo" id="title_seo" class="form-control" value="{{old('title_seo', $data->title_seo)}}">
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label for="type">Keywords</label>
                                                        <input type="text" name="keywords" id="keywords" class="form-control" value="{{old('keywords', $data->keywords)}}">
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label for="type">Description</label>
                                                        <textarea name="description" id="description" cols="30" rows="5" class="form-control">{{old('description', $data->description)}}</textarea>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label for="type">Image</label>
                                                        <input type="file" name="image_seo" id="image_seo" class="form-control">
                                                    </div>
                                                </div>
                                                @if(!empty($data->image_seo))
                                                    <div class="col-sm-12">
                                                        <div class="form-group">
                                                            <img src="{{$data->getImageSeoUrl()}}" alt="" class="w-100">
                                                        </div>
                                                    </div>
                                                @endif

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-dot-circle-o"></i> Cập nhật</button>
                &nbsp;&nbsp;
                <a class="btn btn-sm btn-danger" href="{{ redirect()->back()->getTargetUrl() }}"><i class="fa fa-ban"></i> Hủy bỏ</a>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@stop
@section('css')
    {!! \Lib::addMedia('admin/js/library/tag/jquery.tag-editor.css') !!}
    {{--    {!! \Lib::addMedia('admin/js/library/chosen/chosen.min.css') !!}--}}
    {!! \Lib::addMedia('admin/js/library/uploadifive/uploadifive.css') !!}
    {!! \Lib::addMedia('admin/libs/upload-multiple-with-preview/file-upload-with-preview.min.css') !!}
@stop
@section('js_bot')
    {!! \Lib::addMedia('admin/js/library/uploadifive/jquery.uploadifive.min.js') !!}
    {!! \Lib::addMedia('admin/js/library/uploadifive/multiupload.js') !!}
    {!! \Lib::addMedia('admin/js/library/ckeditor/ckeditor.js') !!}


    <script type="text/javascript">
        $('#type').change(function(){
            $('.icon_type').hide();
            $('#' + $(this).val()).show();
        });
        shop.ready.add(function(){
            shop.admin.system.ckEditor('des', 100 + '%', 500, 'moono',[
                ['Undo','Redo','-'],
                ['Bold','Italic','Underline','Strike'],
                ['Link','Unlink','Anchor'],['Image','Youtube','Table'],
                ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock','-','NumberedList','BulletedList','-','Outdent','Indent','Blockquote'],
                '/',
                ['Font','FontSize', 'Format'],
                ['TextColor','BGColor','SelectAll','RemoveFormat'],['PasteFromWord','PasteText'],['Subscript','Superscript','SpecialChar'],['Source']
            ]);
            shop.multiupload_ele('des','','#uploadify_body');
            shop.getMenu($('#type').val(), $('#lang').val(), {{ $data->pid }}, {{ $data->id }});
            $("#link").autocomplete({
                position: { my : "right top", at: "right bottom" },
                minLength: 1,
                delay: 500,
                scroll: true,
                source: {!! $routes !!}
            });
            shop.getCat($('#type_cate').val(), $('#lang').val(), {{ $data->cat_id }});
            shop.getCatfooter($('#type_cate_footer').val(), $('#lang').val(), {{ $data->cat_id_footer}});
        },true);
        shop.getMenu = function (type, lang, def, meId) {
            var html = '<option value="0">-- Chọn --</option>';
            shop.ajax_popup('menu/get-menu', 'POST', {type:type, lang:lang}, function(json) {
                $.each(json.data,function (ind,value) {
                    if(meId != value.id) {
                        html += '<option value="' + value.id + '"' + (def == value.id ? ' selected' : '') + '>' + value.title + '</option>';
                        if (value.sub.length != 0) {
                            $.each(value.sub, function (k, sub) {
                                if(meId != sub.id) {
                                    html += '<option value="' + sub.id + '"' + (def == sub.id ? ' selected' : '') + '> &nbsp;&nbsp;&nbsp; ' + sub.title + '</option>';
                                }
                            });
                        }
                    }
                });
                $('#pid').html(html);
            });
        };
        shop.getCat = function (type, lang, def) {
            var html = '<option value="0">-- Chọn --</option>';
            shop.ajax_popup('category/get-cat', 'POST', {type:type, lang:lang}, function(json) {
                $.each(json.data,function (ind,value) {
                    html += '<option value="'+value.id+'"'+(def == value.id?' selected':'')+'>'+value.title+'</option>';
                    if(value.sub.length != 0){
                        $.each(value.sub,function (k,sub) {
                            html += '<option value="'+sub.id+'"'+(def == sub.id?' selected':'')+'> &nbsp;&nbsp;&nbsp; '+sub.title+'</option>';

                            if(typeof sub.sub != 'undefined' && sub.sub.length != 0){
                                $.each(sub.sub,function (k3,sub3) {
                                    html += '<option value="'+sub3.id+'"'+(def == sub3.id?' selected':'')+'> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; '+sub3.title+'</option>';
                                });
                            }
                        });
                    }
                });
                $('#cat_id').html(html);
            });
        };
        shop.getCatfooter = function (type, lang, def) {
            var html = '<option value="0">-- Chọn --</option>';
            shop.ajax_popup('category/get-cat_f', 'POST', {type_f:type, lang:lang}, function(json) {
                $.each(json.data,function (ind,value) {
                    html += '<option value="'+value.id+'"'+(def == value.id?' selected':'')+'>'+value.title+'</option>';
                    if(value.sub.length != 0){
                        $.each(value.sub,function (k,sub) {
                            html += '<option value="'+sub.id+'"'+(def == sub.id?' selected':'')+'> &nbsp;&nbsp;&nbsp; '+sub.title+'</option>';
                        });
                    }
                });
                $('#cat_id_footer').html(html);
            });
        };
    </script>
@stop