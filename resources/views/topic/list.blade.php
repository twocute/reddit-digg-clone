@extends('layout.main')

@section('content')
<div>
    <form action="{{ URL::to('topic/add') }}" method="POST">
        <label for="topic">New Topic Name: </label>
        <input type="text" name="topic">
        <button class="btn btn-default" type="submit">Add New Topic!</button>
    </form>
</div>

<div style="padding-top: 5px; padding-bottom: 5px;"></div>

@if(count($topics) > 0)
<div>
    <table class="table table-hover">
        <tr>
            <th width="20%">Actions</th>
            <th width="60%">Topic</th>
            <th width="10%">Upvote(s)</th>
            <th width="10%">Downvote(s)</th>
        </tr>
        @foreach ($topics as $topic)
            <tr>
                <td>
                    <a class="btn btn-default" href="/topic/upvote/{{ $topic['id'] }}">Upvote</a>
                    <a class="btn btn-default" href="/topic/downvote/{{ $topic['id'] }}">Downvote</a>
                </td>
                <td>{{ $topic['topic'] }}</td>
                <td>{{ $topic['upvotes'] }}</td>
                <td>{{ $topic['downvotes'] }}</td>
            </tr>
        @endforeach
    </table>
</div>
@else
    <p>No topics yet!</p>
@endif
@endsection