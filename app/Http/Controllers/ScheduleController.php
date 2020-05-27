<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\Instructor;
use App\Models\Course;
use Illuminate\Http\Request;

class ScheduleController extends Controller
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
            $schedules = Schedule::with('course','instructor')->get();

            return $data = [
                'schedules' => $schedules
            ];
        }else{
            return view('schedules/index');
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
            $instructors=Instructor::orderBy('name')->get();
            $schedules=Schedule::all();
            $data = [
                'courses'=>$courses,
                'instructors'=>$instructors,
                'schedules'=>$schedules
            ];
            return $data;
        }
        $schedule = new Schedule();
        $schedule->id = 0;
        $schedule->id_course = -1;
        $schedule->id_instructor = -1;
        $schedule->m = '';
        $schedule->t = '';
        $schedule->w = '';
        $schedule->r = '';
        $schedule->f = '';
        $schedule->s = '';
        $schedule->capacity = 0;
        $data = ['schedule'=>$schedule];
        return view('schedules/createEdit',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $schedule = new Schedule();
        $schedule->id_course = $request->id_course;
        $schedule->id_instructor = $request->id_instructor;
        $schedule->m = $request->m;
        $schedule->t = $request->t;
        $schedule->w = $request->w;
        $schedule->r= $request->r;
        $schedule->f = $request->f;
        $schedule->s = $request->s;
        $schedule->capacity = $request->capacity;
        $schedule->save();
        return $schedule;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $schedule = Schedule::with('course','instructor')->findorFail($id);
        $data = ['schedule'=>$schedule];
        return view('schedules/details',$data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $schedule = Schedule::findorFail($id);
        $data = ['schedule'=>$schedule];
        return view('schedules/createEdit',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $schedule = Schedule::findorFail($id);
        $schedule->id_course = $request->id_course;
        $schedule->id_instructor = $request->id_instructor;
        $schedule->m = $request->m;
        $schedule->t = $request->t;
        $schedule->w = $request->w;
        $schedule->r= $request->r;
        $schedule->f = $request->f;
        $schedule->s = $request->s;
        $schedule->capacity = $request->capacity;
        $schedule->save();
        return $schedule;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $schedule = Schedule::findorFail($id);
            $schedule->delete();
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
