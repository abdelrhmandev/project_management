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
use App\Models\ProjectKashefAccounts;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\ProjectFamilyDevelopment;
use App\Models\ProjectLocalDevelopment;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use App\Models\ProjectEmpowerCharity;
use App\Models\ProjectTransactionHistory;

class ItController extends Controller
{
    protected $model;
    protected $resource;
    protected $trans_file;
    protected $blade_path;
    protected $COMMON_HELPER;

    public function __construct(Project $model)
    {
        $this->middleware('seen', ['only' => ['edit']]);
        $this->model = $model;
        $this->resource = 'its';
        $this->blade_path = 'backoffice.it';
        $this->trans_file = 'it';
        $this->COMMON_HELPER = app('App\Helpers\Common');
    }

    public function index()
    {
        $this->blade_path = 'backoffice.it.index';
        $baseQuery = DB::table('projects as p')->select('p.id', 'p.logo', 'p.title', 'p.cases_count', 'p.start_date', 'p.end_date', 'p.status_id', 'p.progress_bar', 'p.created_at')->leftJoin('project_kashef_accounts as k', 'k.project_id', '=', 'p.id')
            ->where('p.status_id', '>=', 4)->where('p.type_id', '!=', 10)->where('p.type_id', '!=', 12)->whereNULL('k.project_id');

        $compact = [
            'rows' => $baseQuery->latest()->paginate(12),
            'trans_file' => $this->trans_file,
            'resource' => $this->resource,
            'status' => ProjectStatus::select('id', 'title', 'trans')->get(),
            'types' => ProjectType::select('id', 'title')->get(),
            'regions' => Region::select('id', 'title')->get(),
            'customers' => Customer::select('id', 'title')->get(),
            'equipments' => Equipment::get(),
            'counter' => $baseQuery->count(),
        ];

        return view($this->blade_path, $compact);
    }

    public function edit(Request $request, $projectId)
    {
        $projectCurrentStatus = Project::select('status_id AS status')->where('id', $projectId)->first()->status;
        if (isset($request['status']) && $request['status'] == $projectCurrentStatus) :
            $this->blade_path = 'backoffice.it.edit';
        elseif (! isset($request['status'])) :
            $this->blade_path = 'backoffice.it.edit';
        else :
            return redirect('/it/projects');
        endif;

        $query = $this->model::with('status', 'type', 'region', 'customer', 'localDevelopment')->find($projectId);
        $compact = [
            'trans_file' => $this->trans_file,
            'resource' => $this->resource,
            'row' => $query,
            'users' => ProjectTransactionHistory::with('user')->where('project_id', $projectId)->groupBy('user_id')->get(),
            'status' => ProjectStatus::select('id', 'title', 'trans')->get(),
            'types' => ProjectType::select('id', 'title')->get(),
            'regions' => Region::select('id', 'title')->get(),
            'customers' => Customer::select('id', 'title')->get(),
            'equipments' => Equipment::get(),
            'equipment_type' => EquipmentType::get(),
            'team_ranks' => TeamRankType::get(),
            'kashef_accounts' => ProjectKashefAccounts::where("project_id", $projectId)->first(),
            'financial_bid_estimate' => ProjectFinancialEstimate::where("project_id", $projectId)->get(),
            'project_family_development' => ProjectFamilyDevelopment::where("project_id", $projectId)->first(),
            'project_local_development' => ProjectLocalDevelopment::where("project_id", $projectId)->first(),
            'project_empower_charity' => ProjectEmpowerCharity::where('project_id', $projectId)->first(),
            'team_rank_items' => DB::table('project_team_rank_item')->select('type_id', DB::raw('COUNT(type_id) as qty'))->where('project_id', $projectId)->groupBy('type_id')->get(),
            'project_equipments' => DB::table('project_equipments as pe')->leftJoin('equipments as e', 'e.id', '=', 'pe.equipment_id')
                ->select('e.type_id', DB::raw('MAX(pe.qty) as qty'), DB::raw('MAX(pe.price) as price'))->where('project_id', $projectId)->groupBy('e.type_id')->get(),
        ];

        return view($this->blade_path, $compact);
    }

    public function createKashefAccount(Request $request)
    {
        $request["type_id"] != '' ? $insertion = [
            $request["type_id"] . "_email" => $request["email"],
            $request["type_id"] . "_password" => $request["password"],
            'project_id' => $request["project_id"],
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ] : $insertion = [
                'url' => $request["url"],
                'project_id' => $request["project_id"],
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];

        ProjectKashefAccounts::updateOrCreate(['project_id' => $request["project_id"]], $insertion);
        return back()->with('success', trans('site.mission_completed'));
    }

    public function handOverTask(Request $request)
    {
        $kashef = ProjectKashefAccounts::where("project_id", $request["project_id"])->whereNotNull("url")->whereNotNull("admin_email")->whereNotNull("admin_password")->count();
        if ($kashef == 0) {
            return back()->with('error', trans('رابط برنامج وحساب الإدارة الخاص ببرنامج كاشف غير متوفر'));
            exit();
        }
        $this->COMMON_HELPER->handleCaptureTransaction($request, 6, '1');
        return Redirect::to(url('/' . Auth::user()->roles[0]->name . '/projects'))->with('success', trans('site.mission_finished')); // redirect
    }
}