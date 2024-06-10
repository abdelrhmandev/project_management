<?php

namespace App\Http\Controllers\Backoffice;

use App\Http\Controllers\Controller;
use App\Traits\UploadAble;
use App\Models\Project;
use App\Models\User;
use App\Models\ProjectTrainingType;
use App\Models\ProjectInspectionVisit;
use App\Models\ProjectEmpowerCharity;
use App\Models\ProjectLocalDevelopment;
use App\Models\TeamRankType;
use Illuminate\Support\Facades\DB;
use App\Models\ProjectFinancialEstimate;
use App\Models\ProjectKashefAccounts;
use App\Models\ProjectSurveyAccounts;
use App\Models\ProjectTransactionHistory;
use App\Models\ProjectFieldworkTeam;
use App\Models\ProjectObserverTeam;
use App\Models\ProjectAuditorTeam;
use App\Models\ProjectFamilyDevelopment;
use App\Models\ProjectEquipments as PEQ;
use App\Models\Equipment;
use App\Models\ProjectRequirements;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ProjectTransaction;
use Carbon\Carbon;
use App\Mail\ProjectObstacles;
use App\Models\ProjectObstacle;
use App\Models\ProjectOutcome;
use App\Models\ProjectRedFlag;
use Illuminate\Support\Facades\Auth;

class FollowupController extends Controller
{
    protected $model;
    protected $resource;
    protected $trans_file;
    protected $blade_path;
    protected $COMMON_HELPER;
    use UploadAble;

    public function __construct(Project $model)
    {
        $this->model = $model;
        $this->resource = 'projects';
        $this->blade_path = 'backoffice';
        $this->trans_file = 'project';
        $this->COMMON_HELPER = app('App\Helpers\Common');
    }

    public function _OutcomeUploadFile(Request $request)
    {
        $target = storage_path() . '/app/public/uploads/projects/requirment';
        $source = $request['file']->getClientOriginalName();
        $request['file']->move($target, $source);
        $ext = $request['file']->getClientOriginalExtension();
        $out = storage_path() . '/app/public/uploads/projects/requirment/' . uniqid(date('t-M')) . "." . $ext;
        rename(storage_path() . "/app/public/uploads/projects/requirment/" . $source, $out);
        ProjectOutcome::where('id', $request['outcome_id'])
            ->where('project_id', $request['project_id'])
            ->update([
                'file' => stristr($out, "/uploads/"),
                'user_edit' => Auth::user()->id,
                'is_accepted' => NULL,
                'updated_at' => DB::raw('NOW()')
            ]);

        return back()->with('success', trans('تم رفع ملف المخرجات بنجاح'));
    }

    public function _OutClientRejectionNote(Request $request)
    {
        ProjectOutcome::where('id', $request['outcome_id'])
            ->where('project_id', $request['project_id'])
            ->update([
                'client_rejection_note' => $request['client_rejection_note'],
                'is_accepted' => '0',
                'user_edit' => Auth::user()->id,
                'updated_at' => DB::raw('NOW()')
            ]);
        return back()->with('success', trans('تم أرسال سبب رفض المخرج بنجاح'));
    }

    public function followup($id)
    {
        $query = $this->model::with('status', 'type', 'region', 'customer', 'localDevelopment')->find($id);
        $this->blade_path = 'backoffice.followup.index';
        if (Auth::user()->hasRole('admin')) {
            $QRF = ProjectRedFlag::has('replies')->where('project_id', $id)->with(['replies', 'attachments']); // for admin Account                  
        } else {
            $QRF = ProjectRedFlag::where(['project_id' => $id])->whereIn('status', ['new', 'inprogress'])->with(['replies', 'attachments', 'getReplyAttachments']); // Project Manager Account
        }
        $outcome = ProjectOutcome::where(['project_id' => $id]);
        $compact = [
            'trans_file' => $this->trans_file,
            'resource' => $this->resource,
            'row' => $query,
            'maps' => DB::table('project_maps')->where("project_id",$id)->get(),
            'team_ranks' => TeamRankType::get(),
            'project_admin' => User::where('id', 2)->first(),
            'users' => ProjectTransactionHistory::with('user')->where('project_id', $id)->groupBy('user_id')->get(),
            'project_fieldwork_teams' => ProjectFieldworkTeam::where("project_id", $id)->with('user', 'type')->paginate(12),
            'transactions_history' => ProjectTransactionHistory::where('project_id', $id)->with('status', 'user')->orderBy('updated_at', 'DESC')->get(),
            'kashef_accounts' => ProjectKashefAccounts::where("project_id", $id)->first(),
            'survey_accounts' => ProjectSurveyAccounts::where("project_id", $id)->first(),
            'financial_bid_estimate' => ProjectFinancialEstimate::where('project_id', $id)->first(),
            'project_family_development' => ProjectFamilyDevelopment::where('project_id', $id)->first(),
            'project_local_development' => ProjectLocalDevelopment::where('project_id', $id)->first(),
            'project_inspection_visit' => ProjectInspectionVisit::where('project_id', $id)->first(),
            'project_empower_charity' => ProjectEmpowerCharity::where('project_id', $id)->first(),
            'training' => ProjectTrainingType::where('project_id', $id)->first(),
            'team_rank_items' => DB::table('project_team_rank_item')->select('type_id', DB::raw('COUNT(type_id) as qty'))->where('project_id', $id)->groupBy('type_id')->get(),
            'project_equipments' => DB::table('project_equipments as pe')->leftJoin('equipments as e', 'e.id', '=', 'pe.equipment_id')->select('pe.id AS peID', 'pe.qty', 'pe.price', 'e.type_id', 'e.title', 'pe.send_equipment_receipt', 'pe.equipment_id')->where('project_id', $id)->get(),
            'equipments' => Equipment::get(),
            'selected_equipments' => PEQ::where("project_id", $id)->get(),
            'remaining_equipments' => DB::table('equipments as e')->whereNotIn('e.id', [DB::raw('(SELECT equipment_id FROM project_equipments as pe WHERE pe.project_id = ' . $id . ')')])->get(),
            'clientFiles' => DB::table('project_client_attachments')->select('id', 'file', 'user_add', 'user_edit', 'created_at', 'updated_at')->where('project_id', $id)->get(),
            'requirements' => ProjectRequirements::select('id', 'title', 'file', DB::raw('DATE(created_at) AS date'))->where('project_id', $id)->get(),
            'id' => $id ?? 0,
            'type' => $type ?? 'user',
            'messengerColor' => Auth::user()->messenger_color ?? $this->messengerFallbackColor,
            'dark_mode' => Auth::user()->dark_mode < 1 ? 'light' : 'dark',
            'clientFiles' => DB::table('project_client_attachments')->select('id', 'file', 'user_add', 'user_edit', 'created_at', 'updated_at')->where('project_id', $id)->get(),
            'RedFlags' => $QRF->get(),
            'RedFlagsCount' => $QRF->count(),
            'outcomes' => $outcome->get(),
            'outcomeCount' => $outcome->count(),
            'outcomeAcceptedCount' => ProjectOutcome::where(['project_id' => $id])->where('is_template_approved', '1')->count()
        ];

        return view($this->blade_path, $compact);
    }

    public function _changeProjectFiles(Request $request)
    {
        $modelType = $request['type'];
        $col = ($modelType == 'projects') ? 'id' : 'project_id';
        if ($request->has('fileID')) {
            $oldData = DB::table($modelType)->select($request['filetype'] . ' AS old')
                ->where('id', $request['fileID'])
                ->where($col, $request['project_id'])->first();
        } else {
            $oldData = DB::table($modelType)->select($request['filetype'] . ' AS old')->where($col, $request['project_id'])->first();
        }
        if (is_file(storage_path() . '/app/public/' . $oldData->old)) {
            unlink(storage_path() . '/app/public/' . $oldData->old);
        }

        $ext = $request['file']->getClientOriginalExtension();
        if ($request['filetype'] == "file") :
            $target = storage_path() . '/app/public/uploads/projects/client';
            $out = storage_path() . '/app/public/uploads/projects/client/' . uniqid(date('t-M')) . "." . $ext;
            $file = stristr($out, "/uploads/");
            $origin = storage_path() . '/app/public/uploads/projects/client/';
            elseif ($request['filetype'] == "google_map") :
            $target = storage_path().'/app/public/uploads/projects/maps';
            $out = storage_path()."/app/public/uploads/projects/maps/".uniqid("map-").".".$ext;
            $file = stristr($out, "uploads/");
            $origin = storage_path() . '/app/public/uploads/projects/maps/';
        else :
            $target = storage_path() . '/app/public/uploads/projects';
            $out = storage_path() . '/app/public/uploads/projects/' . uniqid(date('t-M')) . "." . $ext;
            $file = stristr($out, "uploads/");
            $origin = storage_path() . '/app/public/uploads/projects/';
        endif;

        $source = $request['file']->getClientOriginalName();
        $request['file']->move($target, $source);
        rename($origin . $source, $out);
        DB::beginTransaction();
        try {
            if ($request->has('fileID')) {
                DB::table($modelType)->where($col, $request['project_id'])
                    ->where('id', $request['fileID'])
                    ->update([$request['filetype'] => $file,
                        'user_edit' => Auth::user()->id,
                        'updated_at' => DB::raw('NOW()')]);
            } else {
                DB::table($modelType)->where($col, $request['project_id'])
                    ->update([$request['filetype'] => $file,
                        'user_edit' => Auth::user()->id,
                        'updated_at' => DB::raw('NOW()')]);
            }
            DB::commit();
            return response()->json(["MSG" => "success"]);
        } catch (\PDOEXception $e) {
            DB::rollBack();
            return response()->json(["MSG" => $e->getMessage()]);
        }
    }

    static public function _changeOutcomeFile(Request $req)
    {
        if ($req->hasFile('OutFile')) {
            $target = storage_path() . '/app/public/uploads/projects';
            $source = $req['OutFile']->getClientOriginalName();
            $req['OutFile']->move($target, $source);
            $ext = $req['OutFile']->getClientOriginalExtension();
            $out = storage_path() . '/app/public/uploads/projects/' . uniqid(date('t-M')) . "." . $ext;
            rename(storage_path() . "/app/public/uploads/projects/" . $source, $out);

            ProjectOutcome::where('id', $req['outComeID'])
                ->where('project_id', $req['projectID'])
                ->update([
                    'file' => stristr($out, "uploads/"),
                    'client_rejection_note' => NULL,
                    'is_accepted' => NULL,
                    'updated_at' => DB::raw('NOW()')
                ]);
            return response()->json(["MSG" => "success", "code" => 200]);
        } else {
            return response()->json(["MSG" => "يجب اختيار الملف", "code" => 400]);
        }
    }

    public function _addReqFile(Request $req)
    {
        /*if ($req->hasFile('file')) {
            $target = storage_path() . '/app/public/uploads/projects/requirment';
            $source = $req['file']->getClientOriginalName();
            $req['file']->move($target, $source);
            $ext = $req['file']->getClientOriginalExtension();
            $out = storage_path() . '/app/public/uploads/projects/requirment/' . uniqid(date('t-M')) . "." . $ext;
            rename(storage_path() . "/app/public/uploads/projects/requirment/" . $source, $out);
             */
        ProjectRequirements::where('id', $req['req_id'])
            ->where('project_id', $req['project_id'])
            ->update([
                'file' => NULL, //stristr($out, "/uploads/"),
                'project_user_id' => Auth::user()->id,
                'notes' => strip_tags($req['notes']) ?? NULL,
                'updated_at' => DB::raw('NOW()')
            ]);

        /* } else {
             echo 'please select file';
         }*/
    }

    public function _changeProjectDetails(Request $request)
    {
        DB::beginTransaction();
        try {
            if ($request->has('building') && $request->filled('building')) {
                $buildCount = (int) $request['building'];
            } else {
                $buildCount = Project::where('id', $request['projectID'])->first()->building_count;
            }
            if ($request->has('cases') && $request->filled('cases')) {
                $casesCount = (int) $request['cases'];
            } else {
                $casesCount = Project::where('id', $request['projectID'])->first()->cases_count;
            }

            if ($request->has('opening')) {
                $reserveHall = $request['opening_reserve_hall'] ?? '0';
                if ($request->filled('opening_date')) {
                    $openDate = date('Y-m-d', strtotime($request['opening_date']));
                } else {
                    $openDate = NULL;
                }
            } else {
                $reserveHall = '0';
                $openDate = NULL;
            }

            if ($request->has('closing')) {
                $closeReserveHall = $request['closing_reserve_hall'] ?? '0';
                if ($request->filled('closing_date')) {
                    $closeDate = date('Y-m-d', strtotime($request['closing_date']));
                } else {
                    $closeDate = NULL;
                }
            } else {
                $closeReserveHall = '0';
                $closeDate = NULL;
            }

            Project::where('id', $request['projectID'])
                ->update([
                    'cases_count' => $casesCount,
                    'building_count' => $buildCount,
                    'opening' => $request['opening'],
                    'opening_reserve_hall' => $reserveHall,
                    'opening_attendance_nature' => $request['opening_attendance_nature'],
                    'opening_date' => $openDate,
                    'closing' => $request['closing'],
                    'closing_reserve_hall' => $closeReserveHall,
                    'closing_attendance_nature' => $request['closing_attendance_nature'],
                    'closing_date' => $closeDate
                ]);

            if ($request->has('projectType') && $request['projectType'] == 14) {
                ProjectTrainingType::where('project_id', $request['projectID'])
                    ->update([
                        'id' => $request['trainers'],
                        'training_type' => $request['traintype'],
                        'training_date' => $request['traindate'],
                        'is_hall_required' => $request['openinghall'] ?? '0',
                        'training_on' => $request['trainon'],
                        'participant_type' => $request['participant'],
                        'duration' => $request['duration']
                    ]);
            }

            if ($request->has('projectType') && $request['projectType'] == 9) {
                ProjectEmpowerCharity::where('project_id', $request['projectID'])
                    ->update([
                        'charity_count' => (int) $request['charity'] ?? '0'
                    ]);
            }

            if ($request->has('projectType') && $request['projectType'] == 10) {
                ProjectInspectionVisit::where('project_id', $request['projectID'])
                    ->update([
                        'mine_title' => $request['mine']
                    ]);
            }

            DB::commit();
            return response()->json(["MSG" => "success"]);
        } catch (\PDOEXception $e) {
            DB::rollBack();
            return response()->json(["MSG" => $e->getMessage()]);
        }
    }

    public function _changeProjectForm(Request $request)
    {
        DB::beginTransaction();
        try {
            if ($request->has('accountType') && $request['accountType'] == 'kashef') {
                $arr = [
                    'url' => $request['URL'],
                    'admin_email' => $request['admin_email'],
                    'admin_password' => $request['admin_password'],
                    'report_email' => $request['report_email'],
                    'report_password' => $request['report_password'],
                    'studies_email' => $request['studies_email'],
                    'studies_password' => $request['studies_password']
                ];

                if (ProjectKashefAccounts::where('project_id', $request['projectID'])->count()) {
                    ProjectKashefAccounts::where('project_id', $request['projectID'])->update($arr);
                } else {
                    $arr = [
                        'project_id' => $request['projectID'],
                        'url' => $request['URL'],
                        'admin_email' => $request['admin_email'],
                        'admin_password' => $request['admin_password'],
                        'report_email' => $request['report_email'],
                        'report_password' => $request['report_password'],
                        'studies_email' => $request['studies_email'],
                        'studies_password' => $request['studies_password']
                    ];
                    ProjectKashefAccounts::insert($arr);
                }
            }

            if ($request->has('accountType') && $request['accountType'] == 'survey') {
                $arr = [
                    'project_id' => $request['projectID'],
                    'url' => $request['URL'],
                    'admin_email' => $request['admin_email'],
                    'admin_password' => $request['admin_password']
                ];

                if (ProjectSurveyAccounts::where('project_id', $request['projectID'])->count()) {
                    ProjectSurveyAccounts::where('project_id', $request['projectID'])->update($arr);
                } else {
                    $arr = [
                        'project_id' => $request['projectID'],
                        'url' => $request['URL'],
                        'admin_email' => $request['admin_email'],
                        'admin_password' => $request['admin_password']
                    ];
                    ProjectSurveyAccounts::create($arr);
                }
            }

            DB::commit();
            return response()->json(["MSG" => "success"]);
        } catch (\PDOEXception $e) {
            DB::rollBack();
            return response()->json(["MSG" => $e->getMessage()]);
        }
    }

    public function _changeProjectEquipment(Request $request)
    {
        DB::beginTransaction();
        try {
            if (! empty($request['peID'])) :
                foreach ($request['peID'] as $k => $v) :
                    PEQ::where('project_id', $request['projectID'])
                        ->where('equipment_type', $request['eqType'])
                        ->where('id', $v)
                        ->update([
                            'qty' => (int) $request['qty'][$k],
                            'price' => $request['price'][$k],
                            'send_equipment_receipt' => $request['available'][$k] ?? '0',
                        ]);
                endforeach;
            endif;
            DB::commit();
            return response()->json(["MSG" => "success"]);
        } catch (\PDOEXception $e) {
            DB::rollBack();
            return response()->json(["MSG" => $e->getMessage()]);
        }
    }

    public function _changeProjectFinance(Request $request)
    {
        DB::beginTransaction();
        try {
            $teamRank = TeamRankType::select('title')->get();
            foreach ($teamRank as $team) :
                ProjectFinancialEstimate::where('project_id', $request['projectID'])
                    ->update([
                        $team->title . '_qty' => $request[$team->title . '_qty'] ?? '0',
                        $team->title . '_price' => $request[$team->title . '_price'] ?? '0'
                    ]);
            endforeach;
            DB::commit();
            return response()->json(["MSG" => "success"]);
        } catch (\PDOEXception $e) {
            DB::rollBack();
            return response()->json(["MSG" => $e->getMessage()]);
        }
    }

    static public function _delRejOutcome(Request $req)
    {
        DB::beginTransaction();
        try {
            ProjectOutcome::where('id', $req['ID'])->where('project_id', $req['P'])->delete();
            DB::commit();
        } catch (\PDOException $e) {
            DB::rollBack();
            return response()->json(["MSG" => $e->getMessage()]);
        }
    }

    static public function _editRejOutcome(Request $req)
    {
        $target = storage_path() . '/app/public/uploads/projects';
        $source = $req['Outtemp']->getClientOriginalName();
        $req['Outtemp']->move($target, $source);
        $ext = $req['Outtemp']->getClientOriginalExtension();
        $out = storage_path() . '/app/public/uploads/projects/' . \Str::random(25) . "." . $ext;
        rename(storage_path() . '/app/public/uploads/projects/' . $source, $out);
        $file = stristr($out, "uploads/");

        DB::beginTransaction();
        try {
            ProjectOutcome::where('id', $req['outcome'])
                ->update([
                    'description' => $req['outdesc'],
                    'template' => $file,
                    'is_template_approved' => NULL,
                    'template_reject_reason' => NULL,
                    'user_edit' => Auth::user()->id,
                    'updated_at' => DB::raw('NOW()')
                ]);
            DB::commit();
            return back();
        } catch (\PDOException $e) {
            DB::rollBack();
            return response()->json(["MSG" => $e->getMessage()]);
        }
    }

    public static function _sentEmailReminder()
    {
        $transHistory = ProjectTransactionHistory::select('user_id', 'project_id', 'status_id', 'created_at AS time')->where('is_done', '0')->get();
        foreach ($transHistory as $history) :
            $timeSent = strtotime($history->time);
            $currentTime = strtotime(date('Y-m-d H:i:s'));
            $elapsedTime = ceil(($currentTime - $timeSent) / 60);

            $exist = DB::table('project_views')->where('user_id', $history->user_id)
                ->where('project_id', $history->project_id)
                ->where('status_id', $history->status_id)
                ->where('is_seen', '0')->first();
            $hoursPassed = $exist->hours_passed ?? NULL;
            $user = User::findOrFail($history->user_id);
            $projectTitle = DB::table('projects')->where('id', $history->project_id)->first()->title;
            $userEmail = $user->email;
            $userName = $user->name;
            $mailData = [
                'project_title' => $projectTitle,
                'route' => url('/' . $userName . 's/' . $history->project_id . '/edit/' . $history->status_id),
                'reminder' => "yes"
            ];

            if ($elapsedTime >= 60 && is_null($hoursPassed)) :
                $mailSent = Mail::to($userEmail)->send(new ProjectTransaction($mailData));
                if ($mailSent) :
                    //  ProjectViews::updateOrCreate(['user_id' => $history->user_id, 'project_id' => $history->project_id, 'status_id' => $history->status_id], ["hours_passed" => '1', 'updated_at' => Carbon::now()->toDateTimeString()]);
                    DB::table('project_views')->where('user_id', $history->user_id)->where('project_id', $history->project_id)->where('status_id', $history->status_id)->update(["hours_passed" => '1', 'updated_at' => Carbon::now()->toDateTimeString()]);
                endif;
            elseif ($elapsedTime >= 1440 && $hoursPassed == "1") :
                $mailSent = Mail::to($userEmail)->send(new ProjectTransaction($mailData));
                if ($mailSent) :
                    DB::table('project_views')->where('user_id', $history->user_id)->where('project_id', $history->project_id)->where('status_id', $history->status_id)->update(["hours_passed" => '24', 'updated_at' => Carbon::now()->toDateTimeString()]);
                endif;
            endif;
            die;
        endforeach;
    }

    public function fieldTeamDetails($projectId, $userId)
    {
        $fieldwork_team = ProjectFieldworkTeam::where("project_id", $projectId)->where("user_id", $userId)->with('user', 'type')->first();
        if ($fieldwork_team['type_id'] == 1) {
            $compact = [
                'user_id' => $userId,
                'trans_file' => $this->trans_file,
                'team_details' => ProjectObserverTeam::where("project_observer_team.project_id", $projectId)->leftJoin('project_contracts as con', 'project_observer_team.project_id', '=', DB::raw('con.project_id and project_observer_team.team_user_id = con.team_user_id'))
                    ->leftJoin('attracting_team as attract', 'attract.id', '=', 'project_observer_team.team_user_id')
                    ->where('approved_member', '1')->with('type', 'superior', 'teamSuperior', 'children')
                    ->where(DB::raw('(project_observer_team.superior_id'), DB::raw($userId . ' OR project_observer_team.superior_team_id IN(select team_user_id from project_observer_team where superior_id = ' . $userId . ' and project_id = ' . $projectId . '))'))->get(),
                'project_fieldwork_team' => $fieldwork_team,
            ];

            return view('backoffice.followup.observerTeamDetails', $compact);
        } elseif ($fieldwork_team['type_id'] == 2) {
            $compact = [
                'user_id' => $userId,
                'trans_file' => $this->trans_file,
                'team_details' => ProjectAuditorTeam::where("project_auditor_team.project_id", $projectId)->leftJoin('project_contracts as con', 'project_auditor_team.project_id', '=', DB::raw('con.project_id and project_auditor_team.team_user_id = con.team_user_id'))
                    ->leftJoin('attracting_team as attract', 'attract.id', '=', 'project_auditor_team.team_user_id')
                    ->where('approved_member', '1')->with('user', 'type', 'superior')
                    ->where('project_auditor_team.superior_id', DB::raw($userId))->get(),
                'project_fieldwork_team' => $fieldwork_team,
            ];

            return view('backoffice.followup.auditorTeamDetails', $compact);
        }
    }

    public function SaveCreatedKashef(Request $request)
    {
        if ($request->action == 'create') {
            $action = '1';
            $status = 'success';
            $msg = 'تم تحديد الحساب ';
        }
        if ($request->action == 'remove') {
            $action = '0';
            $status = 'success';
            $msg = 'تم تحديد حذف ';
        }

        DB::table('project_' . $request->table . '_team')->where('team_user_id', $request['id'])->update([
            'created_kashef' => $action,
        ]);

        return response()->json([
            'status' => $status,
            'msg' => $msg
        ]);
    }

    public function saveObstacle(Request $request)
    {
        if ($request['type_id'] == 1) {
            $type = 'مشكلة';
            $icon = 'danger';
        } else if ($request['type_id'] == 2) {
            $type = 'مقترح';
            $icon = 'success';
        } else if ($request['type_id'] == 3) {
            $type = 'إستفسار';
            $icon = 'warning';
        }

        $insertion = [
            'sender_id' => Auth::user()->id,
            'user_id' => $request['user_id'] == 'all' ? null : $request["user_id"],
            'title' => $request["title"],
            'message' => $request["message"],
            'project_id' => $request["project_id"],
            'type_id' => $type,
            'icon' => $icon,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        if (ProjectObstacle::Create($insertion) && $request['user_id'] != 'all') {
            $mailData = [
                'project_title' => Project::find($request['project_id'])->title,
                'message' => $request['message'],
                'type' => $type,
            ];

            $email = User::where('id', $request['user_id'])->first()->email;
            Mail::to($email)->send(new ProjectObstacles($mailData));
        }

        return back()->with('success', trans('site.obsticales_completed'));
    }
}