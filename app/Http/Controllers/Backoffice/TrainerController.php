<?php

namespace App\Http\Controllers\Backoffice;

use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\ProjectStatus;
use App\Models\ProjectType;
use App\Models\Region;
use App\Models\Customer;
use App\Models\Equipment;
use App\Models\EquipmentType;
use App\Models\TeamRankType;
use App\Models\ProjectFinancialEstimate;
use Illuminate\Support\Facades\DB;
use App\Models\ProjectKashefAccounts;
use App\Models\ProjectFieldworkTeam;
use App\Models\AttractingTeam;
use App\Models\ProjectObserverTeam;
use App\Models\TrainingUrl;
use Illuminate\Http\Request;
use App\Models\ProjectAuditorTeam;
use App\Mail\TrainingUrlMail;
use App\Mail\ProjectTransaction;
use App\Models\ProjectFamilyDevelopment;
use App\Models\ProjectLocalDevelopment;
use App\Models\User;
use App\Models\ProjectSurveyAccounts;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use App\Models\ProjectEmpowerCharity;
use App\Models\ProjectTransactionHistory;
use App\Models\ProjectTrainingType;
use App\Traits\UploadAble;

class TrainerController extends Controller
{
    protected $model;
    protected $resource;
    protected $trans_file;
    protected $blade_path;
    protected $COMMON_HELPER;
    use UploadAble;

    public function __construct(Project $model)
    {
        $this->middleware('seen', ['only' => ['edit']]);
        $this->model = $model;
        $this->resource = 'trainers';
        $this->blade_path = 'backoffice.trainer';
        $this->trans_file = 'project';
        $this->COMMON_HELPER = app('App\Helpers\Common');
    }

    static public function _endTask(Request $req)
    {
        Project::where('id', $req['project'])->update(['status_id' => '13']);
        ProjectTransactionHistory::where('project_id', $req['project'])->where('user_id', Auth::user()->id)->where('status_id', 26)
            ->update([
                'is_done' => '1',
                'updated_at' => DB::raw('NOW()')
            ]);
        return Redirect::to(url('/' . Auth::user()->roles[0]->name . '/projects'))->with('success', trans('site.mission_finished'));
    }

    public function index($taskType = null)
    {
        if ($taskType == 'correction') {
            $this->blade_path = 'backoffice.trainer.index';
            $compact = [
                'rows' => $this->model::select('id', 'logo', 'title', 'building_count', 'cases_count', 'start_date', 'end_date', 'status_id', 'progress_bar')->where('is_training_correction', '1')->latest()->paginate(12),
                'trans_file' => $this->trans_file,
                'resource' => $this->resource,
                'status' => ProjectStatus::select('id', 'title', 'trans')->get(),
                'types' => ProjectType::select('id', 'title')->get(),
                'regions' => Region::select('id', 'title')->get(),
                'customers' => Customer::select('id', 'title')->get(),
                'equipments' => Equipment::get(),
                'task_type' => 'correction',
                'counter' => $this->model::select('id', 'logo', 'title', 'building_count', 'cases_count', 'start_date', 'end_date', 'status_id', 'progress_bar')->where('is_training_correction', '1')->count(),
            ];

            return view($this->blade_path, $compact);
        } else {
            $this->blade_path = 'backoffice.trainer.index';
            $compact = [
                'rows' => $this->model::select('id', 'logo', 'title', 'building_count', 'cases_count', 'start_date', 'end_date', 'status_id', 'progress_bar')->whereIn('status_id', [7, 19])->latest()->paginate(12),
                'trans_file' => $this->trans_file,
                'resource' => $this->resource,
                'status' => ProjectStatus::select('id', 'title', 'trans')->get(),
                'types' => ProjectType::select('id', 'title')->get(),
                'regions' => Region::select('id', 'title')->get(),
                'customers' => Customer::select('id', 'title')->get(),
                'equipments' => Equipment::get(),
                'task_type' => 'none',
                'counter' => $this->model::select('id', 'logo', 'title', 'building_count', 'cases_count', 'start_date', 'end_date', 'status_id', 'progress_bar')->whereIn('status_id', [7, 19])->count(),
            ];

            return view($this->blade_path, $compact);
        }
    }

    public function projects()
    {
        $this->blade_path = 'backoffice.trainer.index';
        $compact = [
            'rows' => $this->model::select('id', 'logo', 'title', 'building_count', 'cases_count', 'start_date', 'end_date', 'status_id', 'progress_bar')->where('status_id', 7)->latest()->get(),
            'trans_file' => $this->trans_file,
            'resource' => $this->resource,
            'status' => ProjectStatus::select('id', 'title', 'trans')->get(),
            'types' => ProjectType::select('id', 'title')->get(),
            'regions' => Region::select('id', 'title')->get(),
            'customers' => Customer::select('id', 'title')->get(),
            'equipments' => Equipment::get(),
            'counter' => $this->model::select('id', 'logo', 'title', 'building_count', 'cases_count', 'start_date', 'end_date', 'status_id', 'progress_bar')->where('status_id', 7)->count(),
        ];

        return view($this->blade_path, $compact);
    }

    public function edit(Request $request, $projectId)
    {
        $projectCurrentStatus = Project::select('status_id AS status')->where('id', $projectId)->first()->status;
        if (isset($request['status']) && $request['status'] == $projectCurrentStatus) :
            $this->blade_path = 'backoffice.trainer.edit';
        elseif (! isset($request['status'])) :
            $this->blade_path = 'backoffice.trainer.edit';
        else :
            return redirect('/trainer/projects');
        endif;

        $query = $this->model::with('status', 'type', 'region', 'customer', 'localDevelopment')->find($projectId);
        $compact = [
            'trans_file' => $this->trans_file,
            'resource' => $this->resource,
            'row' => $query,
            'users' => ProjectTransactionHistory::with('user')->where('project_id', $projectId)->groupBy('user_id')->get(),
            'project_admin' => User::where('id', 2)->first(),
            'status' => ProjectStatus::select('id', 'title', 'trans')->get(),
            'types' => ProjectType::select('id', 'title')->get(),
            'regions' => Region::select('id', 'title')->get(),
            'customers' => Customer::select('id', 'title')->get(),
            'training' => ProjectTrainingType::where('project_id', $projectId)->with('user')->first(),
            'team_members' => DB::table('users as user')->leftJoin('model_has_roles as role', 'role.model_id', '=', 'user.id')->leftJoin('project_fieldwork_team as field', 'field.user_id', '=', DB::raw("user.id and field.project_id = $projectId"))
                ->select('user.id', 'user.name', 'user.email', 'role.role_id')->whereIn('role.role_id', [6, 7, 12])->whereNull('field.user_id')->get(),
            'equipments' => Equipment::get(),
            'equipment_type' => EquipmentType::get(),
            'team_ranks' => TeamRankType::get(),
            'training_urls' => TrainingUrl::where("project_id", $projectId)->get(),
            'financial_bid_estimate' => ProjectFinancialEstimate::where("project_id", $projectId)->first(),
            'project_family_development' => ProjectFamilyDevelopment::where("project_id", $projectId)->first(),
            'project_local_development' => ProjectLocalDevelopment::where("project_id", $projectId)->first(),
            'kashef_accounts' => ProjectKashefAccounts::where("project_id", $projectId)->first(),
            'survey_accounts' => ProjectSurveyAccounts::where("project_id", $projectId)->first(),
            'selected_researchers' => ProjectObserverTeam::where("project_id", $projectId)->where("type_id", 5)->get(),
            'selected_auditors' => ProjectAuditorTeam::where("project_id", $projectId)->where("type_id", 3)->get(),
            'attracting_teams' => AttractingTeam::whereIN("type_id", [3, 5])->get(),
            'selected_attracting_teams' => DB::table('attracting_team as attracting')->leftJoin('project_observer_team as observer', 'observer.team_user_id', '=', 'attracting.id')
                ->select('attracting.id as id', 'attracting.name as name', 'attracting.mobile as mobile', 'attracting.type_id as type_id', 'attracting.enrolled_date as enrolled_date', 'attracting.accomplished_projects as accomplished_projects', 'attracting.performance_percentage as performance_percentage')
                ->where('attracting.type_id', 4)->whereNull('observer.team_user_id')->get(),
            'selected_observer_teams' => ProjectObserverTeam::where("project_id", $projectId)->where("type_id", 4)->get(),
            'observer_team' => ProjectObserverTeam::select('type_id', DB::raw('COUNT(type_id) as qty'))->where("project_id", $projectId)->groupBy('type_id')->get(),
            'fieldwork_team' => ProjectFieldworkTeam::select('type_id', DB::raw('COUNT(type_id) as qty'))->where("project_id", $projectId)->groupBy('type_id')->get(),
            'fieldwork_teams' => DB::table('project_fieldwork_team as team')->leftJoin('users as user', 'user.id', '=', 'team.user_id')->select('user.username', 'user.name', 'team.type_id', 'team.supervisor_qty')->where('project_id', $projectId)->get(),
            'team_rank_items' => DB::table('project_team_rank_item')->select('type_id', DB::raw('COUNT(type_id) as qty'))->where('project_id', $projectId)->groupBy('type_id')->get(),
            'project_equipments' => DB::table('project_equipments as pe')->leftJoin('equipments as e', 'e.id', '=', 'pe.equipment_id')
                ->select('e.type_id', DB::raw('MAX(pe.qty) as qty'), DB::raw('MAX(pe.price) as price'))->where('project_id', $projectId)->groupBy('e.type_id')->get(),
            'project_empower_charity' => ProjectEmpowerCharity::where('project_id', $projectId)->first(),
            'is_observer_auditor_team_ready' => ProjectFinancialEstimate::where("project_id", $projectId)->whereNotNull("observer_training_date")->whereNotNull("auditor_training_date")->count()
        ];

        return view($this->blade_path, $compact);
    }

    public function saveTrainingUrl(Request $request, $taskType = null)
    {
        $type_id = $request->type_id;
        $type = '';
        $startDate = '';
        $endDate = '';
        if ($type_id == 5) {
            $type = 'الباحثين';
            $startDate = $request['observer_training_date'] . ' ' . $request['start_date'];
            $endDate = $request['observer_training_date'] . ' ' . $request['end_date'];
            $this->COMMON_HELPER->handleCaptureTransaction($request, 11, '1');
            if (ProjectTransactionHistory::where('project_id', $request['project_id'])->where('status_id', 13)->count() == 0) {
                $this->COMMON_HELPER->handleCaptureTransaction($request, 13, '0', 8);
            }
        } elseif ($type_id == 3) {
            $type = 'المدققين';
            $startDate = $request['auditor_training_date'] . ' ' . $request['start_date'];
            $endDate = $request['auditor_training_date'] . ' ' . $request['end_date'];
            $this->COMMON_HELPER->handleCaptureTransaction($request, 12, '1');
            if (ProjectTransactionHistory::where('project_id', $request['project_id'])->where('status_id', 14)->count() == 0) {
                $this->COMMON_HELPER->handleCaptureTransaction($request, 14, '0', 8);
            }
        }

        $mailData = [
            'title' => $request->title,
            'project_title' => Project::where('id', $request['project_id'])->first(),
            'type' => $type,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'link' => $request->url,
            'label' => 'رابط التدريب',
            'train_file_url_check' => $request->train_file_url == null ? 0 : 1,
            'train_file_url' => $request->train_file_url,
            'train_kashef_data_check' => $request->train_file_url == null ? 0 : 1,
            'train_kashef_url' => $request->train_kashef_url,
            'train_kashef_account_email' => $request->train_kashef_account_email,
            'train_kashef_account_password' => $request->train_kashef_account_password,
        ];

        $insertion = [
            'title' => $request['title'],
            'type_id' => $request['type_id'],
            'project_id' => $request['project_id'],
            'is_correction' => $taskType == 'correction' ? '1' : '0',
            'start_date' => $startDate,
            'end_date' => $endDate,
            'url' => $request['url'],
            'train_file_url' => $request['train_file_url'],
            'train_kashef_url' => $request['train_kashef_url'],
            'train_kashef_account_email' => $request['train_kashef_account_email'],
            'train_kashef_account_password' => $request['train_kashef_account_password'],
        ];

        if ($taskType == 'correction') {
            TrainingUrl::create($insertion);
            $attractTeamInfo = DB::table('project_observer_team as team')->leftJoin('attracting_team as info', 'team.team_user_id', 'info.id')->select('info.id as id', 'info.name as name', 'info.email as email')->where('team.project_id', $request['project_id'])
                ->where("team.type_id", 5)->where("team.is_correction", '1')->where("team.approved_member", '0')->get();
            Mail::to($attractTeamInfo)->send(new TrainingUrlMail($mailData));
            foreach ($attractTeamInfo as $info) {
                ProjectObserverTeam::where('project_id', $request["project_id"])->where('team_user_id', $info->id)->update(['training_url_sent' => '1']);
            }
            $arr = array('msg' => __('site.mission_completed'), 'status' => true);
            return response()->json($arr);
        } else {
            TrainingUrl::create($insertion);
            if ($type_id == 5) {
                $attracting_team = AttractingTeam::select('attracting_team.id', 'attracting_team.name', 'attracting_team.email')->leftJoin('project_observer_team as observer', 'observer.team_user_id', '=', 'attracting_team.id')
                    ->where('attracting_team.type_id', 5)->where('observer.project_id', $request["project_id"])->get();
                Mail::to($attracting_team)->send(new TrainingUrlMail($mailData));
                foreach ($attracting_team as $info) {
                    ProjectObserverTeam::where('project_id', $request["project_id"])->where('team_user_id', $info->id)->update(['training_url_sent' => '1']);
                }
            } elseif ($type_id == 3) {
                $attracting_team = AttractingTeam::select('attracting_team.id', 'attracting_team.name', 'attracting_team.email')->leftJoin('project_auditor_team as auditor', 'auditor.team_user_id', '=', 'attracting_team.id')
                    ->where('attracting_team.type_id', 3)->where('auditor.project_id', $request["project_id"])->get();
                Mail::to($attracting_team)->send(new TrainingUrlMail($mailData));
                foreach ($attracting_team as $info) {
                    ProjectObserverTeam::where('project_id', $request["project_id"])->where('team_user_id', $info->id)->update(['training_url_sent' => '1']);
                }
            }

            $arr = array('msg' => __('site.mission_completed'), 'status' => true);
            return response()->json($arr);
        }
    }

    public function saveReceivedTrain(Request $request)
    {
        if (! empty($request['user-checkbox'])) {
            if ($request['type_id'] == '4') {
                ProjectObserverTeam::where('project_id', $request["project_id"])->whereIN('team_user_id', $request['user-checkbox'])->update(['received_train' => '1']);
                $this->COMMON_HELPER->handleCaptureTransaction($request, 13, '1');
            } else {
                ProjectAuditorTeam::where('project_id', $request["project_id"])->whereIN('team_user_id', $request['user-checkbox'])->update(['received_train' => '1']);
                $this->COMMON_HELPER->handleCaptureTransaction($request, 14, '1');
            }
        } else {
            if ($request['type_id'] == '4') {
                ProjectObserverTeam::where('project_id', $request["project_id"])->update(['received_train' => '0']);
            } else {
                ProjectAuditorTeam::where('project_id', $request["project_id"])->update(['received_train' => '0']);
            }
        }

        return back()->with('success', trans('site.mission_completed'));
    }

    public function handOverTask(Request $request)
    {
        $projectId = $request->project_id;
        $auditorQuery = ProjectAuditorTeam::select('team_user_id')->where("project_id", $projectId)->where("type_id", 3)->where("received_train", '1');
        $observerQuery = ProjectObserverTeam::select('team_user_id')->where("project_id", $projectId)->where("type_id", 5)->where("received_train", '1');
        $ProjectAuditorTeam = $auditorQuery->count();
        $ProjectObserverTeam = $observerQuery->count();
        $userRole = '';
        if ($ProjectAuditorTeam > 0 && $ProjectObserverTeam > 0) {
            $emails = ProjectFieldworkTeam::select('email', 'type_id')->join("users", "project_fieldwork_team.user_id", "=", "users.id")->where('project_id', $projectId)->whereIn("type_id", [1, 2])->get();
            foreach ($emails as $e) :
                if ($e->type_id == 1) {
                    $userRole = 'observer';
                } elseif ($e->type_id == 2) {
                    $userRole = 'auditor';
                }

                $mailData = [
                    "project_title" => Project::select('title')->where('id', $projectId)->first()->title,
                    "route" => url($userRole . '/get-team-members/' . $projectId),
                    "reminder" => "no"
                ];
                Mail::to($e->email)->send(new ProjectTransaction($mailData));
            endforeach;

            if (ProjectTransactionHistory::where('project_id', $projectId)->where('status_id', 15)->count() == 0) {
                $observerFieldworkMemebers = ProjectFieldworkTeam::where("project_id", $projectId)->where("type_id", 1)->get();
                foreach ($observerFieldworkMemebers as $member) {
                    $this->COMMON_HELPER->handleCaptureTransaction($request, 15, '0', $member->user_id);
                }
                $this->COMMON_HELPER->handleCaptureTransaction($request, 16, '0', 7);
            }

            $this->COMMON_HELPER->changeProjectStatus($request, 8);
            return Redirect::to(url('/' . Auth::user()->roles[0]->name . '/projects'))->with('success', trans('site.mission_finished'));
        } else {
            $msg = 'الرجاء تحديد علي الاقل شحص من الباحثين والمدققين من جدول المتلقين للتدريب';
            return back()->with('error', $msg);
        }
    }

    public function handOverCorrection(Request $request)
    {
        $projectId = $request->project_id;
        $ProjectObserverTeam = ProjectObserverTeam::where("project_id", $projectId)->where("type_id", 5)->where("received_train", '1')->where("is_correction", '1')->count();
        if ($ProjectObserverTeam > 0) {
            return Redirect::to(url('/' . Auth::user()->roles[0]->name . '/projects/correction'))->with('success', trans('site.mission_finished'));
        } else {
            $msg = 'الرجاء تحديد علي الاقل شحص من الباحثين من جدول المتلقين للتدريب';
            return back()->with('error', $msg);
        }
    }

    public function destroy($type, $urlId = '', $projectId = 0, $teamMemeberId = 0)
    {
        if ($type == 'url') {
            TrainingUrl::where('id', $urlId)->delete();
        } else {
            ProjectTrainingType::where('project_id', $projectId)->where('trainer_id', $teamMemeberId)->update([
                'trainer_id' => null,
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        }
    }

    public function destroyTrainer($projectId, $teamMemeberId)
    {
    }

    public function getCorrection($projectId)
    {
        $query = $this->model::with('status', 'type', 'region', 'customer', 'localDevelopment')->find($projectId);
        $this->blade_path = 'backoffice.trainer.correction';
        $compact = [
            'trans_file' => $this->trans_file,
            'resource' => $this->resource,
            'row' => $query,
            'project_admin' => User::where('id', 2)->first(),
            'status' => ProjectStatus::select('id', 'title', 'trans')->get(),
            'types' => ProjectType::select('id', 'title')->get(),
            'regions' => Region::select('id', 'title')->get(),
            'customers' => Customer::select('id', 'title')->get(),
            'team_members' => DB::table('users as user')->leftJoin('model_has_roles as role', 'role.model_id', '=', 'user.id')->leftJoin('project_fieldwork_team as field', 'field.user_id', '=', DB::raw("user.id and field.project_id = $projectId"))
                ->select('user.id', 'user.name', 'user.email', 'role.role_id')->whereIn('role.role_id', [6, 7])->whereNull('field.user_id')->get(),
            'equipments' => Equipment::get(),
            'equipment_type' => EquipmentType::get(),
            'team_ranks' => TeamRankType::get(),
            'training_urls' => TrainingUrl::where("project_id", $projectId)->where("is_correction", '1')->get(),
            'financial_bid_estimate' => ProjectFinancialEstimate::where("project_id", $projectId)->first(),
            'project_family_development' => ProjectFamilyDevelopment::where("project_id", $projectId)->first(),
            'project_local_development' => ProjectLocalDevelopment::where("project_id", $projectId)->first(),
            'kashef_accounts' => ProjectKashefAccounts::where("project_id", $projectId)->first(),
            'survey_accounts' => ProjectSurveyAccounts::where("project_id", $projectId)->first(),
            'selected_researchers' => ProjectObserverTeam::where("project_id", $projectId)->where("type_id", 5)->where("is_correction", '1')->where("approved_member", '0')->get(),
            'attracting_teams' => AttractingTeam::whereIN("type_id", [3, 5])->get(),
            'selected_attracting_teams' => DB::table('attracting_team as attracting')->leftJoin('project_observer_team as observer', 'observer.team_user_id', '=', 'attracting.id')
                ->select('attracting.id as id', 'attracting.name as name', 'attracting.mobile as mobile', 'attracting.type_id as type_id', 'attracting.enrolled_date as enrolled_date', 'attracting.accomplished_projects as accomplished_projects', 'attracting.performance_percentage as performance_percentage')
                ->where('attracting.type_id', 4)->whereNull('observer.team_user_id')->get(),
            'selected_observer_teams' => ProjectObserverTeam::where("project_id", $projectId)->where("type_id", 4)->get(),
            'observer_team' => ProjectObserverTeam::select('type_id', DB::raw('COUNT(type_id) as qty'))->where("project_id", $projectId)->groupBy('type_id')->get(),
            'fieldwork_team' => ProjectFieldworkTeam::select('type_id', DB::raw('COUNT(type_id) as qty'))->where("project_id", $projectId)->groupBy('type_id')->get(),
            'fieldwork_teams' => DB::table('project_fieldwork_team as team')->leftJoin('users as user', 'user.id', '=', 'team.user_id')->select('user.username', 'user.name', 'team.type_id', 'team.supervisor_qty')->where('project_id', $projectId)->get(),
            'team_rank_items' => DB::table('project_team_rank_item')->select('type_id', DB::raw('COUNT(type_id) as qty'))->where('project_id', $projectId)->groupBy('type_id')->get(),
            'project_equipments' => DB::table('project_equipments as pe')->leftJoin('equipments as e', 'e.id', '=', 'pe.equipment_id')
                ->select('e.type_id', DB::raw('MAX(pe.qty) as qty'), DB::raw('MAX(pe.price) as price'))->where('project_id', $projectId)->groupBy('e.type_id')->get(),
            'is_observer_team_ready' => ProjectFinancialEstimate::where("project_id", $projectId)->whereNotNull("observer_training_date")->count()
        ];

        return view($this->blade_path, $compact);
    }

    public function createTrainerTeam(Request $request)
    {
        if (! empty($request['user-checkbox'])) {
            $insertion = [
                'trainer_id' => $request['user-checkbox'],
                'updated_at' => date('Y-m-d H:i:s')
            ];
            ProjectTrainingType::where('project_id', $request['project_id'])->update($insertion);
            return back()->with('success', trans('site.mission_completed'));
        }
    }

    public function uploadFilesByType(Request $request)
    {
        if ($request['type'] == 'training_plan') {
            $validatedData['training_plan'] = ! empty($request->training_plan) ? $this->uploadOne($request->training_plan, 'projects') : null;
            ProjectTrainingType::where('project_id', $request['project_id'])->update(['training_plan' => $validatedData['training_plan']]);
        } elseif ($request['type'] == 'user_manual') {
            $validatedData['user_manual'] = ! empty($request->user_manual) ? $this->uploadOne($request->user_manual, 'projects') : null;
            ProjectTrainingType::where('project_id', $request['project_id'])->update(['user_manual' => $validatedData['user_manual']]);
        } elseif ($request['type'] == 'training_material') {
            $validatedData['training_material'] = ! empty($request->training_material) ? $this->uploadOne($request->training_material, 'projects') : null;
            ProjectTrainingType::where('project_id', $request['project_id'])->update(['training_material' => $validatedData['training_material']]);
        } elseif ($request['type'] == 'training_report') {
            $validatedData['training_report'] = ! empty($request->training_report) ? $this->uploadOne($request->training_report, 'projects') : null;
            ProjectTrainingType::where('project_id', $request['project_id'])->update(['training_report' => $validatedData['training_report']]);
        }

        $arr = array('msg' => __('site.mission_completed'), 'status' => true);
        return response()->json($arr);
    }

    public function removeFilesByType(Request $request)
    {
        if ($request['type'] == 'training_plan') {
            ProjectTrainingType::where('project_id', $request['project_id'])->update(['training_plan' => '']);
        } elseif ($request['type'] == 'user_manual') {
            ProjectTrainingType::where('project_id', $request['project_id'])->update(['user_manual' => '']);
        } elseif ($request['type'] == 'training_material') {
            ProjectTrainingType::where('project_id', $request['project_id'])->update(['training_material' => '']);
        } elseif ($request['type'] == 'training_report') {
            ProjectTrainingType::where('project_id', $request['project_id'])->update(['training_report' => '']);
        }

        $arr = array('msg' => __('site.mission_completed'), 'status' => true);
        return response()->json($arr);
    }
}