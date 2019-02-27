<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Game;
use App\Druzyny;
use Illuminate\Support\Facades\Schema;
use DB;

class NewGameController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.new_game');
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
        $obj = new Game;
        $obj->name = $request->input('name');
        $obj->typ = $request->input('typ');
        $obj->save();

      /* Schema::create($request->input('name'), function($table){
            $table->increments('id');
            $table->integer('id_rozgrywki')->unsigned();
            $table->string('nazwa_druzyny');
            $table->timestamps();

            $table->foreign('id_rozgrywki')->references('id')->on('rozgrywki');
        });

        $id = rozgrywki::Pluck('id');
        $c = count($id);
        $i = 0;
        foreach($id as $item)
        {
             $i++;
            if($i == $c){$results = $item;}
        }

        $dru = new Druzyny($request->input('name'));
        $dru->id_rozgrywki = $results;
        $dru->nazwa_druzyny = $request->input('nazwa_druzyny');
        $dru->save();*/
        
        $add = new AddTeamController();
        return $add->index();  
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
        //
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
