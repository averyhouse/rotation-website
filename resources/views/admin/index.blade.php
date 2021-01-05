@extends('layouts.allApp')

@section('content')
    {!! Form::open(['url' => 'users/index', 'method' => 'put']) !!}
    <div class="row">
        <div class="col-md-3">
            <h1>All</h1>
        </div>
        <div class="col-md-9">
            <h3>
            Sort by:
                @foreach($categories as $idx => $category)

                    <a href="{{ $idx + 1 }}">
                        @if($idx + 1 == $sortType)
                            <b>{{ $category }}</b>
                        @else
                            {{ $category }}
                        @endif

                    </a>
                    &nbsp;
                @endforeach

            </h3>
        </div>
    </div>
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
            @foreach($prefrosh as $index => $prefroshy)
                <?php $idx++ ?>

                <div class="col-md-4">
                    <a href="/comments/{{$prefroshy->id }}">
                        <img src="/images/{{ $prefroshy->picture }}" width="200">

                        <p> {{ $prefroshy->name }}</p>
                    </a>
                    {!! Form::label($prefroshy->id, 'Tier: ') !!}
                    {!! Form::select($prefroshy->id, array(2 => "Great", 1 => "Good", 0 => "Neutral", -1 => "No Information", -2 => "Poor"), $prefroshy->tier, ['class' => 'form-control']) !!}
                    @if($show_ratings)

                        <p>Rating: {{$prefroshy->sumScore}}</p>
                    @else
                        <p>Rating: N/A </p>
                    @endif
                    <p>Reviews: {{$prefroshy->numComments}}</p>
                        <a class='btn btn-primary' href="/comments/{{$prefroshy->id }}"><b>More</b></a>
                    <!--{!! Form::submit('Save', ['class' => 'btn btn-success']) !!}-->

                    </p>
                </div>
                </a>
                @if($idx % 3 == 0)
        </div>&nbsp;<div class="row">
            @endif
            @endforeach

        </div>
        {!! Form::submit('Save', ['class' => 'btn btn-success form-control']) !!}
    </div>

    {!! Form::close() !!}

@endsection

@section('footer')


@endsection