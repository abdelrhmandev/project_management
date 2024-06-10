<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Calendar;
use App\Models\Project;

class CalendarController extends Controller
{
        /**
     * Create a new controller instance.
     *
     * @return void
     */
    private static $area;

    public function __construct() {
        $this->middleware('auth');
        self::$area ="";
    }

    public function index(Request $request)
    {
        if($request->ajax()) {
            $data = Calendar::get();
            return response()->json($data);
        }
        return view('pages.calendars.index');
    }

    public function _getProjectData(Request $request) {

         $project = Project::where('id',$request['pID'])
         ->with('type')
         ->firstOrFail();

         $regions = Project::find($request['pID'])->region()->get();
         foreach($regions as $region):
            self::$area .= $region->title . "&nbsp;&nbsp;";
         endforeach;

         return response()->json(["project" => $project,"regions" => self::$area]);
    }
 
    public function calendarEvents(Request $request)
    {
        switch ($request->type) {
           case 'create':
              $event = Calendar::create([
                  'event_name' => $request->event_name,
                  'event_start' => $request->event_start,
                  'event_end' => $request->event_end,
              ]);
 
              return response()->json($event);
             break;
  
           case 'edit':
              $event = Calendar::find($request->id)->update([
                  'event_name' => $request->event_name,
                  'event_start' => $request->event_start,
                  'event_end' => $request->event_end,
              ]);
 
              return response()->json($event);
             break;
  
           case 'delete':
              $event = Calendar::find($request->id)->delete();
  
              return response()->json($event);
             break;
             
           default:
             # ...
             break;
        }
    }
}
