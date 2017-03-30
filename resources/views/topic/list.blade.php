@extends('layout.main')

@section('content')
<div>
    <table class="table table-hover">
        <tr>
            <th width="60%">Topic</th>
            <th width="10%">Upvote(s)</th>
            <th width="10%">Downvote(s)</th>
            <th width="20%">Actions</th>
        </tr>
        @foreach ($topics as $topic)
            <tr>
                <td>{{ $topic['topic'] }}</td>
                <td>{{ $topic['upvotes'] }}</td>
                <td>{{ $topic['downvotes'] }}</td>
                <td>
                    <a class="btn btn-default" href="/topic/upvote/{{ $topic['id'] }}">Upvote</a>
                    <a class="btn btn-default" href="/topic/downvote/{{ $topic['id'] }}">Downvote</a>
                </td>
            </tr>
        @endforeach
    </table>
</div>
@endsection