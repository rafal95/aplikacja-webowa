<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Game;
use App\Team;
use App\Statistic;
use App\Match;
use App\Cup;
use DB;
use dd;

class PagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $games = Game::all();
        return view('pages.index', compact('games'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $game
     * @return \Illuminate\Http\Response
     */

    public function show_cup_result($id,$count)
    {
         $game = Game::where('id', $id)->first();

         $teams = DB::table('teams')
                 ->leftJoin('statistics','teams.id','statistics.id_team')
                 ->where('id_game',$game->id)
                 ->orderBy('statistics.points','DESC')
                 ->get();
               
            $matches = DB::table('matches')
            ->where('matches.id_game',$game->id)
            ->where('group',$count)
            ->paginate(count($teams));

           $count_group = Cup::where('id_game',$game->id)->max('group_name');

            return view('pages.show_cup_result', compact('game','teams','matches','count_group'));
        
     }
    
    public function show($id)
    {
        
        $game = Game::where('id', $id)->first();

        if($game->typ=='Liga'){
            $teams = DB::table('teams')
                    ->leftJoin('statistics','teams.id','statistics.id_team')
                    ->where('id_game',$game->id)
                    ->orderBy('statistics.points','DESC')
                    ->orderBy('statistics.matches','ASC')
                    ->get();

            $matches = DB::table('matches')
                    ->where('id_game',$game->id)
                    ->paginate(intval(count($teams)/2));

            return view('pages.game', compact('game','teams','matches'));
        }
        else if($game->typ=='Puchar'){
            $teams = DB::table('teams')
                    ->leftJoin('statistics','teams.id','statistics.id_team')
                    ->leftJoin('cups','teams.id','cups.id_team')
                    ->where('teams.id_game',$game->id)
                    ->orderBy('statistics.points','DESC')
                    ->orderBy('statistics.matches','ASC')
                    ->get();

            $count_group = Cup::where('id_game',$game->id)->max('group_name');

            return view('pages.cup', compact('game','teams','count_group'));
        }
    }

     /**
     * Display the specified resource.
     *
     * @param  int $game
     * @return \Illuminate\Http\Response
     */
    public function show_game($id)
    {
         $game = Game::where('id', $id)->first();
        /* $teams = Team::where('id_game',$game->id)->with(['statistic'=>function($query){
             $query->orderBy('points');
         }])->get();*/
         if($game->typ=='Liga'){
            $teams = DB::table('teams')
                    ->leftJoin('statistics','teams.id','statistics.id_team')
                    ->where('id_game',$game->id)
                    ->orderBy('statistics.points','DESC')
                    ->orderBy('statistics.matches','ASC')
                    ->get();
    
            $matches = DB::table('matches')
                    ->where('id_game',$game->id)
                    ->paginate(intval(count($teams)/2));
    
            return view('pages.show_game', compact('game','teams','matches'));

         }else if($game->typ=='Puchar'){
            $teams = DB::table('teams')
                    ->leftJoin('statistics','teams.id','statistics.id_team')
                    ->leftJoin('cups','teams.id','cups.id_team')
                    ->where('teams.id_game',$game->id)
                    ->orderBy('statistics.points','DESC')
                    ->orderBy('statistics.matches','ASC')
                    ->get();

            $count_group = Cup::where('id_game',$game->id)->max('group_name');

            return view('pages.show_cup', compact('game','teams','count_group'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      /*  $team = Team::where('id_game',$id)->first();
        $stat = Statistic::where('id_team',$team->id)->first();
        
        $stat->points=$stat->points+$request->input('w1');
        $stat->save();*/

        $match = Match::where('id',$id)->first();
        $match->goals_home_team = $request->input('home');
        $match->goals_away_team = $request->input('away');
        $match->status = 1;
        $match->save();

        $id_game = $match->id_game;

        if($match->goals_home_team > $match->goals_away_team){
            $team = Team::where('id_game',$id_game)->where('name',$match->home_team)->first();
            $stat = Statistic::where('id_team',$team->id)->first();

            $stat->points = $stat->points + 3;
            $stat->matches = $stat->matches+1;
            $stat->golas_scored = $stat->golas_scored + $match->goals_home_team;
            $stat->goals_lost = $stat->goals_lost + $match->goals_away_team;
            $stat->save();

            $team = Team::where('id_game',$id_game)->where('name',$match->away_team)->first();
            $stat = Statistic::where('id_team',$team->id)->first();

            $stat->matches = $stat->matches+1;
            $stat->golas_scored = $stat->golas_scored + $match->goals_away_team;
            $stat->goals_lost = $stat->goals_lost + $match->goals_home_team;
            $stat->save();
        }
        else if ($match->goals_home_team < $match->goals_away_team){
            $team = Team::where('id_game',$id_game)->where('name',$match->away_team)->first();
            $stat = Statistic::where('id_team',$team->id)->first();

            $stat->points = $stat->points + 3;
            $stat->matches = $stat->matches+1;
            $stat->golas_scored = $stat->golas_scored + $match->goals_away_team;
            $stat->goals_lost = $stat->goals_lost + $match->goals_home_team;
            $stat->save();

            $team = Team::where('id_game',$id_game)->where('name',$match->home_team)->first();
            $stat = Statistic::where('id_team',$team->id)->first();

            $stat->matches = $stat->matches+1;
            $stat->golas_scored = $stat->golas_scored + $match->goals_home_team;
            $stat->goals_lost = $stat->goals_lost + $match->goals_away_team;
            $stat->save();
        }
        else{
            $team = Team::where('id_game',$id_game)->where('name',$match->home_team)->first();
            $stat = Statistic::where('id_team',$team->id)->first();

            $stat->points = $stat->points + 1;
            $stat->matches = $stat->matches+1;
            $stat->golas_scored = $stat->golas_scored + $match->goals_home_team;
            $stat->goals_lost = $stat->goals_lost + $match->goals_away_team;
            $stat->save();

            $team = Team::where('id_game',$id_game)->where('name',$match->away_team)->first();
            $stat = Statistic::where('id_team',$team->id)->first();

            $stat->points = $stat->points + 1;
            $stat->matches = $stat->matches+1;
            $stat->golas_scored = $stat->golas_scored + $match->goals_away_team;
            $stat->goals_lost = $stat->goals_lost + $match->goals_home_team;
            $stat->save();
        }


        return redirect()->route('pages.show',$id_game);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
