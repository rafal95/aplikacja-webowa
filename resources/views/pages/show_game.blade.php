
@extends('layout')



@section('content')

<div id="app">
        <nav class="navbar navbar-expand-md navbar-dark navbar-laravel">
            <div class="container">
                    <a class="navbar-brand" href="{{ url('/pages') }}">
                        <img src="../home.png" alt="Tu podaj tekst alternatywny" width="30" height="30" > 
                    </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>
    
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                 <!-- Left Side Of Navbar -->
                 <ul class="navbar-nav nav-tabs mr-auto">
                        <a class="nav-link">Rozgrywki: {{$game->name}}</a>
                 </ul>
                 <!-- Right Side Of Navbar -->
                 <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </li>
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>
    
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ url('/pages') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>
    
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                            <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
    

<div class="container">
<div class="row">
    <div class="col-sm-6" style="margin-top: 10px">
         <table class="table table-hover">
                        <tr>
                                <th>Pozycja</th>
                                <th>Nazwa</th>
                                <th>Punkty</th>
                                <th>Mecze</th>
                                <th>Bramki</th>
                                <th>GD</th>
                        </tr>
                    <?php $count = 0 ?>
                    @foreach($teams as $team)
                        <?php $count++ ?>
                        <tr>
                            <td><a class="btn btn-info">{{$count}}</a></td>
                            <td><a class="btn btn-info">{{$team->name}}</a></td>
                            <td><a class="btn btn-info">{{$team->points}}</a></td>
                            <td><a class="btn btn-info">{{$team->matches}}</a></td>
                            <td><a class="btn btn-info">{{$team->golas_scored}} - {{$team->goals_lost}}</a></td>
                            <td><a class="btn btn-info">{{$team->golas_scored - $team->goals_lost}}</a></td>
                        </tr>
                    @endforeach
                </table>
    </div>
    <div class="col-sm-5 offset-sm-1" style="margin-top: 10px">
            <table class="table table-hover">
                    
                           <tr>
                                   <th>Terminarz</th>
                           </tr>
                           @foreach($matches as $match)
                           <tr>
                                    <td><a class="btn btn-info">{{$match->home_team}}</a></td>
                                    @if($match->status)
                                        <td><a class="btn btn-info">{{$match->goals_home_team}}</a></td>
                                        <td><a class="btn btn-info">:</a></td>
                                        <td><a class="btn btn-info">{{$match->goals_away_team}}</a></td>
                                    @else
                                        <td><a class="btn btn-info"></a></td>
                                        <td><a class="btn btn-info">:</a></td>
                                        <td><a class="btn btn-info"></a></td>
                                    @endif
                                    <td> <a class="btn btn-info">{{$match->away_team}}</a></td>
                           </tr>
                           @endforeach                     
            </table>
            
                {{$matches->links()}}
            
       </div>
    </div>       
</div>

@endsection

