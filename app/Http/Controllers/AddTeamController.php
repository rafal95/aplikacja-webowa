<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Game;
use App\Team;
use App\Statistic;
use App\Match;
use App\Cup;
use DB;

class AddTeamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id = Game::Pluck('id');
        $c = count($id);
        $i = 0;
        foreach($id as $item)
        {
            $i++;
            if($i == $c){$results = $item;}
        }

        $game = Game::all()->last();
        $team = Team::whereIn('id_game',[$results])->get();

        return view('pages.add_team', compact('team','game'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.new_game');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $id = Game::Pluck('id');
        $c = count($id);
        $i = 0;
        foreach($id as $item)
        {
            $i++;
            if($i == $c){$results = $item;}
        }


        $team = new Team;
        $team->name = $request->input('team_name');
        $team->id_game = $results;
        $team->save();


        $stat = new Statistic;
        $stat->id_team = $team->id;
        $stat->save();

        return redirect()->route('add_team.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        $game = Game::where('id', $id)->first();
       /* $teams = Team::where('id_game',$game->id)->with(['statistic'=>function($query){
            $query->orderBy('points');
        }])->get();*/
        $teams = DB::table('teams')
                ->leftJoin('statistics','teams.id','statistics.id_team')
                ->where('id_game',$game->id)
                ->orderBy('statistics.points','DESC')
                ->get();

      /*  if(count($teams)%2 > 0){
            $team = new Team;
            $team->name = "Pauza";
            $team->id_game = $id;
            $team->save();

            $teams = DB::table('teams')
            ->leftJoin('statistics','teams.id','statistics.id_team')
            ->where('id_game',$game->id)
            ->orderBy('statistics.points','DESC')
            ->get();
        }*/
        
        if($game->typ=='Liga'){
           // return view('pages.terminarz', compact('teams'));
            $storage = Match::generate(count($teams)); 
            
//jezeli liczba drzyn nie podzielna przez 2 to k (liczba kolejek)
            if(count($teams)%2 > 0)
                $kolejek = count($teams);
            else
                $kolejek = count($teams)-1;

            for($k=0;$k<$kolejek;$k++){
                for($i=0;$i<intval(count($teams))/2;$i++){
                    $schedule = new Match;
                    $schedule->id_game = $id;
                    $schedule->home_team = $teams[$storage[$k][$i][0]-1]->name;
                    $schedule->away_team = $teams[$storage[$k][$i][1]-1]->name;
                    $schedule->save();
                }
                $schedule->save();
            }
            return redirect()->route('pages.show',$id);
        }
        else if($game->typ=='Puchar'){

            $teams = DB::table('teams')->where('id_game',$game->id)->get();
            $group = Cup::generate_cup(count($teams));

            $high_group = 0;
           /* if(count($teams) < 6){
                $count_group = 1;
                $count_team_per_group = count($teams);
            }
            else if(count($teams) == 6){
                $count_group = 2;
                $count_team_per_group = 3;
            }
            else if(count($teams) >= 19 and count($teams)<=20){
                if(count($teams) % 5 > 0){
                    $count_group = intval(count($teams)/5)+1;
                    $high_group = intval(count($teams)/5);
                }
                else{
                    $count_group = intval(count($teams)/5);
                    $high_group = $count_group;
                    $count_team_per_group = 5;
                }
            }
            else if(count($teams) >= 21 and count($teams)<=27){
                if(count($teams) % 3 > 0){
                    $count_group = intval(count($teams)/3);
                    $high_group = count($teams) % 3;
                }
                else{
                    $count_group = intval(count($teams)/3);
                    $count_team_per_group = 3;
                }
            }
            else if(count($teams) % 4 > 0){
                if(count($teams) % 4 <= 2){
                    $count_group = intval(count($teams)/4);
                   // $count_team_per_group = 4+1;
                    $high_group = count($teams) % 4;
                }
                else{
                    $count_group = intval(count($teams)/4)+1;
                    $count_team_per_group = 4;
                }
            }
            else if(count($teams) % 4 == 0){
                $count_group = intval(count($teams)/4);
                $count_team_per_group = 4;
            }*/
            //nowe
            $count_group = intval(count($teams)/4);
            if(count($teams)==6){
                $count_group = 2;
                $count_team_per_group = 3;
            }
            else if(count($teams) == 19){
                $count_group = intval(count($teams)/5)+1;
                $high_group = intval(count($teams)/5);
            }
            else if(count($teams) == 20){
                $count_group = intval(count($teams)/5);
                $high_group = $count_group;
                $count_team_per_group = 5;
            }
            else if(count($teams) >= 21 and count($teams)<27){
                if(count($teams) % 3 > 0){
                    $count_group = intval(count($teams)/3);
                    $high_group = count($teams) % 3;
                }
                else{
                    $count_group = intval(count($teams)/3);
                    $count_team_per_group = 3;
                }
            }
            else if(count($teams)% 4 > 0){
                if(count($teams) % 4 <= 2){/// sprawdzuc ile grup ma miec wiecej druzyn
                    $count_group = intval(count($teams)/4);
                    $high_group = count($teams) % 4;
                }
                else{
                    $count_group = intval(count($teams)/4)+1;
                    $count_team_per_group = 4;
                }
            }
            else if(count($teams) % 4 == 0){
                $count_group = intval(count($teams)/4);
                $count_team_per_group = 4;
            }
            
            
            //ednbowe

            $count = 0;
            for($i=0;$i<$count_group;$i++){      
               /* if(count($teams) >= 21 and count($teams)<=27){               
                    if($i+1<=$high_group)
                        $count_team_per_group = 4;
                    else
                        $count_team_per_group = 3;
                }else{
                    if($i+1<=$high_group)
                        $count_team_per_group = 5;
                    else
                        $count_team_per_group = 3;//yu
                }*/
                if(count($teams) >= 21 and count($teams)<27){               
                    if($i+1<=$high_group)
                        $count_team_per_group = 4;
                    else
                        $count_team_per_group = 3;
                }
                else{
                    if($high_group > 0){
                        if($i+1<=$high_group)
                            $count_team_per_group = 5;
                        else
                            $count_team_per_group = 4;//yu
                    }
                }

                for($j=0;$j<$count_team_per_group;$j++){
                    if($count < count($teams)){
                        $cup = new Cup;
                        $cup->id_game = $id;
                        $cup->id_team = $teams[$group[$i][$j]-1]->id;
                        $cup->group_name = $i;
                        $cup->save();
                        $count++;
                    }  
                }
                $cup->save();
            }

            for($count=0;$count<$count_group;$count++){              
                $teams = Team::leftJoin('cups','teams.id','cups.id_team')
                    ->where('teams.id_game',$game->id)
                    ->where('cups.group_name',$count)
                    ->get();

                    if(count($teams)%2 > 0){
                        $team = new Team;
                        $team->name = "Pauza";
                        $team->id_game = $id;
                        $team->save();

                        $pauza = Team::all()->last();

                        $cup = new Cup;
                        $cup->id_game = $id;
                        $cup->id_team = $pauza->id;
                        $cup->group_name = $count;
                        $cup->save();

                        $teams = Team::leftJoin('cups','teams.id','cups.id_team')
                        ->where('teams.id_game',$game->id)
                        ->where('cups.group_name',$count)
                        ->get();
                    }

                    $storage = Match::generate(count($teams)); 
                    if(count($teams)%2 > 0)
                        $kolejek = count($teams);
                    else
                        $kolejek = count($teams)-1;

                    for($k=0;$k<$kolejek;$k++){
                        for($i=0;$i<intval(count($teams))/2;$i++){
                            $schedule = new Match;
                            $schedule->id_game = $id;
                            $schedule->home_team = $teams[$storage[$k][$i][0]-1]->name;
                            $schedule->away_team = $teams[$storage[$k][$i][1]-1]->name;
                            $schedule->group = $teams[$storage[$k][$i][1]-1]->group_name;
                            $schedule->save();
                        }
                        $schedule->save();
                    }  
                    $schedule->save();
            }   
            
                            /// nowe do pucharow - 1/8 itp
                            $count_group = Cup::where('id_game',$game->id)->max('group_name');
                            for($i=0;$i<=$count_group;$i=$i+2){
                                $schedule = new Match;
                                $schedule->id_game = $id;
                                $schedule->home_team = 'G'.$i.'/M1';
                                $schedule->away_team = 'G'.($i+1).'/M2';
                                $schedule->group = $count_group+2;
                                $schedule->save();
        
                                $schedule = new Match;
                                $schedule->id_game = $id;
                                $schedule->home_team = 'G'.$i.'/M2';
                                $schedule->away_team = 'G'.($i+1).'/M1';
                                $schedule->group = $count_group+2;
                                $schedule->save();
                            }
                            // 1/4

                            if($count_group>=2){
                                $matches = Match::where('id_game',$id)
                                        ->where('group',$count_group+2)
                                        ->get();

                                for($i=0;$i<($count_group+1)/2;$i=$i+2){
                                    $schedule = new Match;
                                    $schedule->id_game = $id;
                                    $schedule->home_team = ($matches[$i*2]->home_team).' / '.($matches[$i*2]->away_team);
                                    $schedule->away_team = ($matches[$i*2+2]->home_team).' / '.($matches[$i*2+2]->away_team);
                                    $schedule->group = $count_group+3;
                                    $schedule->save();

                                    $schedule = new Match;
                                    $schedule->id_game = $id;
                                    $schedule->home_team =  ($matches[$i*2+1]->home_team).' / '.($matches[$i*2+1]->away_team);;
                                    $schedule->away_team = ($matches[$i*2+3]->home_team).' / '.($matches[$i*2+3]->away_team);;
                                    $schedule->group = $count_group+3;
                                    $schedule->save();
                                }
                            }
                            // 1/2
                            if($count_group>=4){
                                $matches = Match::where('id_game',$id)
                                        ->where('group',$count_group+3)
                                        ->get();

                                for($i=0;$i<($count_group+1)/4;$i=$i+2){
                                    $schedule = new Match;
                                    $schedule->id_game = $id;
                                    $schedule->home_team = '('.($matches[$i*2]->home_team).' / '.($matches[$i*2]->away_team);
                                    $schedule->away_team = '('.($matches[$i*2+2]->home_team).' / '.($matches[$i*2+2]->away_team);
                                    $schedule->group = $count_group+4;
                                    $schedule->save();

                                    $schedule = new Match;
                                    $schedule->id_game = $id;
                                    $schedule->home_team = '('.($matches[$i*2+1]->home_team).' / '.($matches[$i*2+1]->away_team);;
                                    $schedule->away_team = '('.($matches[$i*2+3]->home_team).' / '.($matches[$i*2+3]->away_team);;
                                    $schedule->group = $count_group+4;
                                    $schedule->save();
                                }
                            }
                            // final
                            if($count_group>=4){
                                $matches = Match::where('id_game',$id)
                                        ->where('group',$count_group+4)
                                        ->get();

                                $schedule = new Match;
                                $schedule->id_game = $id;
                                $schedule->home_team = $matches[0]->home_team.' / '.$matches[0]->away_team;
                                $schedule->away_team = $matches[1]->home_team.' / '.$matches[1]->away_team;
                                $schedule->group = $count_group+5;
                                $schedule->save();  
                            }
                            else if($count_group>=2){
                                $matches = Match::where('id_game',$id)
                                        ->where('group',$count_group+3)
                                        ->get();

                                $schedule = new Match;
                                $schedule->id_game = $id;
                                $schedule->home_team = $matches[0]->home_team.' / '.$matches[0]->away_team;
                                $schedule->away_team = $matches[1]->home_team.' / '.$matches[1]->away_team;
                                $schedule->group = $count_group+4;
                                $schedule->save();  
                            }
                            
                            else{
                                $matches = Match::where('id_game',$id)
                                        ->where('group',$count_group+2)
                                        ->get();

                                $schedule = new Match;
                                $schedule->id_game = $id;
                                $schedule->home_team = $matches[0]->home_team.' / '.$matches[0]->away_team;
                                $schedule->away_team = $matches[1]->home_team.' / '.$matches[1]->away_team;
                                $schedule->group = $count_group+3;
                                $schedule->save();  
                            }
                            


            return redirect()->route('pages.show',$id);
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
        DB::table('statistics')->where('id_team',$id)->delete();
        DB::table('teams')->where('id',$id)->delete();
        //dd($team);
        //$team->delete();
        return redirect()->route('add_team.index');
    }
}
