<?php

namespace App\Http\Controllers\Backoffice;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\ProjectStatus;
use App\Models\ProjectType;
use App\Models\Region;
use App\Models\Customer;
use App\Models\Equipment;
use App\Models\ProjectFinancialEstimate;
use App\Models\ProjectKashefAccounts;
use App\Models\AttractingTeam;
use Illuminate\Support\Facades\DB;
use App\Traits\Functions;
use Illuminate\Http\Request;
use App\Models\ProjectAuditorTeam;
use Illuminate\Support\Facades\Crypt;
use ArPHP\I18N\Arabic;
use App\Models\ProjectContractResearchItem;
use App\Models\ProjectContracts;
use App\Models\ProjectTeamRankItem;
use App\Mail\ApproveTeamMembers;
use App\Models\ProjectObserverTeam;
use DataTables;
use App\Models\EquipmentType;
use App\Models\TeamRankType;
use App\Models\TrainingUrl;
use App\Models\ProjectFieldworkTeam;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\ProjectEvaluation;
use App\Models\ProjectSurveyAccounts;
use Exception;
use App\Models\ProjectTrainingDetail;
use App\Models\ProjectTransactionHistory;
use Carbon\Carbon;
use App\Models\ProjectEmpowerCharity;

class AuditorController extends Controller
{
    protected $model;
    protected $resource;
    protected $trans_file;
    protected $blade_path;
    protected $COMMON_HELPER;
    use Functions;
    private static $err;

    public function __construct(Project $model)
    {
        $this->middleware('seen', ['only' => ['edit']]);
        $this->model = $model;
        $this->resource = 'auditors';
        $this->blade_path = 'backoffice.auditor';
        $this->trans_file = 'auditor';
        $this->COMMON_HELPER = app('App\Helpers\Common');
        self::$err = [];
    }

    public function index()
    {
        $row = DB::table('project_fieldwork_team as pf')
            ->leftJoin('projects as project', 'pf.project_id', '=', 'project.id')
            ->leftJoin('project_financial_estimate as bid', 'bid.project_id', '=', 'project.id')
            ->leftJoin('project_transaction_history as pth', 'pth.project_id', '=', 'project.id')
            ->select('project.id', 'project.logo', 'project.title', 'project.cases_count', 'project.start_date', 'project.end_date', 'project.status_id', 'project.progress_bar', 'project.created_at')
            ->whereIn('project.status_id', [6, 8, 9, 10])
            ->whereIn('pth.status_id', [10, 16])
            ->where('pth.is_done', '0')
            ->where('pf.user_id', Auth::user()->id);

        $this->blade_path = 'backoffice.auditor.index';
        $compact = [
            'rows' => $row->latest()->paginate(12),
            'trans_file' => $this->trans_file,
            'resource' => $this->resource,
            'status' => ProjectStatus::select('id', 'title', 'trans')->get(),
            'types' => ProjectType::select('id', 'title')->get(),
            'regions' => Region::select('id', 'title')->get(),
            'customers' => Customer::select('id', 'title')->get(),
            'equipments' => Equipment::get(),
            'counter' => $row->count(),
        ];

        return view($this->blade_path, $compact);
    }

    public function _evalProjects()
    {
        $q = Project::with('status', 'type', 'region', 'customer', 'localDevelopment')->where('status_id', 12);
        $this->blade_path = 'backoffice.auditor.evaluation._evalsProjects';
        $compact = [
            'rows' => $q->latest()->paginate(12),
            'trans_file' => $this->trans_file,
            'resource' => $this->resource,
            'status' => ProjectStatus::select('id', 'title', 'trans')->get(),
            'counter' => $q->count(),
        ];

        return view($this->blade_path, $compact);
    }

    public function _evalProjectInfo($ID)
    {
        $q = Project::with('status', 'type', 'region', 'customer', 'localDevelopment')->find($ID);
        $team = DB::table('project_observer_team AS POT')
            ->join('attracting_team AS AT', "AT.id", "=", "POT.team_user_id")
            ->leftJoin('project_evaluations as eva', 'eva.team_user_id', '=', DB::raw('POT.team_user_id and eva.project_id = POT.project_id'))
            ->select('name', 'avatar', 'email', 'mobile', 'region_id', 'AT.city_id AS city', 'POT.team_user_id')
            ->where("POT.project_id", $ID)->where("POT.type_id", 5)->whereNull("eva.team_user_id")->get();

        return view('backoffice.auditor.evaluation._evalProjectInfo', ['row' => $q, "team" => $team]);
    }

    public function _evalResearcher(Request $req)
    {
        if ($req->missing('rating')) {
            self::$err['rating'] = "يجب عليك اختيار قيمه";
        }

        if (empty(self::$err)) :
            ProjectEvaluation::updateOrCreate([
                'team_user_id' => $req['researcher'],
                'type_id' => 5,
                'project_id' => $req['project'],
                'user_id' => Auth::user()->id
            ],
                [
                    'evaluate' => $req['rating'],
                    'created_at' => DB::raw('NOW()')

                ]
            );
            return response()->json(["MSG" => "تم تقييم الموظف بنجاح", "code" => 200]);
        else :
            return response()->json(["err" => self::$err, "code" => 400]);
        endif;
    }

    public function edit(Request $request, $projectId)
    {
        $projectCurrentStatus = Project::select('status_id AS status')->where('id', $projectId)->first()->status;
        if (isset($request['status']) && $request['status'] == $projectCurrentStatus) :
            $this->blade_path = 'backoffice.auditor.edit';
        elseif (! isset($request['status'])) :
            $this->blade_path = 'backoffice.auditor.edit';
        else :
            return redirect('/auditor/projects');
        endif;
        $query = $this->model::with('status', 'type', 'region', 'customer', 'localDevelopment')->find($projectId);

        $compact = [
            'trans_file' => $this->trans_file,
            'resource' => $this->resource,
            'row' => $query,
            'users' => ProjectTransactionHistory::with('user')->where('project_id', $projectId)->groupBy('user_id')->get(),
            'project_admin' => User::where('id', 2)->first(),
            'financial_bid_estimate' => ProjectFinancialEstimate::where("project_id", $projectId)->first(),
            'kashef_accounts' => ProjectKashefAccounts::where("project_id", $projectId)->first(),
            'survey_accounts' => ProjectSurveyAccounts::where("project_id", $projectId)->first(),
            'attracting_teams' => AttractingTeam::where("type_id", 3)->get(),
            'project_empower_charity' => ProjectEmpowerCharity::where('project_id', $projectId)->first(),
            'selected_attracting_teams' => DB::table('attracting_team as attracting')->leftJoin('project_auditor_team as auditor', 'auditor.team_user_id', '=', DB::raw("attracting.id and auditor.project_id = $projectId"))
                ->select('attracting.id as id', 'attracting.name as name', 'attracting.mobile as mobile', 'attracting.type_id as type_id', 'attracting.enrolled_date as enrolled_date', 'attracting.accomplished_projects as accomplished_projects', 'attracting.performance_percentage as performance_percentage')
                ->where('attracting.type_id', 3)->whereNull('auditor.team_user_id')->get(),
            'selected_auditor_teams' => ProjectAuditorTeam::where("project_id", $projectId)->where("type_id", 3)->get(),
            'auditor_team' => ProjectAuditorTeam::select('type_id', DB::raw('COUNT(type_id) as qty'))->where("project_id", $projectId)->groupBy('type_id')->get(),
        ];

        return view($this->blade_path, $compact);
    }

    public function createAuditorTeam(Request $request)
    {
        $financial_bid_estimate = ProjectFinancialEstimate::where("project_id", $request['project_id'])->first();
        $auditor_qty = $financial_bid_estimate->auditor_qty;
        if (! empty($request['user-checkbox'])) {
            $rowNo = count($request['user-checkbox']);
            if (! empty($request['selected-user-checkbox'])) {
                $rowNo += count($request['selected-user-checkbox']);
            }
            if ($rowNo > $auditor_qty) {
                return back()->with('error', trans('إجمالي عدد المدققين لا يتعدى ' . $auditor_qty));
                exit();
            }
        }

        if (! empty($request['selected-user-checkbox'])) {
            ProjectAuditorTeam::where('project_id', $request['project_id'])->where('type_id', $request['type_id'])->whereNotIn('id', $request['selected-user-checkbox'])->delete();

            $rowNo = count($request['selected-user-checkbox']);
            for ($i = 0; $i < $rowNo; $i++) {
                $teamUserId = $request['selected-user-checkbox'][$i];
                $insertion = [
                    'qty' => $request['selected-users-' . $teamUserId],
                    'updated_at' => date('Y-m-d H:i:s')
                ];

                ProjectAuditorTeam::where('project_id', $request['project_id'])->where('type_id', $request['type_id'])->where('id', $teamUserId)->update($insertion);
            }
        }

        if (! empty($request['user-checkbox'])) {
            $totalAuditorQty = 0;
            if ($totalAuditorQty > $auditor_qty) {
                return back()->with('error', trans('إجمالي عدد الكادر لا يتعدى ' . $auditor_qty));
                exit();
            }

            $project_observer_team = DB::table('project_auditor_team')->select(DB::raw('COUNT(qty) as qty'))->where('project_id', $request['project_id'])->where('type_id', 3)->first();
            $totalAuditorQty += $project_observer_team->qty;
            if ($totalAuditorQty > $auditor_qty) {
                return back()->with('error', trans('إجمالي عدد الكادر لا يتعدى ' . $auditor_qty));
                exit();
            }

            $rowNo = count($request['user-checkbox']);
            for ($i = 0; $i < $rowNo; $i++) {
                $insertion = [
                    'team_user_id' => $request['user-checkbox'][$i],
                    'superior_id' => $request['superior_id'],
                    'type_id' => $request['type_id'],
                    'project_id' => $request['project_id'],
                    'qty' => 0,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ];

                ProjectAuditorTeam::create($insertion);
            }
        }

        if (empty($request['user-checkbox']) && empty($request['selected-user-checkbox'])) {
            ProjectAuditorTeam::where('project_id', $request['project_id'])->where('type_id', $request['type_id'])->delete();
        }

        return back()->with('success', trans('site.mission_completed'));
    }

    public function getTeamMembersForApproval($projectId)
    {
        $query = $this->model::with('status', 'type', 'region', 'customer', 'localDevelopment')->find($projectId);
        $this->blade_path = 'backoffice.auditor.manage-team.approve-member';

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
            'training_urls' => TrainingUrl::where("project_id", $projectId)->get(),
            'financial_bid_estimate' => ProjectFinancialEstimate::where("project_id", $projectId)->first(),
            'kashef_accounts' => ProjectKashefAccounts::where("project_id", $projectId)->first(),
            'selected_researchers' => ProjectAuditorTeam::where("project_id", $projectId)->where("type_id", 3)->where('approved_member', '0')->get(),
            'attracting_teams' => AttractingTeam::where("type_id", 3)->get(),
            'selected_attracting_teams' => DB::table('attracting_team as attracting')->leftJoin('project_observer_team as observer', 'observer.team_user_id', '=', 'attracting.id')
                ->select('attracting.id as id', 'attracting.name as name', 'attracting.mobile as mobile', 'attracting.type_id as type_id', 'attracting.enrolled_date as enrolled_date', 'attracting.accomplished_projects as accomplished_projects', 'attracting.performance_percentage as performance_percentage')
                ->where('attracting.type_id', 4)->whereNull('observer.team_user_id')->get(),
            'fieldworkCounts' => ProjectFieldworkTeam::select(DB::raw('SUM(supervisor_qty) AS supervisors,SUM(researcher_qty) AS researchers,SUM(auditor_qty) AS auditors'))
                ->where('project_id', $projectId)->where('user_id', Auth::user()->id)->first(),
            'selected_auditor_teams' => ProjectAuditorTeam::where("project_id", $projectId)->where("type_id", 3)->get(),
            'auditor_team' => ProjectAuditorTeam::select('type_id', DB::raw('COUNT(type_id) as qty'))->where("project_id", $projectId)->groupBy('type_id')->get(),
            'fieldwork_team' => ProjectFieldworkTeam::select('type_id', DB::raw('COUNT(type_id) as qty'))->where("project_id", $projectId)->groupBy('type_id')->get(),
            'fieldwork_teams' => DB::table('project_fieldwork_team as team')->leftJoin('users as user', 'user.id', '=', 'team.user_id')->select('user.username', 'user.name', 'team.type_id', 'team.supervisor_qty')->where('project_id', $projectId)->get(),
            'team_rank_items' => DB::table('project_team_rank_item')->select('type_id', DB::raw('COUNT(type_id) as qty'))->where('project_id', $projectId)->groupBy('type_id')->get(),
            'project_equipments' => DB::table('project_equipments as pe')->leftJoin('equipments as e', 'e.id', '=', 'pe.equipment_id')
                ->select('e.type_id', DB::raw('MAX(pe.qty) as qty'), DB::raw('MAX(pe.price) as price'))->where('project_id', $projectId)->groupBy('e.type_id')->get(),
        ];

        return view($this->blade_path, $compact);
    }

    public function approveTeamMembers(Request $request)
    {
        if (! empty($request['user-checkbox'])) {
            try {
                // Send Mail To ALL Observers
                $observers = ProjectObserverTeam::with('atttractingTeamInfo')->where('project_id', $request['project_id'])->where('type_id', 1)->get();
                foreach ($observers as $value) {
                    if (! empty($value->atttractingTeamInfo->email)) {
                        $params = [Crypt::encrypt($request['project_id']), Crypt::encrypt($value->team_user_id)];
                        $mailData = [
                            'route' => route('team-member-contract', $params),
                            'label' => __('project.contract_details'),
                        ];

                        Mail::to($value->atttractingTeamInfo->email)->send(new ApproveTeamMembers($mailData));
                        ProjectContracts::create([
                            'project_id' => $request['project_id'],
                            'type_id' => $value->atttractingTeamInfo->type_id,
                            'team_user_id' => $value->atttractingTeamInfo->id,
                            'send_date' => date('Y-m-d'),
                        ]);
                    }
                }

                $observteam = ProjectAuditorTeam::where('project_id', $request["project_id"])->whereIn('team_user_id', $request['user-checkbox']);
                if ($observteam->exists()) {
                    $attracting_team = AttractingTeam::whereIn('id', $request["user-checkbox"])->get();
                    foreach ($attracting_team as $value) {
                        if (! empty($value->email)) {
                            $params = [
                                Crypt::encrypt($request["project_id"]),
                                Crypt::encrypt($value->id)
                            ];
                            $mailData = [
                                'route' => route('team-member-contract', $params),
                                'label' => __('project.contract_details'),
                            ];

                            Mail::to($value->email)->send(new ApproveTeamMembers($mailData));
                            ProjectContracts::create([
                                'project_id' => $request['project_id'],
                                'type_id' => $value->type_id,
                                'team_user_id' => $value->id,
                                'send_date' => date('Y-m-d'),
                            ]);
                        }
                    }

                    ProjectAuditorTeam::where('project_id', $request["project_id"])->whereIn('team_user_id', $request['user-checkbox'])->update(['received_train' => '1', 'approved_member' => '1']);
                    //We need to check if OBSERVER user has approved his team members first
                    if (ProjectObserverTeam::where('project_id', $request["project_id"])->where('approved_member', '=', '1')->exists()) {
                        $isObserverDoneTask = ProjectTransactionHistory::where('project_id', $request['project_id'])->where('status_id', 15)->where('is_done', '1')->count() > 0;
                        $otherObserverNotDoneTask = ProjectTransactionHistory::where('project_id', $request['project_id'])->where('status_id', 15)->count();
                        $otherObserverDoneTask = ProjectTransactionHistory::where('project_id', $request['project_id'])->where('status_id', 15)->where('is_done', '1')->count();
                        $moveToTrainer = $otherObserverNotDoneTask == $otherObserverDoneTask ? true : false;
                        if ($isObserverDoneTask && $moveToTrainer) {
                            $this->COMMON_HELPER->changeProjectStatus($request, 9);
                        }
                    }

                    $this->COMMON_HELPER->handleCaptureTransaction($request, 16, '1');
                    $arr = array('msg' => __('site.mission_completed'), 'status' => true);
                    return response()->json($arr);
                } else {
                    $arr = array('msg' => __('site.storeMessageError'), 'status' => false);
                    return response()->json($arr); // 400 being the HTTP code for an invalid request.
                }
            } catch (Exception $e) {
                $arr = ['msg' => $e->getMessage(), 'status' => false];
                return response()->json($arr); // 400 being the HTTP code for an invalid request.
            }
        } else {
            $arr = array('msg' => __('site.storeMessageError'), 'status' => false);
            return response()->json($arr); // 400 being the HTTP code for an invalid request.
        }
    }

    public function teamMemberContract($projectId, $teamuserId)
    {
        $CheckExistContractApproved = ProjectContracts::where('project_id', Crypt::decrypt($projectId))->where('team_user_id', Crypt::decrypt($teamuserId))->where('approved', '1')->exists();
        $CheckExistContractExp = ProjectContracts::where('project_id', Crypt::decrypt($projectId))->where('team_user_id', Crypt::decrypt($teamuserId))->where('send_date', '<', Carbon::now()->subDay(1))->exists();
        if ($CheckExistContractApproved || $CheckExistContractExp) {
            $compact = ['msg' => 'رابط العقد إما قد تم الموافقة على العقد، وإما العقد قد انتهت مددته'];
            $this->blade_path = 'backoffice.observer.manage-team.contractAlreadyApproved';
        } else {
            $this->blade_path = 'backoffice.observer.manage-team.contract';
            $row = AttractingTeam::with('type')->select('id', 'name', 'national_id', 'mobile', 'region_id', 'city_id', 'email', 'type_id')->where('id', Crypt::decrypt($teamuserId))->firstOrFail();
            $date_obj = new Arabic('Date');
            $compact = [
                'projectId' => $projectId,
                'teamuserId' => $teamuserId,
                'typeTd' => Crypt::encrypt($row->type->id),
                'logo' => asset('assets/media/logos/alfares.jpg'),
                'div_class' => 'divContractPreview',
                'team_rank_item' => ProjectTeamRankItem::select('project_id', 'type_id', 'title')->where(['project_id' => Crypt::decrypt($projectId), 'type_id' => $row->type_id])->get(),
                'row' => $row,
                'today_day_arabic' => $date_obj->date('l', time()),
                'team_rank_type_trans' => $row->type->trans,
                'project_title' => Project::select('title')->where('id', Crypt::decrypt($projectId))->first()->value('title'),
                'trans_file' => $this->trans_file,
                'resource' => $this->resource,
                'contract_research_items' => ProjectContractResearchItem::where(['project_id' => Crypt::decrypt($projectId)]),
                'preview_pdf' => 1,
            ];
        }

        return view($this->blade_path, $compact);
    }

    public function generateTeamMemberContract(Request $request, $projectId, $teamuserId, $TypeId)
    {
        $row = AttractingTeam::with('type', 'region', 'city')->select('id', 'name', 'national_id', 'mobile', 'region_id', 'city_id', 'email', 'type_id')->where('id', Crypt::decrypt($teamuserId))->firstOrFail();
        $date_obj = new Arabic('Date');
        $logo = 'assets/media/logos/alfares.jpg';
        $team_rank_item = ProjectTeamRankItem::select('project_id', 'type_id', 'title')->where(['project_id' => Crypt::decrypt($projectId), 'type_id' => $row->type_id])->get();
        $attracting = $row;
        $today_day_arabic = $date_obj->date('l', time());
        $team_rank_type_trans = $row->type->trans;
        $project_title = Project::select('title')->where('id', Crypt::decrypt($projectId))->first()->value('title');
        $pdf_preview = 0;
        $contract_research_items = ProjectContractResearchItem::where(['project_id' => Crypt::decrypt($projectId), 'type_id' => $row->type_id]);
        $contractOutPut = $this->loadContractInfo($attracting, $team_rank_item, $logo, $team_rank_type_trans, $today_day_arabic, $project_title, $pdf_preview, $contract_research_items);
        $contract_url = $this->generateContract($contractOutPut, $team_rank_type_trans);

        if (
            ProjectContracts::where('project_id', Crypt::decrypt($projectId))->where('type_id', Crypt::decrypt($TypeId))
                ->update([
                    'contract_url' => $contract_url['contract_url'],
                    'approved' => $request->term == 1 ? '1' : '0',
                    'type_id' => Crypt::decrypt($TypeId),
                    'team_user_id' => Crypt::decrypt($teamuserId),
                ])
        ) {
            return redirect('https://al-fares.sa');
        }
    }

    public function handOverTask(Request $request)
    {
        $trainDate = [];
        if ($request->has("trainrequire")) :
            $trainDate = [
                'auditor_training_date' => $request['auditor_training_date'],
                'auditor_training_required' => '1'
            ];
        else :
            $trainDate = [
                'auditor_training_date' => NULL,
                'auditor_training_required' => '0'
            ];
        endif;

        $isObserverDoneTask = ProjectTransactionHistory::where('project_id', $request['project_id'])->where('status_id', 9)->where('is_done', '1')->count() > 0;
        $otherObserverNotDoneTask = ProjectTransactionHistory::where('project_id', $request['project_id'])->where('status_id', 9)->count();
        $otherObserverDoneTask = ProjectTransactionHistory::where('project_id', $request['project_id'])->where('status_id', 9)->where('is_done', '1')->count();
        $isCreateAccountsAppear = ProjectTransactionHistory::where('project_id', $request['project_id'])->where('status_id', 17)->where('is_done', '0')->count() == 0;
        $moveToTrainer = $otherObserverNotDoneTask == $otherObserverDoneTask ? true : false;
        if ($request['type_id'] == '12') {
            $this->COMMON_HELPER->handleCaptureTransaction($request, 10, '1');
            ProjectFinancialEstimate::where('project_id', $request['project_id'])->update($trainDate);
            if (ProjectFinancialEstimate::where('project_id', $request['project_id'])->where('is_espeical_training_needed', '1')->count() > 0) {
                if ($isObserverDoneTask && $moveToTrainer && $request->has("trainrequire")) {
                    $this->COMMON_HELPER->changeProjectStatus($request, 7);
                } else {
                    $this->COMMON_HELPER->changeProjectStatus($request, 9);
                }

                if ($moveToTrainer && $request->has("trainrequire")) {
                    $this->COMMON_HELPER->handleCaptureTransaction($request, 12, '0', 8);
                } else {
                    $this->COMMON_HELPER->handleCaptureTransaction($request, 17, '0', 9);
                }
            } else {
                if ($isObserverDoneTask && $moveToTrainer) {
                    $this->COMMON_HELPER->changeProjectStatus($request, 9);
                }
            }
        } else {
            if ($request['is_trainer'] == 'true') {
                if ($isObserverDoneTask && $moveToTrainer) {
                    $this->COMMON_HELPER->handleCaptureTransaction($request, 22, '1');
                } else {
                    $this->COMMON_HELPER->changeProjectStatus($request, 13);
                }
                ProjectTrainingDetail::where('project_id', $request['project_id'])->update(['training_date' => $request['auditor_training_date']]);
            } else {
                if ($request->has("trainrequire")) {
                    $this->COMMON_HELPER->changeProjectStatus($request, 72);
                } else {
                    $this->COMMON_HELPER->changeProjectStatus($request, 9);
                }

                $this->COMMON_HELPER->handleCaptureTransaction($request, 10, '1');
                if ($request->has("trainrequire")) {
                    $this->COMMON_HELPER->handleCaptureTransaction($request, 12, '0', 8);
                } elseif ($isCreateAccountsAppear) {
                    $this->COMMON_HELPER->handleCaptureTransaction($request, 17, '0', 9);
                }
            }
        }

        return Redirect::to(url('/' . Auth::user()->roles[0]->name . '/projects'))->with('success', trans('site.mission_finished'));
    }

    public function update()
    {
    }

    public function contractProjects()
    {
        $row = DB::table('project_fieldwork_team as pf')->leftJoin('projects as project', 'pf.project_id', '=', 'project.id')->leftJoin('project_financial_estimate as bid', 'bid.project_id', '=', 'project.id')
            ->select('project.id', 'project.logo', 'project.title', 'project.cases_count', 'project.start_date', 'project.end_date', 'project.status_id', 'project.progress_bar', 'project.created_at')
            ->whereIN('project.status_id', [6, 8, 10])->where('pf.user_id', Auth::user()->id);
        $this->blade_path = 'backoffice.auditor.contractprojects';
        $compact = [
            'rows' => $row->latest()->paginate(12),
            'trans_file' => $this->trans_file,
            'resource' => $this->resource,
            'status' => ProjectStatus::select('id', 'title', 'trans')->get(),
            'types' => ProjectType::select('id', 'title')->get(),
            'regions' => Region::select('id', 'title')->get(),
            'customers' => Customer::select('id', 'title')->get(),
            'equipments' => Equipment::get(),
            'counter' => $row->count(),
        ];

        return view($this->blade_path, $compact);
    }

    public function contractProjectsDetails($project_id, Request $request)
    {
        $query = ProjectAuditorTeam::select('team_user_id')->where('project_id', $project_id)->where('superior_id', auth()->user()->id)->get();
        $queryContract = ProjectContracts::with('atttractingTeamInfo')->where('project_id', $project_id)->whereIN('team_user_id', $query);
        if ($request->ajax()) {
            return Datatables::of($queryContract->get())->addIndexColumn()
                ->editColumn('atttractingTeamInfo.name', function ($row) {
                    return $row->atttractingTeamInfo->name;
                })->editColumn('atttractingTeamInfo.national_id', function ($row) {
                return $row->atttractingTeamInfo->national_id;
            })->editColumn('atttractingTeamInfo.mobile', function ($row) {
                return $row->atttractingTeamInfo->mobile;
            })->editColumn('atttractingTeamInfo.region', function ($row) {
                return $row->atttractingTeamInfo->region;
            })->editColumn('atttractingTeamInfo.city', function ($row) {
                return $row->atttractingTeamInfo->city;
            })->editColumn('atttractingTeamInfo.email', function ($row) {
                return $row->atttractingTeamInfo->email;
            })->editColumn('contract_url', function ($row) {
                $div = "";
                if ($row->contract_url) {
                    $contract_url = url('contracts/' . $row->contract_url);
                    $div .= '<a href="' . $contract_url . '" class="btn btn-sm btn-flex btn-light-primary">
                    <span class="svg-icon svg-icon-3">
                        <svg width="62" height="62" viewBox="0 0 62 62" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M15.5 0C13.3687 0 11.625 1.74375 11.625 3.875V58.125C11.625 60.2562 13.3687 62 15.5 62H54.25C56.3812 62 58.125 60.2562 58.125 58.125V15.5L42.625 0H15.5Z" fill="#E2E5E7" />
                            <path d="M46.5 15.5H58.125L42.625 0V11.625C42.625 13.7563 44.3687 15.5 46.5 15.5Z" fill="#B0B7BD" />
                            <path d="M58.125 27.125L46.5 15.5H58.125V27.125Z" fill="#CAD1D8" />
                            <path d="M50.375 50.375C50.375 51.4406 49.5031 52.3125 48.4375 52.3125H5.8125C4.74687 52.3125 3.875 51.4406 3.875 50.375V31C3.875 29.9344 4.74687 29.0625 5.8125 29.0625H48.4375C49.5031 29.0625 50.375 29.9344 50.375 31V50.375Z" fill="#F15642" />
                            <path d="M12.3203 36.7099C12.3203 36.1984 12.7233 35.6404 13.3724 35.6404H16.9509C18.9659 35.6404 20.7794 36.9889 20.7794 39.5735C20.7794 42.0225 18.9659 43.3865 16.9509 43.3865H14.3644V45.4325C14.3644 46.1145 13.9304 46.5001 13.3724 46.5001C12.8609 46.5001 12.3203 46.1145 12.3203 45.4325V36.7099ZM14.3644 37.5914V41.4509H16.9509C17.9894 41.4509 18.8109 40.5345 18.8109 39.5735C18.8109 38.4904 17.9894 37.5914 16.9509 37.5914H14.3644Z" fill="white" />
                            <path d="M23.8136 46.5C23.3021 46.5 22.7441 46.221 22.7441 45.5409V36.7408C22.7441 36.1847 23.3021 35.7798 23.8136 35.7798H27.3612C34.4408 35.7798 34.2858 46.5 27.5007 46.5H23.8136ZM24.7901 37.6708V44.6109H27.3612C31.5443 44.6109 31.7303 37.6708 27.3612 37.6708H24.7901Z" fill="white" />
                            <path d="M36.7966 37.7948V40.2573H40.7472C41.3052 40.2573 41.8632 40.8153 41.8632 41.3559C41.8632 41.8674 41.3052 42.2859 40.7472 42.2859H36.7966V45.539C36.7966 46.0815 36.4111 46.498 35.8686 46.498C35.1866 46.498 34.77 46.0815 34.77 45.539V36.7388C34.77 36.1828 35.1885 35.7778 35.8686 35.7778H41.3071C41.9891 35.7778 42.3921 36.1828 42.3921 36.7388C42.3921 37.2348 41.9891 37.7928 41.3071 37.7928H36.7966V37.7948Z" fill="white" />
                            <path d="M48.4375 52.3125H11.625V54.25H48.4375C49.5031 54.25 50.375 53.3781 50.375 52.3125V50.375C50.375 51.4406 49.5031 52.3125 48.4375 52.3125Z" fill="#CAD1D8" />
                        </svg>
                    </span>
                    <!--end::Svg Icon-->إستعراض العقد
                </a>';
                } else {
                    $div = '<span class="text-danger">العقد غير متوفر</span>';
                }
                return $div;
            })->rawColumns([
                        'atttractingTeamInfo.name',
                        'atttractingTeamInfo.national_id',
                        'atttractingTeamInfo.mobile',
                        'atttractingTeamInfo.email',
                        'contract_url',
                    ])->make(true);
        }

        $compact = [
            'trans_file' => 'user',
            'url' => url("auditor/contract-projects/details/" . $project_id),
            'project_id' => $project_id,
            'resource' => 'admin.users.',
            'counter' => $query->count(),
        ];

        return view('backoffice.auditor.contractprojectsdetails', $compact);
    }
}