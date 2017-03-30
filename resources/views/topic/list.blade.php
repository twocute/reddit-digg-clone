@extends('layout.main')

@section('content')
<div>
    <table>
        <tr>
            <th>Topic</th>
            <th>Upvote(s)</th>
            <th>Downvote(s)</th>
            <th>Actions</th>
        </tr>
        @foreach ($topics as $topic)
            <tr>
                <td>{{ $topic['topic'] }}</td>
                <td>{{ $topic['upvotes'] }}</td>
                <td>{{ $topic['downvotes'] }}</td>
                <td>
                    <a href="/topic/upvote/{{ $topic['id'] }}">Upvote</a>
                    <a href="/topic/downvote/{{ $topic['id'] }}">Downvote</a>
                </td>
            </tr>
        @endforeach
    </table>
</div>
@endsection