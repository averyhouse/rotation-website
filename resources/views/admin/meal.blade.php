@extends('layouts.indexApp')

@section('content')

    <h1>{{  $meal->name }}</h1>
    <div class="col-md-3">
        <ul style="list-style-type: none;padding:0;">
            @foreach($prefrosh as $prefroshy)
                <li style="text-decoration: none;"><a href="/comments/{{$prefroshy->id}}">{{$prefroshy->name}}</a></li>
            @endforeach
        </ul>
    </div>

    <div class="col-md-9">
        <div class="row">
            <?php $idx = 0; ?>
            @foreach($prefrosh as $prefroshy)
                <?php $idx++ ?>

                <div class="col-md-4">
                    <a href="/comments/{{$prefroshy->id }}">
                        <img src="/images/{{ $prefroshy->picture }}" width="200">

                        <p> {{ $prefroshy->name }}</p>
                    </a>

                    <p>Rating: {{$prefroshy->sumScore}}</p>
                    <p>Reviews: {{$prefroshy->numComments}}</p>
                    <p><a href="/comments/{{$prefroshy->id }}"><b>More</b></a></p>
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