<?php

namespace App\Http\Controllers;

use App\Models\Area;
use Illuminate\Http\Request;

class AreaController extends Controller
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
            return Area::all();
       }
       else{
           return view('areas\areas');
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
                return Area::where('id','LIKE',"%{$request->search}%")->
                orWhere('name','LIKE',"%{$request->search}%")->get();
            }
            catch(\Exception $exception){
                return Area::all();
            }
        }
         else
            try{
                $area=new Area();
                $area->name=$request->name;
                $area->save();
                return 1;
            }
            catch(\Exception $exception){
                return 0;
            }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Area  $area
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        //
        $area=Area::findOrFail($id);
        return $area;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Area  $area
     * @return \Illuminate\Http\Response
     */
    public function edit(Area $area)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Area  $area
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,int $id)
    {
        //
        $area=Area::find($id);
        $area->name=$request->name;
        $area->save();
        return $area;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Area  $area
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        //
        if(request()->isMethod("DELETE")){
            try{
                $area=Area::findOrFail($id);
                $area->delete();
                return 1;
            }
            catch(\Exception $exception)
            {
                return 0;
            }
        }
        return 1;
    }
}
