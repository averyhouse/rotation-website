@extends('layouts.app')

@section('content')

    {{$curUser->name}}

    @foreach($meals as $meal)
        <p> {{ $meal->name }} </p>
    @endforeach
@endsection