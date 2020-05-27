<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Level;
use App\Models\Discipline;
use Illuminate\Http\Request;

class CourseController extends Controller
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
            $courses = Course::with('discipline','level')->get();

            return $data = [
                'courses' => $courses
            ];
        }else{
            return view('courses/index');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if($request->ajax()){
            $courses=Course::orderBy('name')->get();
            $disciplines=Discipline::orderBy('name')->get();
            $levels=Level::all();
            $data = [
                'courses'=>$courses,
                'disciplines'=>$disciplines,
                'levels'=>$levels
            ];
            return $data;
        }
        $course = new Course();
        $course->id=0;
        $course->name = '';
        $course->id_discipline = 0;
        $course->id_level = 0;
        $course->date_start = null;
        $course->date_end = null;
        $course->cost = 0;
        $data = [
            'course'=>$course
        ];
        return view('courses/createEdit',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->date_start = strtotime($request->date_start);
        $request->date_end = strtotime($request->date_end);
        $course = new Course();
        $course->name = $request->name;
        $course->id_discipline = $request->id_discipline;
        $course->id_level = $request->id_level;
        $course->date_start = date('Y-m-d',$request->date_start);
        $course->date_end = date('Y-m-d',$request->date_end);
        $course->cost = $request->cost;
        $course->save();
        return $course;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models  $models
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $course = Course::with('discipline','level')->findorFail($id);
        $course->date_start = date_format($course->date_start,'Y-m-d');
        $data = ['course'=>$course];
        return view('courses/details',$data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models  $models
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $course = Course::findorFail($id);
        $data = ['course'=>$course];
        return view('courses/createEdit',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models  $models
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $request->date_start = strtotime($request->date_start);
        $request->date_end = strtotime($request->date_end);
        $course = Course::findorFail($id);
        $course->name = $request->name;
        $course->id_discipline = $request->id_discipline;
        $course->id_level = $request->id_level;
        $course->date_start = date('Y-m-d',$request->date_start);
        $course->date_end = date('Y-m-d',$request->date_end);
        $course->cost = $request->cost;
        $course->save();
        return $course;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models  $models
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $course = Course::findorFail($id);
            $course->delete();
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
