@extends('layouts.allApp')

@section('content')

    <div class="Table">
        <div class="Heading">
            <div class="Cell">
                <p>Name</p>
            </div>
            <div class="Cell">
                <p>Num Comments</p>
            </div>
            <div class="Cell">
                <p>Sum Score</p>
            </div>
            <div class="Cell">
                <p>Average Score</p>
            </div>
        </div>

        @foreach($users as $user)
            <div class="Row">
                <div class="Cell">
                    <p> <a href="{{ url('/users', $user->id) }}">{{$user->name}} </a> </p>
                </div>

                <div class="Cell">
                    <p>{{$user->numComments}}</p>
                </div>

                <div class="Cell">
                    <p>{{$user->sumScore}}</p>
                </div>
                <div class="Cell">
                    <p>{{round($user->sumScore / $user->numComments, 3)}}</p>
                </div>
            </div>
        @endforeach


    </div>

@endsection

@section('footer')

    <style>
        .jobs-table
        {
            empty-cells: show;
            width:       100%;
            text-align:  left;
            padding:     100px;
        }
    </style>

    <style type="text/css">
        .Table
        {
            display: table;
        }
        .Title
        {
            display: table-caption;
            text-align: center;
            font-weight: bold;
            font-size: larger;

        }

        .Heading
        {
            display: table-row;
            font-weight: bold;
            text-align: center;
        }

        .Row
        {
            display: table-row;
        }

        .Cell
        {
            display: table-cell;
            border: solid;
            border-width: thin;
            padding-left: 5px;
            padding-right: 5px;
        }
        table, td {
            border: 1px solid black;
        }

        th {
            border: 2px solid black;
        }
        th, td {
            padding: 10px;
        }


    </style>
@stop