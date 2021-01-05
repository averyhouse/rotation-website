@extends('layouts.editApp')

@section('content')

    <table>
        <tr>
            <th>Date</th>
            <th>Wed. 9/20</th>
            <th>Thu. 9/21</th>
            <th>Fri. 9/22</th>
            <th>Sat. 9/23</th>
            <th>Sun. 9/24</th>
            <th>Mon. 9/25</th>
            <th>Tue. 9/26</th>
            <th>Wed. 9/27</th>
            <th>Thu. 9/28</th>
        </tr>

        <tr>
            <th>Lunch</th>
            <th></th>
            <th></th>
            <th></th>

            <th><a href="meals/4">D</a></th>
            <th><a href="meals/6">F</a></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
        </tr>

        <tr>
            <th>Dinner</th>
            <th><a href="meals/1">A</a></th>
            <th><a href="meals/2">B</a></th>
            <th><a href="meals/3">C</a></th>
            <th><a href="meals/5">E</a></th>
            <th></th>
            <th><a href="meals/7">G</a></th>
            <th><a href="meals/8">H</a></th>
            <th>Free Dinner</th>
            <th>Free Dinner</th>

        </tr>

        <tr>
            <th>Dessert</th>
            <th><a href="meals/9">1</a></th>
            <th><a href="meals/10">2</a></th>
            <th></th>
            <th><a href="meals/11">3</a></th>
            <th><a href="meals/12">4</a></th>
            <th><a href="meals/13">5</a></th>
            <th><a href="meals/14">6</a></th>
            <th><a href="meals/15">7</a></th>
            <th></th>

        </tr>
    </table>
@endsection

@section('footer')
    <style type="text/css">
        table, th, td {
            border: 1px solid black;
        }

        th, td {
            padding: 5px;
        }

        th {
            text-align: center;
        }
    </style>
@endsection