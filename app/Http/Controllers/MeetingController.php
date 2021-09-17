<?php

namespace App\Http\Controllers;

use Acaronlex\LaravelCalendar\Facades\Calendar;
use App\Models\Meeting;
use App\Models\User;
use Illuminate\Http\Request;

class MeetingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      
        $commercials = User::all();
       $meetings = Meeting::all();
       
        return view('welcome', [
            'commercials' => $commercials,
            'meetings' => $meetings
        ]);
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
        switch ($request->type) {
            case 'create':
               $calendarEvent = Meeting::create([
                   'client' => $request->event_title,
                   'start_at' => $request->event_start,
                   'end_at' => $request->event_end,
                   'user_id' => 1
               ]);
  
               return response()->json($calendarEvent);
              break;
   
            case 'edit':
               $calendarEvent = Meeting::find($request->id)->update([
                   'client' => $request->event_title,
                   'start_at' => $request->event_start,
                   'end_at' => $request->event_end,
                   'user_id' => 1
               ]);
  
               return response()->json($calendarEvent);
              break;
              
            default:
              break;
         }
    
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        $commercials = User::all();

        return view('show', compact('commercials', 'user'));
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
