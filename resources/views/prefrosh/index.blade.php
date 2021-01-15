@extends('layouts.allApp')

@section('content')
    <h1>All</h1>
    <div class="col-md-3">
        <ul style="list-style-type: none;padding:0;">
            @foreach($prefrosh as $prefroshy)
                <li style="text-decoration: none;"><a href="{{ url('/comments',$prefroshy->id) . '/0/edit' }}">{{$prefroshy->name}}</a></li>
            @endforeach
        </ul>
    </div>

    <div class="col-md-9">
        <div class="row">
            <?php $idx = 0; ?>
            @foreach($prefrosh as $index => $prefroshy)
                <?php $idx++ ?>

                <div class="col-md-4">
                    <a href="{{ url('/comments',$prefroshy->id) . '/0/edit' }}">
                        <img src="{{ url('../images', $prefroshy->picture) }}" width="200">

                        <p> {{ $prefroshy->name }}</p>
                    </a>
                    @if($show_tiers)
                        <p>Tier: <b>{{ $tier_names[$prefroshy->tier]}} </b></p>
                    @endif
                    <p>Rating: {{$comments[$index]->rating}}</p>
                    <p>Review: {{$comments[$index]->review}}
                        <a href="{{ url('/comments',$prefroshy->id) . '/0/edit' }}"><b>Edit</b></a>
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