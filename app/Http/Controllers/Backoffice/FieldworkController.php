<?php

namespace App\Http\Controllers\Backoffice;

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
use Illuminate\Http\Request;
use App\Models\ProjectFieldworkTeam;
use App\Mail\FieldworkStarted;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Mail\ApproveTeamMembers;
use Illuminate\Support\Facades\Crypt;
use App\Models\ProjectContracts;
use App\Models\ProjectFamilyDevelopment;
use App\Models\ProjectLocalDevelopment;
use App\Models\ProjectExploreTour;
use App\Traits\UploadAble;
use App\Models\ProjectSurveyAccounts;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Notification;
use App\Notifications\FieldWorkNotification;
use App\Mail\ProjectExploreTour as PET;
use App\Models\ProjectEmpowerCharity;
use App\Mail\ProjectTransaction;
use App\Models\ProjectTransactionHistory;

class FieldworkController extends Controller
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
        $this->resource = 'fieldworks';
        $this->blade_path = 'backoffice.fieldwork';
        $this->trans_file = 'fieldwork';
        $this->COMMON_HELPER = app('App\Helpers\Common');
    }

    public function index($taskType = null)
    {
        $compact = [];
        $this->blade_path = 'backoffice.fieldwork.index';
        ProjectFinancialEstimate::select('id', 'logo', 'title', 'cases_count', 'start_date', 'end_date', 'status_id', 'progress_bar');
        if ($taskType == 'tour') {
            $sqlQuery = DB::table('project_financial_estimate as pf')
                ->select('et.is_fieldwork_done', 'pr.id', 'pr.logo', 'pr.title', 'pr.cases_count', 'pr.start_date', 'pr.end_date', 'pr.status_id', 'pr.progress_bar', 'pr.created_at')
                ->leftJoin('projects as pr', 'pr.id', '=', 'pf.project_id')
                ->leftJoin('project_explore_tour as et', 'pr.id', '=', 'et.project_id')
                ->where('pf.is_explore_tour_required', '1')
                ->where('et.is_fieldwork_done', '0')->where('deleted_at', null);

            $compact = [
                'list' => 'قائمه الجولات',
                'placeholder' => 'إسم الجوله',
                'title' => 'جولات',
                'rows' => $sqlQuery->latest()->paginate(12),
                'trans_file' => $this->trans_file,
                'resource' => $this->resource,
                'status' => ProjectStatus::select('id', 'title', 'trans')->get(),
                'counter' => $sqlQuery->count(),
            ];
        } else {
            $sqlQuery = $this->model::select('id', 'logo', 'title', 'building_count', 'cases_count', 'start_date', 'end_date', 'status_id', 'progress_bar')->whereNotIn('type_id', [13, 14])->where('status_id', '>=', 5);
            $compact = [
                'list' => 'قائمه المهام',
                'placeholder' => 'إسم المهمه',
                'title' => 'مهام',
                'rows' => $sqlQuery->latest()->paginate(12),
                'trans_file' => $this->trans_file,
                'resource' => $this->resource,
                'status' => ProjectStatus::select('id', 'title', 'trans')->get(),
                'counter' => $sqlQuery->count(),
            ];
        }

        return view($this->blade_path, $compact);
    }

    public function contractProjects($taskType = null)
    {
        $compact = [];
        $this->blade_path = 'backoffice.fieldwork.contractprojects';
        if ($taskType == 'tour') {
            $row = DB::table('project_financial_estimate as pf')
                ->leftJoin('projects as project', 'pf.project_id', '=', 'project.id')
                ->leftJoin('project_explore_tour as tour', 'tour.project_id', '=', 'project.id')
                ->select('project.id', 'project.logo', 'project.title', 'project.cases_count', 'project.start_date', 'project.end_date', 'project.status_id', 'project.progress_bar', 'project.created_at')
                ->where('pf.is_explore_tour_required', '1')
                ->where('tour.is_fieldwork_done', '1')
                ->where('tour.user_id', Auth::user()->id);

            $compact = [
                'rows' => $row->latest()->paginate(12),
                'trans_file' => $this->trans_file,
                'resource' => $this->resource,
                'status' => ProjectStatus::select('id', 'title', 'trans')->get(),
                'equipments' => Equipment::get(),
                'counter' => $row->count(),
                'taskType' => 'tour',
            ];
        } else {
            $row = DB::table('project_fieldwork_team as pf')
                ->leftJoin('projects as project', 'pf.project_id', '=', 'project.id')
                ->leftJoin('project_financial_estimate as bid', 'bid.project_id', '=', 'project.id')
                ->select('project.id', 'project.logo', 'project.title', 'project.cases_count', 'project.start_date', 'project.end_date', 'project.status_id', 'project.progress_bar', 'project.created_at')
                ->whereIN('project.status_id', [6, 8, 10])
                ->where('pf.user_id', Auth::user()->id);
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
                'taskType' => 'none',
            ];
        }

        return view($this->blade_path, $compact);
    }

    public function contractProjectsDetails($project_id, Request $request)
    {
        $query = DB::table('attracting_team as attracting')
            ->leftJoin('project_observer_team as observer', 'observer.team_user_id', '=', "attracting.id")
            ->leftJoin('project_contracts as contract', 'contract.team_user_id', '=', "attracting.id")
            ->where('attracting.type_id', '<>', 3)->where('observer.project_id', $project_id)
            ->whereRaw('(observer.team_user_id IN (select team_user_id from project_observer_team AS sub_observer WHERE sub_observer.superior_id = ' . Auth::user()->id . ')
                OR observer.team_user_id IN (select team_user_id from project_observer_team AS sub_observer WHERE sub_observer.superior_team_id
                IN (select team_user_id from project_observer_team AS sub_observer WHERE sub_observer.superior_id = 6)))');

        if ($request->ajax()) {
            return Datatables::of($query->get())->addIndexColumn()->editColumn('contract_url', function ($row) {
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
            })->rawColumns(['contract_url'])->make(true);
        }

        $compact = [
            'trans_file' => 'user',
            'url' => url("fieldwork/contract-projects/details/" . $project_id),
            'project_id' => $project_id,
            'resource' => 'admin.users.',
            'counter' => $query->count(),
        ];

        return view('backoffice.fieldwork.contractprojectsdetails', $compact);
    }

    public function edit(Request $request, $projectId)
    {
        $projectCurrentStatus = Project::select('status_id AS status')->where('id', $projectId)->first()->status;
        $projectCurrentTour = ProjectExploreTour::where('project_id', $projectId)->where('is_fieldwork_done', '1')->exists();
        if (! $projectCurrentTour || $projectCurrentStatus >= 4) {
            if (isset($request['status']) && $request['status'] == $projectCurrentStatus) :
                $this->blade_path = 'backoffice.fieldwork.edit';
            elseif (! isset($request['status'])) :
                $this->blade_path = 'backoffice.fieldwork.edit';
            else :
                return redirect('/fieldwork/projects');
            endif;
        } else {
            return redirect('/fieldwork/projects/tour');
        }

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
            'team_members' => DB::table('users as user')->leftJoin('model_has_roles as role', 'role.model_id', '=', 'user.id')->leftJoin('project_fieldwork_team as field', 'field.user_id', '=', DB::raw("user.id and field.project_id = $projectId"))
                ->select('user.id', 'user.name', 'user.email', 'role.role_id')->whereIn('role.role_id', [6, 7, 11])->whereNull('field.user_id')->get(),
            'equipments' => Equipment::get(),
            'equipment_type' => EquipmentType::get(),
            'team_ranks' => TeamRankType::get(),
            'project_empower_charity' => ProjectEmpowerCharity::where('project_id', $projectId)->first(),
            'financial_bid_estimate' => ProjectFinancialEstimate::where("project_id", $projectId)->first(),
            'project_family_development' => ProjectFamilyDevelopment::where("project_id", $projectId)->first(),
            'project_local_development' => ProjectLocalDevelopment::where("project_id", $projectId)->first(),
            'kashef_accounts' => ProjectKashefAccounts::where("project_id", $projectId)->first(),
            'survey_accounts' => ProjectSurveyAccounts::where("project_id", $projectId)->first(),
            'project_explore_tour' => ProjectExploreTour::with('city')->leftJoin('users as user', 'user.id', '=', 'project_explore_tour.user_id')->select('user.id', 'user.username', 'user.name', 'project_explore_tour.type_id', 'project_explore_tour.city_id', 'project_explore_tour.explore_tour')->where('project_id', $projectId)->first(),
            'fieldwork_team' => ProjectFieldworkTeam::select('type_id', DB::raw('COUNT(type_id) as qty'))->where("project_id", $projectId)->groupBy('type_id')->get(),
            'fieldwork_teams' => DB::table('project_fieldwork_team as team')->leftJoin('users as user', 'user.id', '=', 'team.user_id')->select('user.id', 'user.username', 'user.name', 'team.type_id', 'team.supervisor_qty', 'team.researcher_qty', 'team.auditor_qty')->where('project_id', $projectId)->get(),
            'team_rank_items' => DB::table('project_team_rank_item')->select('type_id', DB::raw('COUNT(type_id) as qty'))->where('project_id', $projectId)->groupBy('type_id')->get(),
            'project_equipments' => DB::table('project_equipments as pe')->leftJoin('equipments as e', 'e.id', '=', 'pe.equipment_id')
                ->select('e.type_id', DB::raw('MAX(pe.qty) as qty'), DB::raw('MAX(pe.price) as price'))->where('project_id', $projectId)->groupBy('e.type_id')->get(),
        ];

        return view($this->blade_path, $compact);
    }

    public function createFieldworkTeam(Request $request)
    {
        $financial_bid_estimate = ProjectFinancialEstimate::where("project_id", $request['project_id'])->first();
        $researcher_qty = $financial_bid_estimate->researcher_qty;
        $supervisor_qty = $financial_bid_estimate->supervisor_qty;
        $auditor_qty = $financial_bid_estimate->auditor_qty;

        if (! empty($request['user-checkbox'])) {
            if ($request['is_tour'] == 'true') {
                $rowNo = count($request['user-checkbox']);
                for ($i = 0; $i < $rowNo; $i++) {
                    $insertion = [
                        'user_id' => $request['user-checkbox'][$i],
                        'type_id' => $request['type_id'],
                        'city_id' => $request['city_id'][$request['user-checkbox'][$i]],
                        'project_id' => $request['project_id'],
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')
                    ];

                    ProjectExploreTour::updateOrCreate(['project_id' => $request['project_id']], $insertion);
                }
            } else {
                $rowNo = count($request['user-checkbox']);
                if ($request['type_id'] == 1 && $request['project_type_id'] != 9) {
                    $totalSuperQty = 0;
                    $totalReseaQty = 0;
                    for ($i = 0; $i < $rowNo; $i++) {
                        if ($request['supervisor-' . $request['user-checkbox'][$i]] == 0 || $request['supervisor-' . $request['user-checkbox'][$i]] > $supervisor_qty) {
                            return back()->with('error', trans('إجمالي عدد المشرفين لا يتعدى ' . $supervisor_qty));
                            exit();
                        } else {
                            $totalSuperQty += $request['supervisor-' . $request['user-checkbox'][$i]];
                        }
                        if ($request['researcher-' . $request['user-checkbox'][$i]] == 0 || $request['researcher-' . $request['user-checkbox'][$i]] > $researcher_qty) {
                            return back()->with('error', trans('إجمالي عدد الباحثين لا يتعدى ' . $researcher_qty));
                            exit();
                        } else {
                            $totalReseaQty += $request['researcher-' . $request['user-checkbox'][$i]];
                        }
                    }
                    if ($totalSuperQty > $supervisor_qty || $totalReseaQty > $researcher_qty) {
                        return back()->with('error', trans('إجمالي عدد الكادر لا يتعدى ' . $researcher_qty));
                        exit();
                    }

                    $financial_bid_estimate = DB::table('project_fieldwork_team')->select(DB::raw('SUM(supervisor_qty) as supervisorQty'), DB::raw('SUM(researcher_qty) as researcherQty'))->where('project_id', $request['project_id'])->first();
                    $totalSuperQty += $financial_bid_estimate->supervisorQty;
                    $totalReseaQty += $financial_bid_estimate->researcherQty;
                    if ($totalSuperQty > $supervisor_qty || $totalReseaQty > $researcher_qty) {
                        return back()->with('error', trans('إجمالي عدد الكادر لا يتعدى ' . $researcher_qty));
                        exit();
                    }
                } elseif ($request['project_type_id'] != 9 && $request['project_type_id'] != 10) {
                    $totalAuditorQty = 0;
                    for ($i = 0; $i < $rowNo; $i++) {
                        if ($request['auditor-' . $request['user-checkbox'][$i]] == 0 || $request['auditor-' . $request['user-checkbox'][$i]] > $auditor_qty) {
                            return back()->with('error', trans('إجمالي عدد مراقبي التدقيق لا يتعدى ' . $auditor_qty));
                            exit();
                        } else {
                            $totalAuditorQty += $request['auditor-' . $request['user-checkbox'][$i]];
                        }
                    }
                    if ($totalAuditorQty > $auditor_qty) {
                        return back()->with('error', trans('إجمالي عدد الكادر لا يتعدى ' . $auditor_qty));
                        exit();
                    }

                    $financial_bid_estimate = DB::table('project_fieldwork_team')->select(DB::raw('SUM(auditor_qty) as observerAuditQty'))->where('project_id', $request['project_id'])->first();
                    $totalAuditorQty += $financial_bid_estimate->observerAuditQty;
                    if ($totalAuditorQty > $auditor_qty) {
                        return back()->with('error', trans('إجمالي عدد الكادر لا يتعدى ' . $auditor_qty));
                        exit();
                    }
                }

                for ($i = 0; $i < $rowNo; $i++) {
                    $insertion = [
                        'user_id' => $request['user-checkbox'][$i],
                        'type_id' => $request['type_id'],
                        'project_id' => $request['project_id'],
                        'supervisor_qty' => $request['supervisor-' . $request['user-checkbox'][$i]] ?? 0,
                        'researcher_qty' => $request['researcher-' . $request['user-checkbox'][$i]] ?? 0,
                        'auditor_qty' => $request['auditor-' . $request['user-checkbox'][$i]] ?? 0,
                        'inspector_qty' => $request['project_type_id'] == 10 ? $request['user-checkbox'][$i] : 0,
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')
                    ];

                    if ($request['type_id'] == 1 && $request['project_type_id'] != 9) {
                        $this->COMMON_HELPER->handleCaptureTransaction($request, 9, '0', $request['user-checkbox'][$i]);
                    } elseif ($request['type_id'] == 2) {
                        $this->COMMON_HELPER->handleCaptureTransaction($request, 10, '0', $request['user-checkbox'][$i]);
                    }

                    ProjectFieldworkTeam::create($insertion);
                }
            }

            return back()->with('success', trans('site.mission_completed'));
        }
    }

    public function handOverTask(Request $request)
    {
        if ($request['type_id'] == '10') {
            $status = Project::find($request['project_id'])->status_id;
            $mailData = [
                'project_title' => Project::find($request['project_id'])->title,
                'route' => url('/inspectors/' . $request['project_id'] . '/edit/' . $status),
                'reminder' => "no"
            ];
            $email = User::where('id', $request['inspectorId'])->first()->email;
            Mail::to($email)->send(new ProjectTransaction($mailData));

            $params = [Crypt::encrypt($request['project_id']), Crypt::encrypt($request['inspectorId'])];
            $mailDataContract = [
                'route' => route('team-member-contract', $params),
                'label' => __('project.contract_details'),
            ];
            Mail::to($email)->send(new ApproveTeamMembers($mailDataContract));

            ProjectContracts::create([
                'project_id' => $request['project_id'],
                'type_id' => 5,
                'user_id' => $request['inspectorId'],
                'send_date' => date('Y-m-d'),
            ]);

            ProjectFinancialEstimate::updateOrCreate(['project_id' => $request['project_id']], ['inspector_visit_date' => $request['inspector_visit_date']]);
            $this->COMMON_HELPER->changeProjectStatus($request, 10);
            $this->COMMON_HELPER->handleCaptureTransaction($request, 24, '1');
            $this->COMMON_HELPER->handleCaptureTransaction($request, 25, '0', $request['inspectorId']);
            return Redirect::to(url('/' . Auth::user()->roles[0]->name . '/projects'))->with('success', trans('site.mission_completed')); // redirect
        } else if ($request['type_id'] == '12') {
            if ($request->is_tour == 'true') {
                $email = User::findOrFail($request['observerID'])->email;
                $projectTitle = Project::find($request['project_id'])->title;
                $route = url('/observer/tour/' . $request['project_id']);
                $reminder = "no";
                ProjectExploreTour::where('project_id', $request['project_id'])->update(['is_fieldwork_done' => '1']);
                Mail::to($email)->send(new PET($projectTitle, $route, $reminder));
                return Redirect::to(url('/' . Auth::user()->roles[0]->name . '/projects/tour'))->with('success', trans('site.mission_completed')); // redirect
            } else {
                $this->COMMON_HELPER->changeProjectStatus($request, 6);
                $this->COMMON_HELPER->handleCaptureTransaction($request, 7, '1');
                return Redirect::to(url('/' . Auth::user()->roles[0]->name . '/projects'))->with('success', trans('site.mission_completed')); // redirect
            }
        } else if ($request['type_id'] == '9') {
            $this->COMMON_HELPER->handleCaptureTransaction($request, 7, '1');
            $this->COMMON_HELPER->handleCaptureTransaction($request, 21, '0', $request['observerID']);
            $this->COMMON_HELPER->changeProjectStatus($request, 6);

            $email = User::findOrFail($request['observerID'])->email;
            $params = [Crypt::encrypt($request['project_id']), Crypt::encrypt($request['observerID'])];
            $mailData = [
                'route' => route('team-member-contract', $params),
                'label' => __('project.contract_details'),
            ];
            Mail::to($email)->send(new ApproveTeamMembers($mailData));
            ProjectContracts::create([
                'project_id' => $request['project_id'],
                'type_id' => 5,
                'user_id' => $request['observerID'],
                'send_date' => date('Y-m-d'),
            ]);

            return Redirect::to(url('/' . Auth::user()->roles[0]->name . '/projects'))->with('success', trans('site.mission_completed')); // redirect
        } else {
            if ($request->is_tour == 'true') {
                $email = User::findOrFail($request['observerID'])->email;
                $projectTitle = Project::find($request['project_id'])->title;
                $route = url('/observer/tour/' . $request['project_id']);
                $reminder = "no";
                ProjectExploreTour::where('project_id', $request['project_id'])->update(['is_fieldwork_done' => '1']);
                Mail::to($email)->send(new PET($projectTitle, $route, $reminder));
                return Redirect::to(url('/' . Auth::user()->roles[0]->name . '/projects/tour'))->with('success', trans('site.mission_completed')); // redirect
            } else {
                $this->COMMON_HELPER->changeProjectStatus($request, 6);
                $this->COMMON_HELPER->handleCaptureTransaction($request, 7, '1');
                return Redirect::to(url('/' . Auth::user()->roles[0]->name . '/projects'))->with('success', trans('site.mission_completed')); // redirect
            }
        }
    }

    public function destroy(Request $request, $projectId, $teamMemeberId, $is_tour = null)
    {
        if ($is_tour == 'true') {
            ProjectExploreTour::where('project_id', $projectId)->where('user_id', $teamMemeberId)->delete();
        } else {
            ProjectFieldworkTeam::where('project_id', $projectId)->where('user_id', $teamMemeberId)->delete();
            ProjectTransactionHistory::where('project_id', $projectId)->where('user_id', $teamMemeberId)->where('status_id', '9')->orwhere('status_id', '10')->delete();
        }

        return $this->index($request);
    }

    public function startField(Request $request)
    {
        $this->COMMON_HELPER->changeProjectStatus($request, 11);
        $users = User::has('roles')->whereNotIn('id', [6, 7])->get();
        $mailData = [
            'project_title' => $request['project_title'],
            'route' => url('/'),
        ];

        Mail::to($users)->send(new FieldworkStarted($mailData));
        // Database Notification
        $FieldWorkNotification = [
            'msg' => config('custom.FieldWorkNotificationStart') . " (" . $request['project_title'] . ").",
            'project_id' => $request['project_id']
        ];

        Notification::send($users, new FieldWorkNotification($FieldWorkNotification));
        $this->COMMON_HELPER->handleCaptureTransaction($request, 18, '1');
        $this->COMMON_HELPER->handleCaptureTransaction($request, 19, '0', 3);
        $arr = array('msg' => __('site.mission_completed'), 'status' => true);
        return response()->json($arr);
    }

    public function uploadExploreSurvey(Request $request)
    {
        $uploads = "";
        $target = storage_path() . '/app/public/uploads/projects';
        $explourFiles = ProjectExploreTour::select('explore_tour')->where('project_id', $request['project_id'])->first()->explore_tour;
        $getFiles = (isset($explourFiles) && ! is_null($explourFiles)) ? $explourFiles : "";

        if ($request->hasFile('file')) :
            $file = $request['file'];
            $source = $file->getClientOriginalName();
            $file->move($target, $source);
            $ext = $file->getClientOriginalExtension();
            $out = storage_path() . '/app/public/uploads/projects/' . uniqid(date('t-M')) . "." . $ext;
            $filePath = stristr($out, "uploads/");
            if ($getFiles == "") {
                $uploads .= $filePath;
            } else {
                $uploads .= $filePath . "&&" . $getFiles;
            }
            rename(storage_path() . '/app/public/uploads/projects/' . $source, $out);
        endif;

        ProjectExploreTour::where('project_id', $request['project_id'])->update(['explore_tour' => $uploads]);
        $arr = array('msg' => __('site.mission_completed'), 'status' => true);
        return response()->json($arr);
    }

    public function removeExploreSurvey(Request $request)
    {
        $explourFiles = ProjectExploreTour::select('explore_tour')->where('project_id', $request['project_id'])->first()->explore_tour;
        $getFiles = (isset($explourFiles) && ! is_null($explourFiles)) ? $explourFiles : "";
        if ($request->has('oldFile')) :
            if (str_contains($getFiles, "&&")) {
                $chunks = explode('&&', $getFiles);
                unset($chunks[array_search($request['oldFile'], $chunks)]);
                $newFiles = join('&&', $chunks);
            } else {
                $newFiles = NULL;
            }
        endif;

        ProjectExploreTour::where('project_id', $request['project_id'])
            ->update(['explore_tour' => $newFiles]);
        $arr = array('msg' => __('site.mission_completed'), 'status' => true);
        return response()->json($arr);
    }

    public function updateIsEspecialTrainingNeeded($project_id, $is_espeical_training_needed)
    {
        ProjectFinancialEstimate::where(['project_id' => $project_id])->update([
            'is_espeical_training_needed' => $is_espeical_training_needed == 'true' ? '1' : '0',
        ]);
    }
}