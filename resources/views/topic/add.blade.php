@extends('layout.main')

@section('content')
<div>
    <form method="POST">
        <input type="text" name="topic">
        <button type="submit">Add New Topic!</button>
    </form>
</div>
@endsection