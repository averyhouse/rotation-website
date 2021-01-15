@extends('layouts.editApp')

@section('content')
    <img src="{{ url('../images', $prefrosh->picture) }}" width="200px">
    <h1>{{$prefrosh->name}}</h1>
    Meals:
    <ul>
        @foreach($meals as $meal)
            <li><a href="{{ url('/meals', $meal->id) }}">{{$meal->name}}</a></li>
        @endforeach
    </ul>
    <p>Rating: {{$prefrosh->sumScore}}</p>
    <p>Reviews: {{$prefrosh->numComments}}</p>

    @foreach($comments as $comment)
        @if(!empty($comment->review))
                <h3>{{ $comment->user()->first()->name }}</h3>
                <ul>
                <li>Rating: {{ $comment->rating }}</li>
                <li>Review: {{ $comment->review }}</li>
            </ul>
        @endif
    @endforeach
@endsection