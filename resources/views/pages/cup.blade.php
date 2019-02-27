
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
                            <li class="nav-item">
                                    <a class="nav-link" href="{{route('pages.show',$game->id)}}">Grupy</a>
                            </li>
                            <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Edytuj wyniki
                                    </a>
                                    <div class="dropdown-menu">
                                            @for($i=0;$i<=$count_group;$i++)
                                                <a class="dropdown-item" href="{{route('game.cup_edit_result',[$game->id,$i])}}">{{"Grupa $i"}}</a>
                                            @endfor
                                            @if($count_group > 4-1)
                                                <a class="dropdown-item" href="{{route('game.cup_edit_result',[$game->id,++$i])}}">1/8 finału</a>
                                            @endif
                                            @if($count_group > 2-1)
                                                <a class="dropdown-item" href="{{route('game.cup_edit_result',[$game->id,++$i])}}">1/4 finału</a>
                                            @endif
                                            @if($count_group > 1-1)
                                                <a class="dropdown-item" href="{{route('game.cup_edit_result',[$game->id,++$i])}}">1/2 finału</a>
                                            @endif
                                                <a class="dropdown-item" href="{{route('game.cup_edit_result',[$game->id,++$i])}}">Finał</a>
                                    </div>
                            </li>
                            <li class="nav-item">
                                    <a class="nav-link" href="{{route('game.destroy',$game->id)}}">Zakończ rozgrywkę</a>
                            </li>
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



<!--<nav class="navbar navbar-dark bg-info">
    <div class="container">
        <ul class="nav nav-tabs">
                <li class="nav-item">
                  <a class="nav-link active" href="{{route('pages.show',$game->id)}}">Strona główna</a>
                </li>
                <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          Edytuj wyniki
                        </a>
                        <div class="dropdown-menu">
                            @for($i=0;$i<=$count_group;$i++)
                                <a class="dropdown-item" href="{{route('game.cup_edit_result',[$game->id,$i])}}">{{"Grupa $i"}}</a>
                            @endfor
                            @if($count_group > 4-1)
                                <a class="dropdown-item" href="{{route('game.cup_edit_result',[$game->id,++$i])}}">1/8 finału</a>
                            @endif
                            @if($count_group > 2-1)
                                <a class="dropdown-item" href="{{route('game.cup_edit_result',[$game->id,++$i])}}">1/4 finału</a>
                            @endif
                            @if($count_group > 1-1)
                                <a class="dropdown-item" href="{{route('game.cup_edit_result',[$game->id,++$i])}}">1/2 finału</a>
                            @endif
                                <a class="dropdown-item" href="{{route('game.cup_edit_result',[$game->id,++$i])}}">Finał</a>
                        </div>
                    </li>
                <li class="nav-item">
                  <a class="nav-link" href="{{route('game.destroy',$game->id)}}">Zakończ rozgrywkę</a>
                </li>
        </ul>
    </div>
</nav><!-->
<div class="container">

<div class="row">
    @for($i=0;$i<=$count_group;$i++)
    <div class="col-sm-6" style="margin-top: 10px">
        
         <table class="table-sm table-hover">
                        <tr>
                            <td>{{"Grupa $i"}}</td>
                        </tr>
                        <tr>
                                <th>Pozycja</th>
                                <th>Nazwa</th>
                                <th>Pynkty</th>
                                <th>Mecze</th>
                                <th>Bramki</th>
                                <th>GD</th>
                        </tr>
                    <?php $count = 0 ?>
                    @foreach($teams as $team)
                        @if($team->group_name==$i)
                            <?php $count++ ?>
                            <tr>
                                <td><a class="btn btn-info">{{$count}}</a></td>
                                <td><a class="btn btn-info">{{$team->name}}</a></td>
                                <td><a class="btn btn-info">{{$team->points}}</a></td>
                                <td><a class="btn btn-info">{{$team->matches}}</a></td>
                                <td><a class="btn btn-info">{{$team->golas_scored}} - {{$team->goals_lost}}</a></td>
                                <td><a class="btn btn-info">{{$team->golas_scored - $team->goals_lost}}</a></td>
                            </tr>
                        @endif
                    @endforeach
                </table>
       
    </div>
    @endfor
</div>       
</div>

@endsection

 