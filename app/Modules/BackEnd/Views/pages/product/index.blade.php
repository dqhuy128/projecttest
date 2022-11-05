 @extends('BackEnd::layouts.default')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="mb-5"><h1>Quản trị {{ $site_title }}</h1></div>

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

        {!! Form::open(['url' => route('admin.'.$key), 'method' => 'get', 'id' => 'searchForm']) !!}
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="form-group col-sm-3">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-hashtag"></i></span>
                            <input type="text" name="id" class="form-control" placeholder="ID" value="{{ $search_data->id }}">
                        </div>
                    </div>
                    <div class="form-group col-sm-3">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fe-bookmark"></i></span>
                            <input type="text" name="title" class="form-control" placeholder="Tiêu đề" value="{{ $search_data->title }}">
                        </div>
                    </div>
                    <div class="form-group col-sm-3">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                            <input type="text" name="time_from" class="datepicker form-control" placeholder="Ngày đăng kí từ" autocomplete="off" value="{{ $search_data->time_from }}">
                        </div>
                    </div>
                    <div class="form-group col-sm-3">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                            <input type="text" name="time_to" class="datepicker form-control" placeholder="Ngày đăng kí đến" autocomplete="off" value="{{ $search_data->time_to }}">
                        </div>
                    </div>
                </div>

                <div class="row">
                    {{--<div class="form-group col-sm-3">--}}
                        {{--<div class="input-group">--}}
                            {{--<span class="input-group-addon"><i class="fa fa-language"></i></span>--}}
                            {{--<select id="lang" name="lang" class="form-control">--}}
                                {{--<option value="">-- Chọn ngôn ngữ --</option>--}}
                                {{--@foreach($langOpt as $k => $v)--}}
                                    {{--<option value="{{ $k }}" @if($search_data->lang == $k) selected="selected" @endif>{{ $v }}</option>--}}
                                {{--@endforeach--}}
                            {{--</select>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    <div class="form-group col-sm-3">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-list"></i></span>
                            <select name="status" class="form-control">
                                <option value="">-- Chọn trạng thái --</option>
                                <option value="2"{{ $search_data->status == 2 ? ' selected="selected"' : '' }}>Đang hiển thị</option>
                                <option value="1"{{ $search_data->status == 1 ? ' selected="selected"' : '' }}>Đang ẩn</option>
                                <option value="-1"{{ $search_data->status == -1 ? ' selected="selected"' : '' }}>Đã xóa</option>
                            </select>
                        </div>
                    </div>
                    {{--<div class="form-group col-sm-3">--}}
                        {{--<div class="input-group">--}}
                            {{--<span class="input-group-addon"><i class="fa fa-list"></i></span>--}}
                            {{--<select id="type" name="type" class="form-control">--}}
                                {{--<option value="">-- Phân loại --</option>--}}
                                {{--<option value="2"{{ $search_data->type == 2 ? ' selected="selected"' : '' }}>Món mới</option>--}}
                                {{--<option value="1"{{ $search_data->type == 1 ? ' selected="selected"' : '' }}>Món ưa thích</option>--}}
                            {{--</select>--}}
                        {{--</div>--}}
                    {{--</div>--}}

                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-search"></i> Tìm kiếm</button>
            </div>
        </div>
        {!! Form::close() !!}

        <div class="card card-accent-info">
            <div class="card-header">
                <i class="fa fa-align-justify"></i> Danh sách
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped table-responsive">
                    <thead>
                    <tr>
                        <th width="60">ID</th>
                        <th>Tiêu đề</th>
                        <th>Loại Sản Phẩm</th>
                        <th width="140">Giá</th>
                        <th width="125">Ảnh</th>
                        <th width="100">Ngày tạo</th>
                        @if(\Lib::can($permission, 'edit') || \Lib::can($permission, 'delete'))
                            <th width="55">Lệnh</th>
                        @endif
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($data as $item)
                    <tr>
                        <td align="center">{{ $item->id }}</td>
                        <td>
                            <b>{{ $item->title }}</b>
                        </td>
                        <td><b>@if($item->type_product == 1) Gói đơn 100 ml @elseif($item->type_product == 2) Combo 3 gói @endif</b></td>
                        <td align="right">
                            <b>{{ $item->price_format() }}</b><br>
                            <s>{{ $item->price_format(true) }}</s>
                        </td>
                        <td align="center">
                            @if($item->image != '')
                                <img src="{{ \ImageURL::getImageUrl($item->image, 'products', 'original') }}" width="100" />
                            @endif
                        </td>
                        <td align="center">{{ \Lib::dateFormat($item->created, 'd/m/Y H:i:s') }}</td>
                        @if(\Lib::can($permission, 'edit') || \Lib::can($permission, 'delete'))
                            <td align="center">
                                @if(\Lib::can($permission, 'edit'))
                                    <div class="mb-2">
                                        @if($item->status == 2)
                                            <a href="javascript:void(0)" class="text-primary" onclick="shop.admin.updateStatus({{ $item->id }},false,'product')" title="Đang hiển thị, Click để ẩn"><i class="fe-check-circle"></i></a>
                                        @else
                                            <a href="javascript:void(0)" class="text-secondary" onclick="shop.admin.updateStatus({{ $item->id }}, true,'product')" title="Đang ẩn, Click để hiển thị"><i class="fe-check-circle"></i></a>
                                        @endif
                                    </div>

                                    <div><a href="{{ route('admin.'.$key.'.edit', $item->id) }}" class="text-primary"><i class="fe-edit"></i></a></div>
                                @endif
                                @if(\Lib::can($permission, 'delete') && $item->status != -1)
                                        <div class="mt-2"><a href="{{ route('admin.'.$key.'.delete', $item->id) }}"  class="text-danger" onclick="return confirm('Bạn muốn xóa ?')"><i class="icon-trash icons"></i></a></div>
                                @endif
                            </td>
                        @endif
                    </tr>
                    @endforeach
                    </tbody>
                </table>

                <div class="pull-right">Tổng cộng: {{ $data->count() }} bản ghi / {{ $data->lastPage() }} trang</div>

                {!! $data->links('BackEnd::layouts.pagin') !!}
            </div>
        </div>
    </div>
    <!--/.col-->
</div>
@stop