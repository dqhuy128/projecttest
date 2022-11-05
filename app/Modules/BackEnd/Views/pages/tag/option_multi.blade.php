@php($mode = !empty($mode) ? $mode : 0)
@foreach($options as $v)
    @if(!empty($v['sub']))
        @if($mode == 0)
            <optgroup label="{{ $v['title'] }}">
                @else
                    <option value="{{ $v['id'] }}" @if(in_array($v['id'], $def)) selected="selected" @endif>{{ $v['title'] }}</option>
                @endif
                @foreach($v['sub'] as $sub)
                    @if(!empty($sub['sub']))
                        @if($mode == 0)
                            <optgroup label=" &nbsp; &nbsp; &nbsp; &nbsp;{{ $sub['title'] }}">
                                @else
                                    <option value="{{ $sub['id'] }}"@if(in_array($sub['id'], $def)) selected @endif> &nbsp; &nbsp; {{ $sub['title'] }}</option>
                                @endif
                                @foreach($sub['sub'] as $s)
                                    <option value="{{ $s['id'] }}" @if(in_array($s['id'], $def)) selected @endif> &nbsp; &nbsp; &nbsp; &nbsp;  &nbsp;{{ $s['title'] }} - {{ $sub['title'] }}</option>
                                @endforeach
                                @if($mode == 0)
                            </optgroup>
                        @endif
                    @else
                        <option value="{{ $sub['id'] }}" @if(in_array($sub['id'], $def)) selected @endif> &nbsp; &nbsp; {{ $sub['title'] }}</option>
                    @endif
                @endforeach
                @if($mode == 0)
            </optgroup>
        @endif
    @else
        <option value="{{ $v['id'] }}" @if(in_array($v['id'], $def)) selected @endif>{{ $v['title'] }}</option>
    @endif
@endforeach
