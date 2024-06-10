<?php

namespace App\Http\Controllers\Backoffice;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\ProjectEmpowerCharity;
use App\Models\User;
use App\Models\ProjectLocalDevelopment;
use App\Models\ProjectFinancialEstimate;
use App\Models\ProjectFamilyDevelopment;
use App\Models\ProjectTransactionHistory;
use App\Traits\UploadAble;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use App\Models\ProjectTrainingType;

class FinanceController extends Controller
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
        $this->resource = 'design';
        $this->blade_path = 'backoffice.design';
        $this->trans_file = 'project';
        $this->COMMON_HELPER = app('App\Helpers\Common');
    }

    public function index()
    {
        $this->blade_path = 'backoffice.finance.index';
        $compact = [];
        return view($this->blade_path, $compact);
    }

    public function projects()
    {
        $this->blade_path = 'backoffice.finance.projects';
        $row = $this->model::with('status')->where('status_id', 20);

        $compact = [
            'rows' => $row->latest()->paginate(12),
            'trans_file' => $this->trans_file,
            'resource' => $this->resource,
            'counter' => $row->count(),
            'taskType' => 'none',
            'list' => 'قائمه المشاريع',
            'placeholder' => 'إسم المشروع',
            'title' => 'المشاريع',
        ];

        return view($this->blade_path, $compact);
    }

    public function followup($projectId)
    {
        $this->blade_path = 'backoffice.finance.followup';
        $query = $this->model::with('status', 'type', 'region', 'customer', 'localDevelopment')->find($projectId);
        $compact = [
            'trans_file' => $this->trans_file,
            'resource' => $this->resource,
            'row' => $query,
            'users' => ProjectTransactionHistory::with('user')->where('project_id', $projectId)->groupBy('user_id')->get(),
            'project_admin' => User::where('id', 2)->first(),
            'training' => ProjectTrainingType::where('project_id', $projectId)->first(),
            'project_empower_charity' => ProjectEmpowerCharity::where('project_id', $projectId)->first(),
            'financial_bid_estimate' => ProjectFinancialEstimate::where('project_id', $projectId)->first(),
            'project_family_development' => ProjectFamilyDevelopment::where('project_id', $projectId)->first(),
            'project_local_development' => ProjectLocalDevelopment::where('project_id', $projectId)->first(),
        ];

        return view($this->blade_path, $compact);
    }

    public function uploadFinanceFile(Request $request)
    {
        $uploads = "";
        $target = storage_path() . '/app/public/uploads/projects';
        $file = ProjectFinancialEstimate::select('finance_file')->where('project_id', $request['project_id'])->first()->finance_file;
        $getFiles = (isset($file) && ! is_null($file)) ? $file : "";

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
        ProjectFinancialEstimate::where('project_id', $request['project_id'])->update(['finance_file' => $uploads]);
        $arr = array('msg' => __('site.mission_completed'), 'status' => true);
        return response()->json($arr);
    }

    public function removeFinanceFile(Request $request)
    {
        ProjectFinancialEstimate::where('project_id', $request['project_id'])->update(['finance_file' => '']);
        $arr = array('msg' => __('site.mission_completed'), 'status' => true);
        return response()->json($arr);
    }

    public function handOverTask(Request $request)
    {
        $file = ProjectFinancialEstimate::select('finance_file')->where('project_id', $request['project_id'])->first()->finance_file;
        if (empty($file)) {
            return back()->with('error', 'يجب رفع ملف العرض المالي');
        } else {
            $this->COMMON_HELPER->changeProjectStatus($request, 3);
            $this->COMMON_HELPER->handleCaptureTransaction($request, 27, '1');
            $this->COMMON_HELPER->handleCaptureTransaction($request, 4, '0', 2);
        }

        return Redirect::to(url('/' . Auth::user()->roles[0]->name . '/projects'))->with('success', trans('site.mission_finished')); // redirect
    }
}