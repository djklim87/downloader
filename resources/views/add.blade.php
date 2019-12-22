@extends('app')

@section('content')

    <form id="send-form" method="POST" action="/enqueue">
        @csrf
        <input id="url" type="text" name="url" value="" placeholder="Type url">
        <input type="submit" value="send">
        @if(!empty($errors))
            <div style="margin-top:10px; color: red">{{$errors->first('url')}}</div>
        @endif
    </form>
@endsection
