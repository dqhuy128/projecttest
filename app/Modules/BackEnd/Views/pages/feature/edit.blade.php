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

            <div class="card">
                <div class="card-header">
                    <i class="fe-menu-square-o"></i>  Thông Tin
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="title">Tiêu đề</label>
                                <input type="text" class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" id="title" name="title" value="{{ old_blade('title') }}" >
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="title">Tiêu đề phụ</label>
                                <input type="text" class="form-control{{ $errors->has('title_sub') ? ' is-invalid' : '' }}" id="title_sub" name="title_sub" value="{{ old_blade('title_sub') }}" >
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="title">Mô tả</label>
                                <textarea name="des" id="des" class="form-control" cols="30" rows="10">{{old_blade('des')}}</textarea>
                            </div>
                        </div>
{{--                        <div class="col-sm-6">--}}
{{--                            <div class="form-group">--}}
{{--                                <label for="title">Link</label>--}}
{{--                                <input type="text" class="form-control{{ $errors->has('link') ? ' is-invalid' : '' }}" id="link" name="link" value="{{ old_blade('link') }}">--}}
{{--                            </div>--}}
{{--                        </div>--}}
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">Vị Trí Hiển Thị và Hình Ảnh</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                @php
                                    $positions = old_blade('positions');
                                    if(is_array($positions)){
                                        $positions = implode(',', $positions);
                                    }
                                @endphp


                                @foreach($options as $k => $r)
                                    <div>
                                        <label for="checkbox{{ $k }}">
                                            <input type="checkbox" id="checkbox{{ $k }}" name="positions[]" value="{{ $k }}" @foreach(explode(',', $positions) as $item_po) {{$item_po == $k ? 'checked' : ''}}@endforeach >&nbsp; {{ $r }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <input type="file" id="image" name="image" class="dropify form-control {{ $errors->has('image') ? ' is-invalid' : '' }}" data-default-file="{{ \ImageURL::getImageUrl( old('image',@$data['image']), 'feature', 'original') }}">
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
