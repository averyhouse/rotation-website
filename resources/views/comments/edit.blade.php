@extends('layouts.editApp')

@section('content')
    <img src="/images/{{$prefrosh->picture}}" width="200px">
    <h1>{{$prefrosh->name}}</h1>
    Meals:
    <ul>
        @foreach($meals as $meal)
            <li><a href="{{ url('/meals', $meal->id) }}">{{$meal->name}}</a></li>
        @endforeach
    </ul>
    <h1> Comment</h1>
    {!! Form::model($comment, ['method' => 'PATCH', 'action' => ['CommentsController@update', $comment->id]]) !!}

    <div class="form-group">
        {!! Form::label('rating', 'Rating:') !!}
        -
        {!! Form::radio('rating', -1) !!}
        {!! Form::radio('rating', -0.5) !!}
        {!! Form::radio('rating', 0) !!}
        {!! Form::radio('rating', 0.5) !!}
        {!! Form::radio('rating', 1) !!}
        +
    </div>

    <div class="form-group">
        <b>Review:</b>
        <p>
            {!! Form::textarea('review') !!}
        </p>
    </div>
    <div class="form-group">
        {!! Form::submit('Submit', ['class' => 'btn btn-primary form-control']) !!}
    </div>
    {!! Form::close() !!}

@endsection