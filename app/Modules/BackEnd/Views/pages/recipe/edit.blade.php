@extends('BackEnd::layouts.default')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            @if(old_blade('editMode'))
                {!! Form::open(['url' => route('admin.'.$key.'.edit.post', old_blade('id')) , 'files' => true]) !!}
            @else
                {!! Form::open(['url' => route('admin.'.$key.'.add.post') , 'files' => true]) !!}
            @endif

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
            <div class="c-body">
                <div class="c-main">
                    <div class="container-fruid">
                        <div id="ui-view">
                            <div class="fade-in">
                                <div class="row">
                                    <div class="col-md-12 mb-4">
                                        <div class="nav-tabs-boxed">
                                            <ul class="nav nav-tabs" role="tablist">
                                                <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#." role="tab" aria-controls="info" aria-selected="true">Thông tin cơ bản</a></li>
                                            </ul>
                                            <div class="tab-content">
                                                <div class="tab-pane active" id="info" role="tabpanel">
                                                    <div class="card-body" >
                                                        <div class="row">
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label for="title">Tiêu đề<span class="text-danger">*</span></label>
                                                                    <input type="text" class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" id="title" name="title" value="{{ old_blade('title') }}" required>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-sm-6">
                                                                        <div class="form-group">
                                                                            <label for="base_price">Sắp xếp (từ bé đến lớn)</label>
                                                                            <input type="text" class="form-control{{ $errors->has('sort') ? ' is-invalid' : '' }}" id="sort" name="sort" value="{{ old_blade('sort')}}"  onkeypress="return shop.numberOnly()" onkeyup="mixMoney(this)" onfocus="this.select()">
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="image">Ảnh đại diện <span class="text-danger">*</span></label>
                                                                    <input type="file" id="image" name="image" class="dropify form-control {{ $errors->has('image') ? ' is-invalid' : '' }}" data-default-file="{{ @\ImageURL::getImageUrl(old('image', @$data['image']), 'repice', 'original') }}">
                                                                </div>
                                                            </div>

                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label for="">Nội dung phản hồi</label>
                                                                    <textarea class="form-control{{ $errors->has('feedback') ? ' is-invalid' : '' }}" id="description" name="description" rows="10" required>{{ old_blade('description') }}</textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-flex">
                <div class="mb-3">
                    <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-dot-circle-o"></i> Cập nhật</button>
                    &nbsp;&nbsp;{!! Form::close() !!}
                    <a class="btn btn-sm btn-danger" href="{{ redirect()->back()->getTargetUrl() }}"><i class="fa fa-ban"></i> Hủy bỏ</a>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js_bot')
    {!! \Lib::addMedia('admin/js/library/ckeditor/ckeditor.js') !!}

    <script type="text/javascript">
        shop.ready.add(function(){
            shop.admin.system.ckEditor('feedback', 100 + '%', 300, 'momo',[
                ['Undo','Redo','-'],
                ['Bold','Italic','Underline','Strike'],
                ['Link','Unlink','Anchor'],['Image','Youtube','Table'],
                ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock','-','NumberedList','BulletedList','-','Outdent','Indent','Blockquote'],
                '/',
                ['Font','FontSize', 'Format'],
                ['TextColor','BGColor','SelectAll','RemoveFormat'],['PasteFromWord','PasteText'],['Subscript','Superscript','SpecialChar'],['Source']
            ]);

        }, true);

    </script>
@stop