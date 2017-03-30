@extends('layout.main')

@section('content')
<div>
    <table>
        <tr>
            <th>Topic</th>
            <th>Upvote(s)</th>
            <th>Downvote(s)</th>
        </tr>
        @foreach ($topics as $topic)
            <tr>
                <td>{{ $topic['topic'] }}</td>
                <td>{{ $topic['upvotes'] }}</td>
                <td>{{ $topic['downvotes'] }}</td>
            </tr>
        @endforeach
    </table>
</div>
@endsection