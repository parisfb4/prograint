<?php

namespace App\Http\Controllers;

use App\Models\Level;
use App\Models\Discipline;
use Illuminate\Http\Request;

class LevelController extends Controller
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
    public function index(Request $request)
    {    
        if($request->ajax()){
            $levelsD = Level::all();
            $disciplinesD = Discipline::orderBy('name')->get();

            return $data = [
                'levelsD' => $levelsD,
                'disciplinesD' => $disciplinesD
            ];
            
        }else{
            return view('levels/index');
        }
    }

    /**
     * Show the form for creating a new resource.
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $level = new Level();
        $level->id = 0;
        $level->name = '';
        $level->id_discipline = 0;
        $data = ['level'=>$level];
        return view('levels/createEdit',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $level = new Level();
        $level->name = $request->name;
        $level->id_discipline = $request->id_discipline;
        $level->save();
        return $level;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\app\Models\Level  $level
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $level = Level::findorFail($id);
        $discipline = Discipline::find($level->id_discipline);
        $data=['level'=>$level,'discipline'=>$discipline];
        return view('levels/details',$data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\app\Models\Level  $level
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $level = Level::findorFail($id);
        $data = ['level'=>$level];
        return view('levels/createEdit',$data);
    }

    

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\app\Models\Level  $level
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $level = Level::findorFail($id);
        $level->name = $request->name;
        $level->id_discipline = $request->id_discipline;
        $level->save();
        return $level;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\app\Models\Level  $level
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $level = Level::findorFail($id);
            $level->delete();
            $information = 'good';
            $data = ['information'=>$information];
            return $data;
        }catch(\Illuminate\Database\QueryException $e){
            $information = 'bad';
            $data = ['information'=>$information];
            return $data;
        }
        
    }
}
