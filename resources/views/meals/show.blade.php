@extends('layouts.indexApp')

@section('content')

    <h1>{{  $meal->name }}</h1>
    <div class="col-md-3">
    <ul style="list-style-type: none;padding:0;">
        @foreach($prefrosh as $prefroshy)
            <li style="text-decoration: none;"><a href="/comments/{{$prefroshy->id}}/edit">{{$prefroshy->name}}</a></li>
        @endforeach
    </ul>
    </div>

    <div class="col-md-9">
    <div class="row">
        <?php $idx = 0; ?>
        @foreach($prefrosh as $index => $prefroshy)
            <?php $idx++ ?>

            <div class="col-md-4">
                <a href="/comments/{{$prefroshy->id }}/edit">
                    <img src="/images/{{ $prefroshy->picture }}" width="200">

                    <p> {{ $prefroshy->name }}</p>
                </a>

                <p>Rating: {{$comments[$index]->rating}}</p>
                <p>Review: {{$comments[$index]->review}}
                    <a href="/comments/{{$prefroshy->id }}/edit"><b>Edit</b></a>
                </p>
            </div>
            </a>
            @if($idx % 3 == 0)
    </div>&nbsp;<div class="row">
        @endif
        @endforeach

    </div>
        </div>




@endsection

@section('footer')



@endsection