<?php

namespace App\Http\Controllers\Backoffice;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\ProjectStatus;
use App\Models\ProjectSurveyAccounts;
use App\Traits\Functions;
use Illuminate\Http\Request;
use App\Models\ProjectTransactionHistory;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;

class CreatorController extends Controller
{
    protected $model;
    protected $resource;
    protected $trans_file;
    protected $blade_path;
    protected $COMMON_HELPER;
    use Functions;

    public function __construct(Project $model)
    {
        $this->middleware('seen', ['only' => ['edit']]);
        $this->model = $model;
        $this->resource = 'creators';
        $this->blade_path = 'backoffice.creator';
        $this->trans_file = 'creator';
        $this->COMMON_HELPER = app('App\Helpers\Common');
    }

    public function index()
    {
        $this->blade_path = 'backoffice.creator.index';
        $baseQuery = $this->model::select('projects.id', 'projects.logo', 'projects.title', 'projects.building_count', 'projects.cases_count', 'projects.start_date', 'projects.end_date', 'projects.status_id', 'projects.progress_bar', 'projects.created_at')
            ->leftJoin('project_transaction_history as pth', 'pth.project_id', '=', 'projects.id')->whereIn('projects.type_id', [10, 12])->where('pth.status_id', 23)->where('pth.is_done', '0');
        $compact = [
            'rows' => $baseQuery->latest()->paginate(12),
            'trans_file' => $this->trans_file,
            'resource' => $this->resource,
            'status' => ProjectStatus::select('id', 'title', 'trans')->get(),
            'counter' => $baseQuery->count(),
        ];

        return view($this->blade_path, $compact);
    }

    public function edit(Request $request, $projectId)
    {
        $projectCurrentStatus = Project::select('status_id AS status')->where('id', $projectId)->first()->status;
        if (isset($request['status']) && $request['status'] == $projectCurrentStatus) :
            $this->blade_path = 'backoffice.creator.edit';
        elseif (! isset($request['status'])) :
            $this->blade_path = 'backoffice.creator.edit';
        else :
            return redirect('/creator/projects');
        endif;

        $query = $this->model::with('status', 'type', 'region', 'customer', 'localDevelopment')->find($projectId);
        $compact = [
            'trans_file' => $this->trans_file,
            'resource' => $this->resource,
            'row' => $query,
            'users' => ProjectTransactionHistory::with('user')->where('project_id', $projectId)->groupBy('user_id')->get(),
            'survey_accounts' => ProjectSurveyAccounts::where("project_id", $projectId)->first(),
        ];

        return view($this->blade_path, $compact);
    }

    public function createSurveyAccount(Request $request)
    {
        $request["type_id"] != '' ? $insertion = [
            "admin_email" => $request["email"],
            "admin_password" => $request["password"],
            'project_id' => $request["project_id"],
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ] : $insertion = [
                'url' => $request["url"],
                'project_id' => $request["project_id"],
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];

        ProjectSurveyAccounts::updateOrCreate(['project_id' => $request["project_id"]], $insertion);
        return back()->with('success', trans('site.mission_completed'));
    }

    public function handOverTask(Request $request)
    {
        $this->COMMON_HELPER->handleCaptureTransaction($request, 23, '1');
        return Redirect::to(url('/' . Auth::user()->roles[0]->name . '/projects'))->with('success', trans('site.mission_finished')); // redirect
    }
}