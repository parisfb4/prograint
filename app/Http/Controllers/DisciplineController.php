<?php

namespace App\Http\Controllers;

use App\Models\Discipline;
use Illuminate\Http\Request;

class DisciplineController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(){
        $this->middleware('auth');
    }

    public function index()
    {
        //
        if(\Request::ajax()){
            $dis=Discipline::with('area')->get();
            return $dis;
       }
       else{
           return view('discipline\discipline');
       }
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
        if($request->search!=NULL){
            try{
                return Discipline::with('area')->where('id','LIKE',"%{$request->search}%")->
                orWhere('name','LIKE',"%{$request->search}%")->get();
            }
            catch(\Exception $exception){
                return Discipline::with('area');
            }
        }
         else
            try{
                $Discipline=new Discipline();
                $Discipline->name=$request->name;
                $Discipline->id_area=$request->id_area;
                $Discipline->save();
                return 1;
            }
            catch(\Exception $exception){
                return 0;
            }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Discipline  $Discipline
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        //
        $dato= Discipline::with('area')->findOrFail($id);
        return $dato;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Discipline  $Discipline
     * @return \Illuminate\Http\Response
     */
    public function edit(Discipline $Discipline)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Discipline  $Discipline
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,int $id)
    {
        //
        $Discipline=Discipline::find($id);
        $Discipline->name=$request->name;
        $Discipline->id_area=$request->id_area;
        $Discipline->save();
        return 1;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Discipline  $Discipline
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        //
        if(request()->isMethod("DELETE")){
            try{
                $Discipline=Discipline::findOrFail($id);
                $Discipline->delete();
                return 1;
            }
            catch(\Exception $exception)
            {
                return 0;
            }
            return 1;
        }
        return 1;
        //
    }
}
