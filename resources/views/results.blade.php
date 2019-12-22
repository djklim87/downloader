@extends('app')

@section('content')
    <h1>Downloads list</h1>
    <a href="/add">Add new</a>
    <table>
        <thead>
        <tr>
            <th>Name</th>
            <th>url</th>
            <th>status</th>
            <th>action</th>
        </tr>
        </thead>
        @foreach($downloads as $download)
            <tr>
                <td>{{$download->filename}}</td>
                <td>{{$download->url}}</td>
                <td>{{$download->status}}</td>
                <td>
                    @if($download->status==\App\DownloadRecord::STATUS_COMPLETE)
                        <a href="/download/{{$download->id}}">Download</a>
                    @endif
                </td>
            </tr>
        @endforeach
    </table>
@endsection
