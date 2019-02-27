<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Game;
use App\Team;
use App\Statistic;
use DB;
use dd;

class TerminarzController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $g = Team::all();
        return view('pages.terminarz', compact('g'));
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
    public function show($id)
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

        return view('pages.game', compact('game','teams'));
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
        $team = Team::where('id_game',$id)->first();
        $stat = Statistic::where('id_team',$team->id)->first();
        $stat->points=$stat->points+$request->input('w1');
        $stat->save();
        return redirect()->route('game.show',$id);
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
