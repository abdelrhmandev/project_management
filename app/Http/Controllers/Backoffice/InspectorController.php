<?php

namespace App\Http\Controllers\Backoffice;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\User;
use App\Models\ProjectStatus;
use App\Models\ProjectType;
use App\Models\ProjectFinancialEstimate;
use App\Models\Region;
use App\Models\Customer;
use App\Models\Equipment;
use App\Models\ProjectSurveyAccounts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use App\Models\ProjectFieldworkTeam;
use Illuminate\Support\Facades\DB;
use App\Models\ProjectEquipmentsFile;
use App\Models\ProjectEmpowerCharity;
use App\Models\ProjectTransactionHistory;

class InspectorController extends Controller
{
    protected $model;
    protected $resource;
    protected $trans_file;
    protected $blade_path;
    protected $COMMON_HELPER;

    public function __construct(Project $model)
    {
        $this->middleware('seen', ['only'=>['edit']]);
        $this->model            = $model;
        $this->resource         = 'inspectors';
        $this->blade_path       = 'backoffice.inspector';
        $this->trans_file       = 'project';
        $this->COMMON_HELPER    = app('App\Helpers\Common');
    }

    public function index()
    {
        $this->blade_path = 'backoffice.inspector.index';
        $compact                              = [
            'rows'                            => $this->model::select('id', 'logo', 'title', 'building_count', 'cases_count', 'start_date', 'end_date', 'status_id', 'progress_bar')->where('type_id', 10)->where('status_id', '>=', 10)->latest()->paginate(12),
            'trans_file'                      => $this->trans_file,
            'resource'                        => $this->resource,
            'status'                          => ProjectStatus::select('id', 'title', 'trans')->get(),
            'types'                           => ProjectType::select('id', 'title')->get(),
            'regions'                         => Region::select('id', 'title')->get(),
            'customers'                       => Customer::select('id', 'title')->get(),
            'equipments'                      => Equipment::get(),
            'task_type'                       => 'correction',
            'counter'                         => $this->model::select('id', 'logo', 'title', 'building_count', 'cases_count', 'start_date', 'end_date', 'status_id', 'progress_bar')->count(),
        ];

        return view($this->blade_path, $compact);
    }

    public function edit(Request $request,$projectId)
    {
        $projectCurrentStatus = Project::select('status_id AS status')->where('id',$projectId)->first()->status;
        if(isset($request['status']) && $request['status'] == $projectCurrentStatus):
            $this->blade_path = 'backoffice.inspector.edit';
            elseif(!isset($request['status'])):
                $this->blade_path = 'backoffice.inspector.edit';
            else:
            return redirect('/inspector/projects');
        endif;
        
        $compact                              = [
            'trans_file'                      => $this->trans_file,
            'resource'                        => $this->resource,
            'row'                             => Project::with('status', 'type', 'region', 'customer', 'localDevelopment')->find($projectId),
            'users' => ProjectTransactionHistory::with('user')->where('project_id', $projectId)->groupBy('user_id')->get(),
            'project_admin'                   => User::where('id', 2)->first(),
            'financial_bid_estimate'          => ProjectFinancialEstimate::where("project_id", $projectId)->first(),
            'survey_accounts'                 => ProjectSurveyAccounts::where("project_id", $projectId)->first(),
        ];

        return view($this->blade_path, $compact);
    }

    public function handOverTask(Request $request)
    {        
        $insertions = [
            'status_id'     => '12',
            'updated_at'    => date('Y-m-d H:i:s'),
        ];
        $this->COMMON_HELPER->handleCaptureTransaction($request, 25, '1');
        $project_fieldwork_teams = ProjectFieldworkTeam::select('user_id')->where("project_id", $request['project_id'])->where("type_id", 6)->get();    
        foreach ($project_fieldwork_teams as $project_fieldwork_team) {
            $this->COMMON_HELPER->handleCaptureTransaction($request, 20, '0', $project_fieldwork_team->user_id);
        }
        $inspectors_qtyCounts = ProjectFinancialEstimate::select('project_id','inspector_qty')
        ->where("project_id", $request['project_id'])->value('inspector_qty');        
        $inspector_WithHsitroy =  ProjectTransactionHistory::where("project_id", $request['project_id'])
        ->where("status_id", 25)
        ->where("is_done", '1')
        ->count();             
        if($inspectors_qtyCounts == $inspector_WithHsitroy){
              Project::updateOrCreate(['id' => $request["project_id"]], $insertions);
        }   
        return Redirect::to(url('/' . Auth::user()->roles[0]->name . '/projects'))->with('success', trans('site.mission_finished'));  // redirect
    }

    public function _handoverProjects()
    {
        $row = DB::table('project_fieldwork_team as pf')
            ->leftJoin('projects as project', 'pf.project_id', '=', 'project.id')
            ->leftJoin('project_financial_estimate as bid', 'bid.project_id', '=', 'project.id')
            ->select('project.id AS PID', 'project.logo', 'project.title', 'project.cases_count', 'project.start_date', 'project.end_date', 'project.status_id', 'project.progress_bar', 'project.created_at')
            ->where('project.status_id', '=', 12)->where('pf.user_id', Auth::user()->id);

        $compact = [
            'rows'          => $row->latest()->paginate(12),
            'trans_file'    => $this->trans_file,
            'resource'      => $this->resource,
            'status'        => ProjectStatus::select('id', 'title', 'trans')->get(),
            'types'         => ProjectType::select('id', 'title')->get(),
            'regions'       => Region::select('id', 'title')->get(),
            'customers'     => Customer::select('id', 'title')->get(),
            'equipments'    => Equipment::get(),
            'counter'       => $row->count(),
        ];

        return view('backoffice.inspector.handoverprojects', $compact);
    }

    public static function _handover($projectId)
    {
        $compact  = [
            'row'    => Project::with('status', 'type', 'region', 'customer', 'localDevelopment')->find($projectId),
            'project_equipments_files'  => ProjectEquipmentsFile::where('project_id', $projectId)->get(),
            'project_equipments'   => DB::table('project_equipments as pe')->leftJoin('equipments as e', 'e.id', '=', 'pe.equipment_id')
                ->select('pe.id', 'pe.qty', 'pe.price', 'pe.equipment_type', 'e.title', 'pe.return_equipment_receipt', 'pe.equipment_id')->where('project_id', $projectId)->get(),
            'project_empower_charity'         => ProjectEmpowerCharity::where('project_id', $projectId)->first(),
            'project_transaction_history'     => ProjectTransactionHistory::where("project_id", $projectId)->where("status_id", 8)->first(),
        ];

        return view('backoffice.inspector.handover', $compact);
    }

    public function _handoverTask(Request $request)
    {
        $project_equipments =  DB::table('project_equipments as pe')
            ->leftJoin('equipments as e', 'e.id', '=', 'pe.equipment_id')
            ->select('pe.id', 'pe.qty', 'pe.price', 'e.type_id', 'e.title', 'pe.return_equipment_receipt', 'pe.equipment_id')
            ->where("project_id", $request->project_id)->count();

        if (count($request->equipment_id)  == $project_equipments) {
            Project::where('id', $request['project_id'])->update(['status_id' => 18]);
            $this->COMMON_HELPER->handleCaptureTransaction($request, 20, '1');
            return Redirect::to(url('/' . Auth::user()->roles[0]->name . '/handover/projects'))->with('success', trans('site.mission_finished'));  // redirect
        } else {
            return back()->with('error', 'يجب توفير كل التجهزيات الفرعيه المتاحه حتي يمكنك  إنهاء و تسليم المهمة');
        }
    }

    public function destroy()
    {
    }
}
