<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\UsersCdu;
use App\Models\Condonation;
class UsersCduController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $alluser=UsersCdu::all();
        foreach( $alluser as $user){
        $user->payments;
        $user->condonations;
        $ax=$user->payments;
        $ax = collect($ax)->sortBy('updated_at')->reverse()->toArray();
        $last_pay_hour=null;
        foreach ($ax as $item) {
            $last_pay_hour= $item['updated_at'];
        break;
        }
        $now = new \DateTime();
        $date2=new \DateTime($last_pay_hour);
        if($last_pay_hour!=null && $now->diff($date2)->format('%a')<=30){
            $user->active='1';
        }else{
            $ax=$user->condonations;
            $ax = collect($ax)->sortBy('updated_at')->reverse()->toArray();
            $last_pay_hour=null;
            foreach ($ax as $item) {
                $last_pay_hour= $item['updated_at'];
            break;
            }
            $date2=new \DateTime($last_pay_hour);
            if($last_pay_hour!=null && $now->diff($date2)->format('%a')<=30){
                $user->active='1';
            }else{
                $user->active='0';
            }
        }
        $user->save();
    }
        if(\Request::ajax()){
             return UsersCdu::all();

        }
        else{
            return view('usercdu.users');
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
    public function update(Request $request, $id)
    {
        $usercdu=UsersCdu::find($id);
        $usercdu->code=$request->code;
        $usercdu->username=$request->username;
        $usercdu->email=$request->email;
        $usercdu->phone=$request->phone;
        $usercdu->save();
        return $request->all();
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->deleteImage!=NULL){
                $usercdu=UsersCdu::findOrFail($request->deleteImage);
                if($usercdu->pic!=null){
                    Storage::delete('public/'.$usercdu->pic);
                }
                $usercdu->pic=null;
                $usercdu->save();
                return 7;
        }
        if($request->editImage!=NULL){
            if($request->hasFile('imagen')){
                $usercdu=UsersCdu::findOrFail($request->editImage);
                Storage::delete('public/'.$usercdu->pic);
                $path=$request->imagen->store('public');
                $ur=(string)$request->imagen->hashName();;
                $usercdu->pic=$ur;
                $usercdu->save();
                return 7;
            }
            return 3;
        }
        if($request->search!=NULL){
            try{
                return UsersCdu::where('id','LIKE',"%{$request->search}%")->
                orWhere('username','LIKE',"%{$request->search}%")->get();
            }
            catch(\Exception $exception){
                return UsersCdu::all();
            }
        }
         else
            try{
                $userC=new UsersCdu();
                $userC->username=$request->username;
                $userC->code=$request->id;
                $userC->email=$request->email;
                $userC->phone=$request->phone;
                if($request->hasFile('imagen')){
                    $path=$request->imagen->store('public');
                    $ur=(string)$request->imagen->hashName();;
                    $userC->pic=$ur;
                }
                $userC->save();
                
                return 1;
            }
            catch(\Exception $exception)
            {
                return 0;
            }
        return 1;
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\UsersCdu  $usersCdu
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    { try{
        $user=UsersCdu::findOrFail($id);
        $user->payments;
        $user->condonations;
        return $user;
        }
        catch(\Exception $exception){
            return $exception;
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\UsersCdu  $usersCdu
     * @return \Illuminate\Http\Response
     */
    public function edit(UsersCdu $usersCdu)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\UsersCdu  $usersCdu
     * @return \Illuminate\Http\Response
     */

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\UsersCdu  $usersCdu
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id){
        if(request()->isMethod("DELETE")){
            try{
                $usercdu=UsersCdu::findOrFail($id);
                try{
                $usercdu->delete();
                }catch(\Exception $ex){
                    return 10;
                }
                if($usercdu->pic!=null){
                    try{
                    Storage::delete('public/'.$usercdu->pic);
                    }
                    catch(\Exception $exception){
                        return 2;
                    }
                }
                
                return 2;
            }
            catch(\Exception $exception)
            {
                return 10;
            }
        }
        return 2;
    }
}
