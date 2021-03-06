


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Avery Rotation</title>

    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>


    <!-- Fonts -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700" rel='stylesheet' type='text/css'>

    <!-- Styles -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    {{-- <link href="{{ elixir('css/app.css') }}" rel="stylesheet"> --}}

    <style>
        body {
            font-family: 'Lato';
        }

        .fa-btn {
            margin-right: 6px;
        }
    </style>
</head>
<body id="app-layout">
<nav class="navbar navbar-default navbar-static-top">
    <div class="container">
        <div class="row">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ url('/') }}">Avery</a>
                <a class="navbar-brand" href="{{ url('/calendar') }}">Calendar</a>
                <a class="navbar-brand" href="{{ url('/mySubmissions') }}">User Profiles</a>
            </div> </div>
        <div class="row">
            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    @foreach( App\Meal::all() as $meal)
                        <li><a href="{{ url('/meals', $meal->id) }}">{{ $meal->name }}</a></li>
                        @if($meal->id == 8)
                </ul><ul class="nav navbar-nav">
                    @endif
                    @endforeach

                    <li><a href="{{ url('/users/index') }}">All</a></li>

                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    @if (Auth::guest())
                        <li><a href="{{ url('/login') }}">Login</a></li>
                        <li><a href="{{ url('/register') }}">Register</a></li>
                    @else
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>
                                <li><a href="{{  url('/passwordChange') }}">Change Password</a></li>
                            </ul>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
</nav>
<div class="container">
    <h1>{{ $user->name }}</h1>
    <h1>Submissions</h1>
    <div class="col-md-3">
        <ul style="list-style-type: none;padding:0;">
            @foreach($prefrosh as $prefroshy)
                <li style="text-decoration: none;"><a href="{{ url('/comments',$prefroshy->id) . '/edit' }}">{{$prefroshy->name}}</a></li>
            @endforeach
        </ul>
    </div>

    <div class="col-md-9">
        <div class="row">
            <?php $idx = 0; ?>
            @foreach($prefrosh as $index => $prefroshy)
                <?php $idx++ ?>

                <div class="col-md-4">
                    <a href="{{ url('/comments',$prefroshy->id) . '/edit' }}">
                        <img src="{{ url('../images', $prefroshy->picture) }}" width="200">

                        <p> {{ $prefroshy->name }}</p>
                    </a>

                    <p>Rating: {{$comments[$index]->rating}}</p>
                    <p>Review: {{$comments[$index]->review}}
                        <a href="{{ url('/comments',$prefroshy->id) . '/edit' }}"><b>Edit</b></a>
                    </p>
                </div>
                </a>
                @if($idx % 3 == 0)
        </div>&nbsp;<div class="row">
            @endif
            @endforeach

        </div>
    </div>

</div>


<!-- JavaScripts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
{{-- <script src="{{ elixir('js/app.js') }}"></script> --}}
</body>

@yield('footer')
</html>
