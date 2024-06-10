<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\ProjectObstacle;
use App\Models\ObstacleMesages;

class HomeController extends Controller
{
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->middleware('auth');
  }

  /**
   * Show the application dashboard.
   *
   * @return \Illuminate\Contracts\Support\Renderable
   */
  public function index()
  {
    return view('home');
  }

  public function notify()
  {
  }

  public function calendar()
  {
    return view('apps.calendar');
  }

  public function _obstaclesProjects()
  {
    $row = Project::selectRaw("projects.id AS ID,status_id,logo,projects.title,start_date,end_date,progress_bar,cases_count,building_count")->join("project_obstacles", "project_obstacles.project_id", "=", "projects.id")
      ->where('project_obstacles.is_close', '0')->where(function ($query) {
        $query->where('sender_id', Auth::user()->id)->orWhere('user_id', Auth::user()->id)->orwhere('user_id', null);
      })->groupBy("project_obstacles.project_id")->orderBy("project_obstacles.created_at", "DESC");

    $compact = [
      'rows' => $row->paginate(12),
      'counter' => $row->count(),
      'taskType' => 'none',
      'list' => 'قائمه بلاغات المشاريع',
      'placeholder' => 'إسم المشروع',
      'title' => 'بلاغات المشاريع',
    ];

    return view('pages.obstacles._obstaclesprojects', $compact);
  }

  public function _obstaclesProjectInfo($ID)
  {
    $q = Project::with('status', 'type', 'region', 'customer', 'localDevelopment')->find($ID);
    $oList = User::select('project_obstacles.id as id', 'name', DB::raw('DATE(project_obstacles.created_at) AS date'), 'project_obstacles.sender_id AS sender')
      ->join("project_obstacles", "project_obstacles.sender_id", "=", "users.id")->groupBy("project_obstacles.id")
      ->where("project_obstacles.project_id", $ID)->where("project_obstacles.is_close", '0')->where(function ($query) {
        $query->where('project_obstacles.user_id', Auth::user()->id)->orwhere('sender_id', Auth::user()->id)->orwhere('project_obstacles.user_id', null);
      })->orderBy("project_obstacles.created_at", "DESC")->get();

    return view('pages.obstacles._obstacle', ['row' => $q, 'olist' => $oList]);
  }

  public function _getObstaclesMsg(Request $req)
  {
    $output = "";
    $start = 0;
    $mainQuery = ProjectObstacle::select('project_obstacles.id as id', 'project_obstacles.message as mainMessage', 'project_obstacles.user_id', 'project_obstacles.sender_id', DB::raw('HOUR(TIMEDIFF(NOW(),project_obstacles.created_at)) AS H,MINUTE(TIMEDIFF(NOW(),project_obstacles.created_at)) AS M'))
      ->where("project_obstacles.sender_id", $req['sender'])->where("project_obstacles.project_id", $req['project'])->where("project_obstacles.id", $req['id'])->first();

    $q = ProjectObstacle::select('project_obstacles.id', 'obsMessage.message as message', 'obsMessage.user_id', 'obsMessage.sender_id', DB::raw('HOUR(TIMEDIFF(NOW(),project_obstacles.created_at)) AS H,MINUTE(TIMEDIFF(NOW(),project_obstacles.created_at)) AS M'))
      ->leftJoin('obstacle_messages as obsMessage', 'project_obstacles.id', 'obsMessage.obstacle_id')
      ->where("project_obstacles.sender_id", $req['sender'])->where("project_obstacles.id", $mainQuery['id'])->where("project_obstacles.project_id", $req['project'])->whereNotNull("obsMessage.message")->get();

    $mainName = User::find($mainQuery->sender_id)->name;
    $mainRole = User::find($mainQuery->sender_id)->Roles()->first()->ar_name;
    $mainImg = url("/storage/" . User::find($mainQuery->sender_id)->avatar);
    if (count($q) > 0) {
      foreach ($q as $v) :
        if ($v->H === 0 && $v->M === 0) {
          $ago = "منذ الآن";
        } else if ($v->H === 0 && $v->M !== 0) {
          $ago = " منذ " . $v->M . " دقيقه ";
        } else if ($v->H !== 0 && $v->H < 24) {
          $ago = " منذ " . $v->H . " ساعه ";
        } else if ($v->H !== 0 && $v->H >= 24) {
          $ago = " منذ " . intval($v->H / 24) . " يوم ";
        }

        if ($start == 0) :
          $name = User::find($v->sender_id)->name;
          $img = url("/storage/" . User::find($v->sender_id)->avatar);
          $role = User::find($v->sender_id)->Roles()->first()->ar_name;
        else :
          $name = User::find($v->sender_id)->name;
          $img = url("/storage/" . User::find($v->sender_id)->avatar);
          $role = User::find($v->sender_id)->Roles()->first()->ar_name;
        endif;

        if ($start == 0) {
          $output .= "
                <article class='oMsg'>
                  <div class='first'>
                    <img src='$mainImg' alt='{$mainName}'>
                  </div>
                  <div class='second'>
                      {$mainName}
                      <p>{$mainRole}</p>
                  </div>
                  <div class='msg'>{$mainQuery->mainMessage}</div>
                </article>

                <article class='oMsg'>
                  <div class='first'>
                    <img src='$img' alt='$name'>
                  </div>
                  <div class='second'>
                      {$name}
                      <span>{$ago}</span>
                      <p>{$role}</p>
                  </div>
                  <div class='msg'>{$v->message}</div>
                </article>";
        } else {
          $output .= "<article class='oMsg'>
                        <div class='first'>
                          <img src='$img' alt='$name'>
                        </div>
                        <div class='second'>
                            {$name}
                            <span>{$ago}</span>
                            <p>{$role}</p>
                        </div>
                        <div class='msg'>{$v->message}</div>
                      </article>";
        }

        $start++;
      endforeach;
    } else {
      $output .= "<article class='oMsg'>
                    <div class='first'>
                      <img src='$mainImg' alt='{$mainQuery->name}'>
                    </div>
                    <div class='second'>
                        {$mainQuery->name}
                        <p>{$mainRole}</p>
                    </div>
                    <div class='msg'>{$mainQuery->mainMessage}</div>
                  </article>";
    }

    echo $output;
  }

  public function _sendObstaclesMsg(Request $req)
  {
    ObstacleMesages::insertGetId([
      "obstacle_id" => $req['chatId'],
      "sender_id" => Auth::user()->id,
      "user_id" => $req['chatTo'],
      "message" => strip_tags(trim($req['chatMsg'])),
      "created_at" => DB::raw('NOW()')
    ]);
  }

  public function closeObsticale(Request $request)
  {
    ProjectObstacle::where('project_id', $request['project'])->where('sender_id', $request['sender'])->where('id', $request['id'])->update(['is_close' => '1']);
  }
}