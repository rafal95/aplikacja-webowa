<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Game;
use App\Team;
use App\Match;
use App\Statistic;
use App\Cup;
use DD;
use DB;

class GameController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
       // $game = Game::where('id', $id)->first();
       // $teams = Team::where('id_game',$game->id)->get();
        return view('pages.game');
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

    public function manage($id)
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

    public function store(Request $request,$id)
    {
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


        return redirect()->route('manage',$id_game); //pages.show
    }

    /**
     * Display the specified resource.
     *
     * @param  int $game
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $game = Game::where('id', $id)->first();

         $teams = DB::table('teams')
                 ->leftJoin('statistics','teams.id','statistics.id_team')
                 ->where('id_game',$game->id)
                 ->orderBy('statistics.points','DESC')
                 ->get();
               
         $matches = DB::table('matches')
                 ->where('id_game',$game->id)
                 ->paginate(intval(count($teams)/2));
 
            return view('pages.edit_result', compact('game','teams','matches'));
     }

    public function show_table($id)
    {
        $game = Game::where('id', $id)->first();

         $teams = DB::table('teams')
                 ->leftJoin('statistics','teams.id','statistics.id_team')
                 ->where('id_game',$game->id)
                 ->orderBy('statistics.points','DESC')
                 ->orderBy('statistics.matches','ASC')
                 ->get();
               
         return view('pages.table', compact('game','teams'));
     }

     public function cup_edit_result($id,$count)
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

             return view('pages.cup_edit_result', compact('game','teams','matches','count_group'));
         
      }

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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $match = Match::where('id',$id)->first();
        $match->status = 0;
        $match->save();

        $game = Game::where('id',$match->id_game)->first();
        $id_game = $match->id_game;
        $count_group =0;
        if($game->typ=='Puchar')
            $count_group = Cup::where('id_game',$match->id_game)->max('group_name');

        if($match->group<=$count_group or $game->typ=='Liga'){
            if($match->goals_home_team > $match->goals_away_team){
                $team = Team::where('id_game',$id_game)->where('name',$match->home_team)->first();
                $stat = Statistic::where('id_team',$team->id)->first();

                $stat->points = $stat->points - 3;
                $stat->matches = $stat->matches-1;
                $stat->golas_scored = $stat->golas_scored - $match->goals_home_team;
                $stat->goals_lost = $stat->goals_lost - $match->goals_away_team;
                $stat->save();

                $team = Team::where('id_game',$id_game)->where('name',$match->away_team)->first();
                $stat = Statistic::where('id_team',$team->id)->first();

                $stat->matches = $stat->matches-1;
                $stat->golas_scored = $stat->golas_scored - $match->goals_away_team;
                $stat->goals_lost = $stat->goals_lost - $match->goals_home_team;
                $stat->save();
            }
            else if ($match->goals_home_team < $match->goals_away_team){
                $team = Team::where('id_game',$id_game)->where('name',$match->away_team)->first();
                $stat = Statistic::where('id_team',$team->id)->first();

                $stat->points = $stat->points - 3;
                $stat->matches = $stat->matches-1;
                $stat->golas_scored = $stat->golas_scored - $match->goals_away_team;
                $stat->goals_lost = $stat->goals_lost - $match->goals_home_team;
                $stat->save();

                $team = Team::where('id_game',$id_game)->where('name',$match->home_team)->first();
                $stat = Statistic::where('id_team',$team->id)->first();

                $stat->matches = $stat->matches-1;
                $stat->golas_scored = $stat->golas_scored - $match->goals_home_team;
                $stat->goals_lost = $stat->goals_lost - $match->goals_away_team;
                $stat->save();
            }
            else{
                $team = Team::where('id_game',$id_game)->where('name',$match->home_team)->first();
                $stat = Statistic::where('id_team',$team->id)->first();

                $stat->points = $stat->points - 1;
                $stat->matches = $stat->matches-1;
                $stat->golas_scored = $stat->golas_scored - $match->goals_home_team;
                $stat->goals_lost = $stat->goals_lost - $match->goals_away_team;
                $stat->save();

                $team = Team::where('id_game',$id_game)->where('name',$match->away_team)->first();
                $stat = Statistic::where('id_team',$team->id)->first();

                $stat->points = $stat->points - 1;
                $stat->matches = $stat->matches-1;
                $stat->golas_scored = $stat->golas_scored - $match->goals_away_team;
                $stat->goals_lost = $stat->goals_lost - $match->goals_home_team;
                $stat->save();
            }
        }
        if($game->typ=="Liga")
            return redirect()->route('game.show_result',$id_game);
        else if($game->typ=="Puchar")
            return redirect()->route('game.cup_edit_result',[$id_game,$match->group]);
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
        $count_group =0;
        // jezeli match -> group jest wieksze od count group
        $match = Match::where('id',$id)->first();
        $game = Game::where('id',$match->id_game)->first();
        if($game->typ=='Puchar')
            $count_group = Cup::where('id_game',$match->id_game)->max('group_name');

        if($match->group<=$count_group or $game->typ=='Liga'){
            $match->goals_home_team = $request->input('home');
            $match->goals_away_team = $request->input('away');
            $match->status = 1;
            $match->save();
            // nie potrzben chyba to nziej
            $game = Game::where('id',$match->id_game)->first();
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
        }else{
            $id_game = $match->id_game;
            $match->goals_home_team = $request->input('home');
            $match->goals_away_team = $request->input('away');
            $match->status = 1;
            $match->save();
        }

        if($game->typ=="Liga")
            return redirect()->route('game.show_result',$id_game);
        else if($game->typ=="Puchar"){
            $count_matches = 0;

                $teams = Cup::where('id_game',$id_game)
                        ->where('group_name',$match->group)
                        ->get();

                foreach($teams as $team){
                    $stat = Statistic::where('id_team',$team->id_team)->first();
                    $count_matches += $stat->matches;
                }  
                if($count_matches == count($teams)*(count($teams)-1)){
                    if($match->group<=$count_group){
                        if($match->group%2 == 0){
                            $teams = DB::table('teams')
                                    ->leftJoin('statistics','teams.id','statistics.id_team')
                                    ->leftJoin('cups','teams.id','cups.id_team')
                                    ->where('teams.id_game',$game->id)
                                    ->where('cups.group_name',$match->group)
                                    ->orderBy('statistics.points','DESC')
                                    ->orderBy('statistics.matches','ASC')
                                    ->get();
                            
                            $matches = Match::where('id_game',$id_game)
                                    ->where('home_team','G'.$match->group.'/M1')
                                    ->first();

                            $matches->home_team = $teams[0]->name;
                            $matches->save();

                            $matches = Match::where('id_game',$id_game)
                                    ->where('home_team','G'.$match->group.'/M2')
                                    ->first();

                            $matches->home_team = $teams[1]->name;
                            $matches->save();
                        }
                        else{
                            $teams = DB::table('teams')
                                    ->leftJoin('statistics','teams.id','statistics.id_team')
                                    ->leftJoin('cups','teams.id','cups.id_team')
                                    ->where('teams.id_game',$game->id)
                                    ->where('cups.group_name',$match->group)
                                    ->orderBy('statistics.points','DESC')
                                    ->orderBy('statistics.matches','ASC')
                                    ->get();
                    
                            $matches = Match::where('id_game',$id_game)
                                    ->where('away_team','G'.$match->group.'/M2')
                                    ->first();

                            $matches->away_team = $teams[1]->name;
                            $matches->save();

                            $matches = Match::where('id_game',$id_game)
                                    ->where('away_team','G'.$match->group.'/M1')
                                    ->first();

                            $matches->away_team = $teams[0]->name;
                            $matches->save();
                        }
                    }
                    // nie potrzebne to nizej
                    $count_group = Cup::where('id_game',$id_game)->max('group_name');

                    if($count_group>=2){
                        $matches = Match::where('id_game',$id_game)
                                ->where('group',$count_group+2)
                                ->get();
                        
                        $schedule = Match::where('id_game',$id_game)
                                ->where('group',$count_group+3)
                                ->get();

                        $tmp=0;
                        for($i=0;$i<($count_group+1)/2;$i=$i+2){
                            if($match->group<$count_group+2){
                                $schedule[$tmp]->home_team = ($matches[$i*2]->home_team).' / '.($matches[$i*2]->away_team);
                                $schedule[$tmp]->away_team = ($matches[$i*2+2]->home_team).' / '.($matches[$i*2+2]->away_team);
                                $schedule[$tmp++]->save();

                                $schedule[$tmp]->home_team =  ($matches[$i*2+1]->home_team).' / '.($matches[$i*2+1]->away_team);;
                                $schedule[$tmp]->away_team = ($matches[$i*2+3]->home_team).' / '.($matches[$i*2+3]->away_team);;
                                $schedule[$tmp++]->save();
                            }else{
                                // jezeli maches i*2 ma status true to w schedule(tmp) = zwycie
                                if($matches[$i*2]->status){
                                    if($matches[$i*2]->goals_home_team > $matches[$i*2]->goals_away_team){
                                        $schedule[$tmp]->home_team = $matches[$i*2]->home_team;
                                        $schedule[$tmp]->save();
                                    }
                                    else{
                                        $schedule[$tmp]->home_team = $matches[$i*2]->away_team;
                                        $schedule[$tmp]->save();
                                    }
                                }

                                if($matches[$i*2+2]->status){
                                    if($matches[$i*2+2]->goals_home_team > $matches[$i*2+2]->goals_away_team){
                                        $schedule[$tmp]->away_team = $matches[$i*2+2]->home_team;
                                        $schedule[$tmp]->save();
                                    }
                                    else{
                                        $schedule[$tmp]->away_team = $matches[$i*2+2]->away_team;
                                        $schedule[$tmp]->save();
                                    }
                                }
                                $tmp++;
                                if($matches[$i*2+1]->status){
                                    if($matches[$i*2+1]->goals_home_team > $matches[$i*2+1]->goals_away_team){
                                        $schedule[$tmp]->home_team = $matches[$i*2+1]->home_team;
                                        $schedule[$tmp]->save();
                                    }
                                    else{
                                        $schedule[$tmp]->home_team = $matches[$i*2+1]->away_team;
                                        $schedule[$tmp]->save();
                                    }
                                }

                                if($matches[$i*2+3]->status){
                                    if($matches[$i*2+3]->goals_home_team > $matches[$i*2+3]->goals_away_team){
                                        $schedule[$tmp]->away_team = $matches[$i*2+3]->home_team;
                                        $schedule[$tmp]->save();
                                    }
                                    else{
                                        $schedule[$tmp]->away_team = $matches[$i*2+3]->away_team;
                                        $schedule[$tmp]->save();
                                    }
                                }
                                $tmp++;
                            }
                            
                        }
                    }


                    if($count_group>=4){
                        $matches = Match::where('id_game',$id_game)
                                ->where('group',$count_group+3)
                                ->get();
                        
                        $schedule = Match::where('id_game',$id_game)
                                ->where('group',$count_group+4)
                                ->get();

                        $tmp=0;
                        for($i=0;$i<($count_group+1)/4;$i=$i+2){
                            if($match->group<$count_group+3){
                                $schedule[$tmp]->home_team = ($matches[$i*2]->home_team).' / '.($matches[$i*2]->away_team);
                                $schedule[$tmp]->away_team = ($matches[$i*2+2]->home_team).' / '.($matches[$i*2+2]->away_team);
                                $schedule[$tmp++]->save();

                                $schedule[$tmp]->home_team =  ($matches[$i*2+1]->home_team).' / '.($matches[$i*2+1]->away_team);;
                                $schedule[$tmp]->away_team = ($matches[$i*2+3]->home_team).' / '.($matches[$i*2+3]->away_team);;
                                $schedule[$tmp++]->save();
                            }else{
                                // jezeli maches i*2 ma status true to w schedule(tmp) = zwycie
                                if($matches[$i*2]->status){
                                    if($matches[$i*2]->goals_home_team > $matches[$i*2]->goals_away_team){
                                        $schedule[$tmp]->home_team = $matches[$i*2]->home_team;
                                        $schedule[$tmp]->save();
                                    }
                                    else{
                                        $schedule[$tmp]->home_team = $matches[$i*2]->away_team;
                                        $schedule[$tmp]->save();
                                    }
                                }

                                if($matches[$i*2+2]->status){
                                    if($matches[$i*2+2]->goals_home_team > $matches[$i*2+2]->goals_away_team){
                                        $schedule[$tmp]->away_team = $matches[$i*2+2]->home_team;
                                        $schedule[$tmp]->save();
                                    }
                                    else{
                                        $schedule[$tmp]->away_team = $matches[$i*2+2]->away_team;
                                        $schedule[$tmp]->save();
                                    }
                                }
                                $tmp++;
                                if($matches[$i*2+1]->status){
                                    if($matches[$i*2+1]->goals_home_team > $matches[$i*2+1]->goals_away_team){
                                        $schedule[$tmp]->home_team = $matches[$i*2+1]->home_team;
                                        $schedule[$tmp]->save();
                                    }
                                    else{
                                        $schedule[$tmp]->home_team = $matches[$i*2+1]->away_team;
                                        $schedule[$tmp]->save();
                                    }
                                }

                                if($matches[$i*2+3]->status){
                                    if($matches[$i*2+3]->goals_home_team > $matches[$i*2+3]->goals_away_team){
                                        $schedule[$tmp]->away_team = $matches[$i*2+3]->home_team;
                                        $schedule[$tmp]->save();
                                    }
                                    else{
                                        $schedule[$tmp]->away_team = $matches[$i*2+3]->away_team;
                                        $schedule[$tmp]->save();
                                    }
                                }
                                $tmp++;
                            }
                        }
                    }

                    //final
                    if($count_group>=2){
                        $matches = Match::where('id_game',$id_game)
                                ->where('group',$count_group+3)
                                ->get();
                        
                        $schedule = Match::where('id_game',$id_game)
                                ->where('group',$count_group+4)
                                ->get();
                        
                        if($match->group<$count_group+3){
                                $schedule[0]->home_team = ($matches[0]->home_team).' / '.($matches[0]->away_team);
                                $schedule[0]->away_team = ($matches[1]->home_team).' / '.($matches[1]->away_team);
                                $schedule[0]->save();
                        }else{
                            if($matches[0]->status){
                                if($matches[0]->goals_home_team > $matches[0]->goals_away_team){
                                    $schedule[0]->home_team = $matches[0]->home_team;
                                    $schedule[0]->save();
                                }
                                else{
                                    $schedule[0]->home_team = $matches[0]->away_team;
                                    $schedule[0]->save();
                                }
                            }
                            if($matches[1]->status){
                                if($matches[1]->goals_home_team > $matches[1]->goals_away_team){
                                    $schedule[0]->away_team = $matches[1]->home_team;
                                    $schedule[0]->save();
                                }
                                else{
                                    $schedule[0]->away_team = $matches[1]->away_team;
                                    $schedule[0]->save();
                                }
                            }
                        }
                    }
                    
                    if($count_group>=4){
                        $matches = Match::where('id_game',$id_game)
                                ->where('group',$count_group+4)
                                ->get();
                        
                        $schedule = Match::where('id_game',$id_game)
                                ->where('group',$count_group+5)
                                ->get();
                        
                        if($match->group<$count_group+4){
                                $schedule[0]->home_team = ($matches[0]->home_team).' / '.($matches[0]->away_team);
                                $schedule[0]->away_team = ($matches[1]->home_team).' / '.($matches[1]->away_team);
                                $schedule[0]->save();
                        }else{
                            if($matches[0]->status){
                                if($matches[0]->goals_home_team > $matches[0]->goals_away_team){
                                    $schedule[0]->home_team = $matches[0]->home_team;
                                    $schedule[0]->save();
                                }
                                else{
                                    $schedule[0]->home_team = $matches[0]->away_team;
                                    $schedule[0]->save();
                                }
                            }
                            if($matches[1]->status){
                                if($matches[1]->goals_home_team > $matches[1]->goals_away_team){
                                    $schedule[0]->away_team = $matches[1]->home_team;
                                    $schedule[0]->save();
                                }
                                else{
                                    $schedule[0]->away_team = $matches[1]->away_team;
                                    $schedule[0]->save();
                                }
                            }
                        }
                        
                    }

                }

            return redirect()->route('game.cup_edit_result',[$id_game,$match->group]);
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $teams = Team::where('id_game',$id)->get();
       
        foreach($teams as $team){
            echo $team->id;
            DB::table('statistics')->where('id_team',$team->id)->delete();
        }
        DB::table('matches')->where('id_game',$id)->delete();
        DB::table('cups')->where('id_game',$id)->delete();
        DB::table('teams')->where('id_game',$id)->delete();
        DB::table('games')->where('id',$id)->delete();

        $games = Game::all();

        return redirect()->route('pages.index');
    }

}