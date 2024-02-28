@extends('layouts.app')
@section('content')
    <div class="container">
       <!-- <div class="titlebar">
            <h1>Blog list</h1>
        </div>
        <hr>
        <p>The Blog 1 - aa</p> -->
        @foreach ($data as $d)
            <div class="post">
                <h2>{{ $d['title'] }}</h2>
                <p>{{ $d['content'] }}</p>
            </div>
        @endforeach
    </div>
@endsection
