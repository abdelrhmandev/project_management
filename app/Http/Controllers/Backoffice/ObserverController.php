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
use App\Models\ProjectEmpowerCharity;
use App\Models\TeamRankType;
use App\Models\ProjectFinancialEstimate;
use App\Models\ProjectFieldworkTeam;
use App\Models\AttractingTeam;
use App\Models\ProjectContracts;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\ProjectObserverTeam;
use App\Models\ProjectAuditorTeam;
use App\Models\ProjectTeamRankItem;
use App\Models\ProjectContractResearchItem;
use App\Models\DeactivateKashefAccounts as DKA;
use App\Mail\ApproveTeamMembers;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Crypt;
use ArPHP\I18N\Arabic;
use App\Traits\Functions;
use App\Models\ProjectFamilyDevelopment;
use App\Models\ProjectLocalDevelopment;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\ProjectTourFile;
use App\Traits\UploadAble;
use App\Models\ProjectExploreTour;
use App\Models\ProjectTrainingDetail;
use App\Models\ProjectEquipmentsDiv;
use Shuchkin\SimpleXLSX;
use Exception;
use Illuminate\Support\Facades\Redirect;
use App\Models\ProjectTransactionHistory;
use Carbon\Carbon;
use DataTables;
use App\Mail\ProjectEndTour;
use App\Mail\VirtualCardMail;
use App\Mail\KaderChange;

class ObserverController extends Controller
{
    protected $model;
    protected $resource;
    protected $trans_file;
    protected $blade_path;
    protected $COMMON_HELPER;
    private static $operationEmails;
    use Functions;
    use UploadAble;

    public function __construct(Project $model)
    {
        $this->middleware('seen', ['only' => ['edit']]);
        $this->model = $model;
        $this->resource = 'observers';
        $this->blade_path = 'backoffice.observer';
        $this->trans_file = 'observer';
        $this->COMMON_HELPER = app('App\Helpers\Common');
        static::$operationEmails = [];
    }

    public function index($taskType = null)
    {
        $compact = [];
        $this->blade_path = 'backoffice.observer.index';
        if ($taskType == 'tour') {
            $row = DB::table('project_financial_estimate as pf')
                ->leftJoin('projects as project', 'pf.project_id', '=', 'project.id')
                ->leftJoin('project_explore_tour as tour', 'tour.project_id', '=', 'project.id')
                ->select('project.id', 'project.logo', 'project.title', 'project.cases_count', 'project.start_date', 'project.end_date', 'project.status_id', 'project.progress_bar', 'project.created_at')
                ->where('pf.is_explore_tour_required', '1')->where('tour.is_fieldwork_done', '1')->where('tour.is_observer_done', '0')->where('tour.user_id', Auth::user()->id);

            $compact = [
                'rows' => $row->latest()->paginate(12),
                'trans_file' => $this->trans_file,
                'resource' => $this->resource,
                'status' => ProjectStatus::select('id', 'title', 'trans')->get(),
                'equipments' => Equipment::get(),
                'counter' => $row->count(),
                'taskType' => 'tour',
                'list' => 'قائمه الجولات',
                'placeholder' => 'إسم الجوله',
                'title' => 'جولات',
            ];
        } elseif ($taskType == 'correction') {
            $row = DB::table('project_fieldwork_team as pf')
                ->leftJoin('projects as project', 'pf.project_id', '=', 'project.id')
                ->select('project.id', 'project.logo', 'project.title', 'project.cases_count', 'project.start_date', 'project.end_date', 'project.status_id', 'project.progress_bar', 'project.created_at')
                ->where('pf.user_id', Auth::user()->id)->where('is_training_correction', '1');

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
                'taskType' => 'approval',
                'list' => 'قائمه المشاريع للمعالجة',
                'placeholder' => 'إسم المشروع',
                'title' => 'المشاريع',
            ];
        } else {
            $row = DB::table('project_fieldwork_team as pf')
                ->leftJoin('projects as project', 'pf.project_id', '=', DB::raw('project.id and pf.user_id = ' . Auth::user()->id))
                ->leftJoin('project_financial_estimate as bid', 'bid.project_id', '=', 'project.id')
                ->leftJoin('project_transaction_history as pth', 'pth.project_id', '=', 'project.id')
                ->select('project.id', 'project.logo', 'project.title', 'project.cases_count', 'project.start_date', 'project.end_date', 'project.status_id', 'project.progress_bar', 'project.created_at')
                ->whereIN('project.status_id', [6, 8, 9, 10])
                ->whereIN('pth.status_id', [9, 15, 21])
                ->where('pth.is_done', '0')->where('pth.user_id', Auth::user()->id);

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
                'list' => 'قائمه المهام',
                'placeholder' => 'إسم المهمه',
                'title' => 'مهام',
            ];
        }

        return view($this->blade_path, $compact);
    }

    public function indexCorrection()
    {
        $compact = [];
        $this->blade_path = 'backoffice.observer.indexcorrection';
        $row = DB::table('project_fieldwork_team as pf')
            ->leftJoin('projects as project', 'pf.project_id', '=', 'project.id')
            ->leftJoin('project_financial_estimate as bid', 'bid.project_id', '=', 'project.id')
            ->select('project.id', 'project.logo', 'project.title', 'project.cases_count', 'project.start_date', 'project.end_date', 'project.status_id', 'project.progress_bar', 'project.created_at')
            ->where('pf.user_id', Auth::user()->id);
        $compact = [
            'placeholder' => 'إسم المشروع',
            'title' => 'مشاريع',
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

    public static function _projectDivEQ($projectID)
    {
        $q = Project::with('status', 'type', 'region', 'customer', 'localDevelopment')->find($projectID);
        $eq = ProjectEquipmentsDiv::select('title', 'equipments.id AS EQID', 'amount', 'notes')
            ->join('equipments', 'equipments.id', '=', 'project_equipments_division.equipment_id')
            ->groupBy('equipment_id')
            ->where('project_id', $projectID)->where('observer_id', Auth::user()->id)->get();

        $query = ProjectEquipmentsDiv::select('is_agree')
            ->where('project_id', $projectID)->where('observer_id', Auth::user()->id);

        @$exist = $query->exists();
        @$isAgree = $query->first()->is_agree;

        return view('backoffice.observer._divisionEquipments', ['row' => $q, 'eq' => $eq, 'exist' => $exist, 'isAgree' => $isAgree]);
    }

    public static function _projectDivEQInfo(Request $req)
    {
        $eq = ProjectEquipmentsDiv::select('title', 'equipments.id AS EQID', 'amount', 'notes', 'files')
            ->join('equipments', 'equipments.id', '=', 'project_equipments_division.equipment_id')
            ->groupBy('equipment_id')
            ->where('project_id', $req['P'])
            ->where('equipments.id', $req['E'])
            ->where('observer_id', Auth::user()->id)->first();

        return response()->json(['eq' => $eq]);
    }

    public static function _divEqAgreeOrReject(Request $req)
    {
        if ($req->has('agree')) {
            ProjectEquipmentsDiv::where('project_id', $req['project'])
                ->where('observer_id', Auth::user()->id)
                ->update([
                    'is_agree' => '1'
                ]);
            return redirect()->back();
        } elseif ($req->has('send')) {
            $req->validate([
                'reason' => 'required'
            ]);
            ProjectEquipmentsDiv::where('project_id', $req['project'])
                ->where('observer_id', Auth::user()->id)
                ->update([
                    'is_agree' => '0',
                    'rejection_reason' => strip_tags(trim($req['reason'])) ?? NULL
                ]);
            return redirect()->back();
        }
    }

    public function _handoverProjects()
    {
        $row = DB::table('project_fieldwork_team as pf')
            ->leftJoin('projects as project', 'pf.project_id', '=', 'project.id')
            ->leftJoin('project_financial_estimate as bid', 'bid.project_id', '=', 'project.id')
            ->select('project.id AS PID', 'project.logo', 'project.title', 'project.cases_count', 'project.start_date', 'project.end_date', 'project.status_id', 'project.progress_bar', 'project.created_at')
            ->where('project.status_id', '=', 12)
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
        ];

        return view('backoffice.observer.handoverprojects', $compact);
    }

    public static function _handover($projectID)
    {
        $q = Project::with('status', 'type', 'region', 'customer', 'localDevelopment')->find($projectID);
        $eq = ProjectEquipmentsDiv::select('title', 'equipments.id AS EQID', 'amount', 'notes')
            ->join('equipments', 'equipments.id', '=', 'project_equipments_division.equipment_id')
            ->groupBy('equipment_id')
            ->where('project_id', $projectID)->where('observer_id', Auth::user()->id)->get();

        $query = ProjectEquipmentsDiv::where('project_id', $projectID)->where('observer_id', Auth::user()->id);
        $exist = $query->exists();

        $shipFiles = ProjectEquipmentsDiv::select('shipment_files AS SHPF')
            ->where('equipment_type', '1')
            ->where('project_id', $projectID)
            ->where('observer_id', Auth::user()->id)->first();

        $observer = Auth::user()->id;
        $supervisors = DB::table('project_observer_team AS POT')
            ->join('attracting_team AS AT', 'AT.id', '=', 'POT.team_user_id')
            ->select('AT.id AS ID', 'POT.team_user_id AS TUID', 'name', 'enrolled_date', 'accomplished_projects', 'performance_percentage', 'is_good')
            ->where('POT.type_id', 4)
            ->where('POT.project_id', $projectID)
            ->where("superior_id", $observer)
            ->get();


        return view('backoffice.observer.handover', ['row' => $q, 'eq' => $eq, 'exist' => $exist, 'shipFiles' => $shipFiles, 'supervisors' => $supervisors, 'project_admin' => User::where('id', 2)->first()]);
    }

    static public function _eqReturn(Request $req)
    {
        if ($req->has('eqName')) {
            DB::table('project_equipments AS PE')->where('project_id', $req['project'])
                ->where('equipment_type', '1')
                ->whereIn('equipment_id', $req['eqName'])
                ->update([
                    'return_equipment_receipt' => '1'
                ]);

            DB::table('project_equipments AS PE')->where('project_id', $req['project'])
                ->where('equipment_type', '1')
                ->whereNotIn('equipment_id', $req['eqName'])
                ->update([
                    'return_equipment_receipt' => '0'
                ]);

        } else {
            DB::table('project_equipments AS PE')->where('project_id', $req['project'])
                ->where('equipment_type', '1')
                ->update([
                    'return_equipment_receipt' => '0'
                ]);
        }
        return redirect()->back()->with(['successMSG' => 'التغييرات تمت بنجاح']);
    }

    public static function _eqDivShipFiles(Request $req)
    {
        $old = ProjectEquipmentsDiv::select('shipment_files')
            ->where('equipment_type', $req['eqType'])
            ->where('project_id', $req['project'])
            ->where('observer_id', $req['observer']);

        if ($req->hasFile('file')) :
            $target = storage_path() . '/app/public/uploads/projects/division/shipment';
            $source = $req['file']->getClientOriginalName();
            $req['file']->move($target, $source);
            $ext = $req['file']->getClientOriginalExtension();
            $out = storage_path() . "/app/public/uploads/projects/division/shipment/" . uniqid(date('t-M')) . "." . $ext;
            rename(storage_path() . "/app/public/uploads/projects/division/shipment/" . $source, $out);

            if (isset($old->first()->shipment_files) && ! is_null($old->first()->shipment_files)) {
                $files = json_decode($old->first()->shipment_files, true);
                $files['SHPF-' . rand(100, 999)] = stristr($out, "/uploads/");
            } else {
                $files = [];
                $files['SHPF-' . rand(100, 999)] = stristr($out, "/uploads/");
            }

            ProjectEquipmentsDiv::where([
                'equipment_type' => $req['eqType'],
                'project_id' => $req['project'],
                'observer_id' => $req['observer']
            ])->update([
                        'shipment_files' => json_encode($files)
                    ]);
        endif;
    }

    static public function _delShipFiles(Request $req)
    {
        $old = ProjectEquipmentsDiv::select('shipment_files')
            ->where('equipment_type', '1')
            ->where('project_id', $req['P'])
            ->where('observer_id', Auth::user()->id);

        $files = json_decode($old->first()->shipment_files, true);
        unset($files[$req['F']]);
        ProjectEquipmentsDiv::where([
            'equipment_type' => '1',
            'project_id' => $req['P'],
            'observer_id' => Auth::user()->id
        ])->update([
                    'shipment_files' => json_encode($files)
                ]);
    }

    static public function _goodOrNot(Request $req)
    {
        DB::beginTransaction();
        try {
            if ($req['G'] == 'good') :
                ProjectObserverTeam::where('project_id', (int) $req['P'])->where('team_user_id', (int) $req['T'])
                    ->update(['is_good' => '1', 'notes' => NULL, 'equipments' => NULL]);
            else :
                ProjectObserverTeam::where('project_id', (int) $req['P'])->where('team_user_id', (int) $req['T'])
                    ->update(['is_good' => '0',
                        'notes' => strip_tags(trim($req['R'])) ?? NULL,
                        'equipments' => trim(str_ireplace('EQ=', '', $req['E'])) ?? NULL
                    ]);
            endif;
            DB::commit();
            return response()->json(['success' => '<i class="bi bi-check-lg" style="color:lightgreen;font-size:16px;"></i> تمت بنجاح']);
        } catch (\PDOException $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    static public function _endHTask(Request $req)
    {
        ProjectTransactionHistory::where('project_id', $req['project'])
            ->where('user_id', Auth::user()->id)
            ->update([
                'is_done' => '1',
                'updated_at' => DB::raw('NOW()')
            ]);
        return redirect()->back()->with('successMSG', "تم انهاء وتسليم المهمه بنجاح");
    }

    public function _handoverTask(Request $request)
    {
        $project_equipments = DB::table('project_equipments as pe')
            ->leftJoin('equipments as e', 'e.id', '=', 'pe.equipment_id')
            ->select('pe.id', 'pe.qty', 'pe.price', 'e.type_id', 'e.title', 'pe.return_equipment_receipt', 'pe.equipment_id')
            ->where("project_id", $request->project_id)->count();

        if (count($request->equipment_id) == $project_equipments) {
            Project::where('id', $request['project_id'])->update(['status_id' => 18]);
            $this->COMMON_HELPER->handleCaptureTransaction($request, 20, '1');
            return Redirect::to(url('/' . Auth::user()->roles[0]->name . '/handover/projects'))->with('success', trans('site.mission_finished')); // redirect
        } else {
            return back()->with('error', 'يجب توفير كل التجهزيات الفرعيه المتاحه حتي يمكنك  إنهاء و تسليم المهمة');
        }
    }

    public function contractProjects($taskType = null)
    {
        $compact = [];
        $this->blade_path = 'backoffice.observer.contractprojects';
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
                ->where('project.status_id', '>=', 9)
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
            ->where('attracting.type_id', '<>', 3)->where('observer.project_id', $project_id)->where('contract.project_id', $project_id)
            ->whereRaw('(observer.team_user_id IN (select team_user_id from project_observer_team AS sub_observer WHERE sub_observer.superior_id = ' . Auth::user()->id . ')
                OR observer.team_user_id IN (select team_user_id from project_observer_team AS sub_observer WHERE sub_observer.superior_team_id
                IN (select team_user_id from project_observer_team AS sub_observer WHERE sub_observer.superior_id = ' . Auth::user()->id . ')))');

        if ($request->ajax()) {
            return Datatables::of($query->get())->addIndexColumn()->editColumn('contract_url', function ($row) {
                $div = '';
                if ($row->contract_url) {
                    $contract_url = url('contracts/' . $row->contract_url);
                    $div .= '<a href="' . $contract_url . '" class="btn btn-sm btn-flex btn-light-success w-95px">
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
                    <!--end::Svg Icon-->العقد
                    </a>';
                } else {
                    if ($row->approved == 0 && $row->rejection_reason != null) {
                        $div .= '<button type="button" id="' . $row->id . '" data-id="' . $row->id . '" onclick="return getRejectionReasonUrl(' . $row->id . ')" class="btn btn-sm btn-flex btn-light-danger">سبب الرفض</button>';
                    } else {
                        $div = '<span class="text-warning">العقد غير متوفر</span>';
                    }
                }

                return $div;
            })->editColumn('approved', function ($row) {
                $divApproved = '';
                if ($row->approved == 0 && $row->rejection_reason == null) {
                    $divApproved = '<i class="bi bi-clipboard2 fs-2 text-warning"></i>';
                } elseif ($row->approved == 0 && $row->rejection_reason != null) {
                    $divApproved = '<i class="bi bi-clipboard-x fs-2 text-danger"></i>';
                } else {
                    $divApproved = '<i class="bi bi-clipboard-check fs-2 text-success"></i>';
                }

                return $divApproved;
            })->rawColumns(['contract_url', 'approved'])->make(true);
        }

        $compact = [
            'trans_file' => 'user',
            'url' => url("observer/contract-projects/details/" . $project_id),
            'project_id' => $project_id,
            'resource' => 'admin.users.',
            'counter' => $query->count()
        ];

        return view('backoffice.observer.contractprojectsdetails', $compact);
    }

    public function edit(Request $request, $projectId)
    {
        $projectCurrentStatus = Project::select('status_id AS status')->where('id', $projectId)->first()->status;
        if (isset($request['status']) && $request['status'] == $projectCurrentStatus) :
            $this->blade_path = 'backoffice.observer.edit';
        elseif (! isset($request['status'])) :
            $this->blade_path = 'backoffice.observer.edit';
        else :
            return redirect('/observer/projects');
        endif;

        $query = $this->model::with('status', 'type', 'region', 'customer', 'localDevelopment')->find($projectId);
        $compact = [
            'trans_file' => $this->trans_file,
            'resource' => $this->resource,
            'row' => $query,
            'users' => ProjectTransactionHistory::with('user')->where('project_id', $projectId)->groupBy('user_id')->get(),
            'project_admin' => User::where('id', 2)->first(),
            'team_members' => DB::table('users as user')
                ->leftJoin('model_has_roles as role', 'role.model_id', '=', 'user.id')
                ->leftJoin('project_fieldwork_team as field', 'field.user_id', '=', DB::raw("user.id and field.project_id = $projectId"))
                ->select('user.id', 'user.name', 'user.email', 'role.role_id')->whereIn('role.role_id', [6, 7])->whereNull('field.user_id')->get(),
            'team_ranks' => TeamRankType::get(),
            'financial_bid_estimate' => ProjectFinancialEstimate::where('project_id', $projectId)->first(),
            'project_training_file' => ProjectTrainingDetail::where('project_id', $projectId)->first(),
            'project_family_development' => ProjectFamilyDevelopment::where('project_id', $projectId)->first(),
            'project_local_development' => ProjectLocalDevelopment::where('project_id', $projectId)->first(),
            'attracting_teams' => AttractingTeam::whereIn('type_id', [4, 7])->get(),
            'selected_attracting_teams' => DB::table('attracting_team as attracting')->leftJoin('project_observer_team as observer', 'observer.team_user_id', '=', DB::raw("attracting.id and observer.project_id = $projectId"))
                ->select('attracting.id as id', 'attracting.name as name', 'attracting.mobile as mobile', 'attracting.type_id as type_id', 'attracting.enrolled_date as enrolled_date', 'attracting.accomplished_projects as accomplished_projects', 'attracting.performance_percentage as performance_percentage')
                ->whereIn('attracting.type_id', [4, 7])->whereNull('observer.team_user_id')->get(),
            'project_empower_charity' => ProjectEmpowerCharity::where('project_id', $projectId)->first(),
            'selected_observer_teams' => ProjectObserverTeam::where('project_id', $projectId)->where('superior_id', Auth::user()->id)->with('city')->where('type_id', 4)->get(),
            'selected_trainer_teams' => ProjectObserverTeam::where('project_id', $projectId)->where('type_id', 7)->get(),
            'observer_team' => ProjectObserverTeam::select('superior_id', 'superior_team_id', 'type_id', DB::raw('COUNT(qty) as qty'))->where('project_id', $projectId)->groupBy('type_id')->groupBy('superior_id')->groupBy('superior_team_id')->get(),
            'observer_team_researchers' => DB::table('project_observer_team')->select('type_id', DB::raw('COUNT(type_id) as qty'))->where('project_id', $projectId)->where('type_id', 5)
                ->whereIn(DB::raw('superior_team_id'), array(DB::raw('select team_user_id from project_observer_team where type_id = 4 and project_id = ' . $projectId . ' and superior_id = ' . Auth::user()->id)))->groupBy('type_id')->first(),
            'fieldwork_team' => ProjectFieldworkTeam::select('type_id', DB::raw('COUNT(type_id) as qty'), DB::raw('SUM(researcher_qty) as researcher_qty'), DB::raw('SUM(supervisor_qty) as supervisor_qty'))->where('project_id', $projectId)->where('user_id', Auth::user()->id)->groupBy('type_id')->first(),
            'fieldwork_teams' => DB::table('project_fieldwork_team as team')
                ->leftJoin('users as user', 'user.id', '=', 'team.user_id')->select('user.username', 'user.name', 'team.type_id', 'team.supervisor_qty', 'team.researcher_qty')->where('project_id', $projectId)->get(),
            'team_rank_items' => DB::table('project_team_rank_item')->select('type_id', DB::raw('COUNT(type_id) as qty'))->where('project_id', $projectId)->groupBy('type_id')->get(),
            'fieldworkCounts' => ProjectFieldworkTeam::select(DB::raw('SUM(supervisor_qty) AS supervisors,SUM(researcher_qty) AS researchers,SUM(auditor_qty) AS auditors'))
                ->where('project_id', $projectId)->where('user_id', Auth::user()->id)->first()
        ];

        return view($this->blade_path, $compact);
    }

    public function getTour($projectId)
    {
        $projectCurrentTour = ProjectExploreTour::where('project_id', $projectId)->where('is_observer_done', '0')->exists();
        if ($projectCurrentTour) {
            $query = $this->model::with('status', 'type', 'region', 'customer', 'localDevelopment')->find($projectId);
            $project_explore_tour = ProjectExploreTour::where('project_id', $projectId)->with('city')->first();
            $compact = [
                'trans_file' => $this->trans_file,
                'resource' => $this->resource,
                'row' => $query,
                'project_explore_tour' => $project_explore_tour,
                'project_admin' => User::where('id', 2)->first(),
                'project_tour_files' => ProjectTourFile::where('explore_tour_id', $project_explore_tour->id)->get(),
                'project_family_development' => ProjectFamilyDevelopment::where('project_id', $projectId)->first(),
                'project_local_development' => ProjectLocalDevelopment::where('project_id', $projectId)->first(),
            ];

            $this->blade_path = 'backoffice.observer.tour';
            return view($this->blade_path, $compact);
        } else {
            return redirect('/observer/projects/tour');
        }
    }

    public function getCorrection($projectId)
    {
        $query = $this->model::with('status', 'type', 'region', 'customer', 'localDevelopment')->find($projectId);
        $this->blade_path = 'backoffice.observer.correction';

        $compact = [
            'trans_file' => $this->trans_file,
            'resource' => $this->resource,
            'row' => $query,
            'project_admin' => User::where('id', 2)->first(),
            'team_members' => DB::table('users as user')
                ->leftJoin('model_has_roles as role', 'role.model_id', '=', 'user.id')
                ->leftJoin('project_fieldwork_team as field', 'field.user_id', '=', DB::raw("user.id and field.project_id = $projectId"))
                ->select('user.id', 'user.name', 'user.email', 'role.role_id')->whereIn('role.role_id', [6, 7])->whereNull('field.user_id')->get(),
            'team_ranks' => TeamRankType::get(),
            'financial_bid_estimate' => ProjectFinancialEstimate::where('project_id', $projectId)->first(),
            'project_training_file' => ProjectTrainingDetail::where('project_id', $projectId)->first(),
            'project_family_development' => ProjectFamilyDevelopment::where('project_id', $projectId)->first(),
            'project_local_development' => ProjectLocalDevelopment::where('project_id', $projectId)->first(),
            'attracting_teams' => AttractingTeam::whereIn('type_id', [4, 7])->get(),
            'selected_attracting_teams' => DB::table('attracting_team as attracting')
                ->leftJoin('project_observer_team as observer', 'observer.team_user_id', '=', DB::raw("attracting.id and observer.project_id = $projectId"))
                ->select('attracting.id as id', 'attracting.name as name', 'attracting.mobile as mobile', 'attracting.type_id as type_id', 'attracting.enrolled_date as enrolled_date', 'attracting.accomplished_projects as accomplished_projects', 'attracting.performance_percentage as performance_percentage')
                ->whereIn('attracting.type_id', [4, 7])->whereNull('observer.team_user_id')->get(),
            'selected_observer_teams' => ProjectObserverTeam::where('project_id', $projectId)->where('superior_id', Auth::user()->id)->where('type_id', 4)->get(),
            'selected_trainer_teams' => ProjectObserverTeam::where('project_id', $projectId)->where('type_id', 7)->get(),
            'observer_team' => ProjectObserverTeam::select('superior_id', 'superior_team_id', 'type_id', DB::raw('COUNT(qty) as qty'))->where('project_id', $projectId)->groupBy('type_id')->groupBy('superior_id')->groupBy('superior_team_id')->get(),
            'observer_team_researchers' => DB::table('project_observer_team')->select('type_id', DB::raw('COUNT(type_id) as qty'))->where('project_id', $projectId)->where('type_id', 5)
                ->whereIn(DB::raw('superior_team_id'), array(DB::raw('select team_user_id from project_observer_team where type_id = 4 and project_id = ' . $projectId . ' and superior_id = ' . Auth::user()->id)))->groupBy('type_id')->first(),
            'fieldwork_team' => ProjectFieldworkTeam::select('type_id', DB::raw('COUNT(type_id) as qty'), DB::raw('SUM(researcher_qty) as researcher_qty'), DB::raw('SUM(supervisor_qty) as supervisor_qty'))->where('project_id', $projectId)->where('user_id', Auth::user()->id)->groupBy('type_id')->first(),
            'fieldwork_teams' => DB::table('project_fieldwork_team as team')
                ->leftJoin('users as user', 'user.id', '=', 'team.user_id')->select('user.username', 'user.name', 'team.type_id', 'team.supervisor_qty', 'team.researcher_qty')->where('project_id', $projectId)->get(),
            'team_rank_items' => DB::table('project_team_rank_item')->select('type_id', DB::raw('COUNT(type_id) as qty'))->where('project_id', $projectId)->groupBy('type_id')->get(),
            'fieldworkCounts' => ProjectFieldworkTeam::select(DB::raw('SUM(supervisor_qty) AS supervisors,SUM(researcher_qty) AS researchers,SUM(auditor_qty) AS auditors'))
                ->where('project_id', $projectId)->where('user_id', Auth::user()->id)->first()
        ];

        return view($this->blade_path, $compact);
    }

    public function createSupervisorTeam(Request $request)
    {
        $dAccounts = [];
        // $financial_bid_estimate = ProjectFinancialEstimate::where('project_id', $request['project_id'])->first();
        $fieldTeam = ProjectFieldworkTeam::select(DB::raw('SUM(supervisor_qty) AS supervisors,SUM(researcher_qty) AS researchers,SUM(auditor_qty) AS auditors'))->where('project_id', $request['project_id'])->where('user_id', Auth::user()->id)->first();
        $researcher_qty = $fieldTeam->researchers;
        $supervisor_qty = $fieldTeam->supervisors;

        $supervisorCheckRowNo = 0;
        $resarcherCounter = 0;
        if (! empty($request['user-checkbox'])) {
            $supervisorCheckRowNo += count($request['user-checkbox']);
            if ($supervisorCheckRowNo > $supervisor_qty) {
                return back()->with('error', trans('إجمالي عدد المشرفين لا يتعدى ' . $supervisor_qty));
                exit();
            }

            for ($i = 0; $i < $supervisorCheckRowNo; $i++) {
                $resarcherCounter += $request['users-' . $request['user-checkbox'][$i]];
            }

            if ($resarcherCounter > $researcher_qty) {
                return back()->with('error', trans('إجمالي عدد الباحثين لا يتعدى ' . $researcher_qty));
                exit();
            }
        }

        if (! empty($request['selected-user-checkbox'])) {
            $q = ProjectObserverTeam::where('project_id', $request['project_id'])->where(function ($query) use ($request) {
                $query->whereNotIn('team_user_id', $request['selected-user-checkbox'])->where('type_id', 4);
            })->orwhere(function ($query) use ($request) {
                $query->whereNotIn('superior_team_id', $request['selected-user-checkbox'])->where('type_id', 5);
            });
            $getDeactive = $q->get();

            foreach ($getDeactive as $v) :
                $dAccounts[] = [
                    "team_user_id" => $v->team_user_id,
                    "type_id" => $v->type_id,
                    "project_id" => $v->project_id,
                    "user_id" => Auth::user()->id,
                    "superior_team_id" => (isset($v->superior_team_id) && ! is_null($v->superior_team_id)) ? $v->superior_team_id : NULL,
                    "created_at" => DB::raw('NOW()')
                ];
            endforeach;
            $restore = DKA::insert($dAccounts);
            if ($restore) :
                $q->delete();
            endif;

            $supervisorCheckRowNo += count($request['selected-user-checkbox']);
            if ($supervisorCheckRowNo > $supervisor_qty) {
                return back()->with('error', trans('إجمالي عدد المشرفين لا يتعدى ' . $supervisor_qty));
                exit();
            }

            for ($i = 0; $i < count($request['selected-user-checkbox']); $i++) {
                $resarcherCounter += $request['selected-users-' . $request['selected-user-checkbox'][$i]];
            }

            if ($resarcherCounter > $researcher_qty) {
                return back()->with('error', trans('إجمالي عدد الباحثين لا يتعدى ' . $researcher_qty));
                exit();
            }

            for ($i = 0; $i < count($request['selected-user-checkbox']); $i++) {
                $teamUserId = $request['selected-user-checkbox'][$i];
                $insertion = [
                    'qty' => $request['selected-users-' . $teamUserId],
                    'updated_at' => date('Y-m-d H:i:s'),
                ];

                ProjectObserverTeam::where('project_id', $request['project_id'])
                    ->where('type_id', $request['type_id'])
                    ->where('id', $teamUserId)
                    ->update($insertion);
            }
        }

        if (! empty($request['user-checkbox'])) {
            $rowNo = count($request['user-checkbox']);
            for ($i = 0; $i < $rowNo; $i++) {
                $insertion = [
                    'team_user_id' => $request['user-checkbox'][$i],
                    'superior_id' => $request['superior_id'],
                    'type_id' => $request['type_id'],
                    'project_id' => $request['project_id'],
                    'city_id' => $request['city-' . $request['user-checkbox'][$i]],
                    'qty' => $request['users-' . $request['user-checkbox'][$i]],
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ];

                ProjectObserverTeam::create($insertion);
            }
        }

        if (empty($request['user-checkbox']) && empty($request['selected-user-checkbox'])) {
            ProjectObserverTeam::where('project_id', $request['project_id'])
                ->where('type_id', $request['type_id'])
                ->delete();
        }

        return back()->with('success', trans('site.mission_completed'));
    }

    public function createTrainerTeam(Request $request)
    {
        $financial_bid_estimate = ProjectFinancialEstimate::where('project_id', $request['project_id'])->first();
        $trainer_qty = $financial_bid_estimate->trainer_qty;
        $rowNo = 0;

        if (! empty($request['user-checkbox']) || ! empty($request['selected-user-checkbox'])) {
            $rowNo += ! empty($request['user-checkbox']) ? count($request['user-checkbox']) : 0;
            $rowNo += ! empty($request['selected-user-checkbox']) ? count($request['selected-user-checkbox']) : 0;
            if ($rowNo > $trainer_qty) {
                return back()->with('error', trans('إجمالي عدد المشرفين لا يتعدى ' . $trainer_qty));
                exit();
            }
        }

        if (! empty($request['selected-user-checkbox'])) {
            ProjectObserverTeam::where('project_id', $request['project_id'])
                ->where('type_id', $request['type_id'])
                ->whereNotIn('id', $request['selected-user-checkbox'])
                ->delete();

            $rowNo = count($request['selected-user-checkbox']);
            for ($i = 0; $i < $rowNo; $i++) {
                $teamUserId = $request['selected-user-checkbox'][$i];
                $insertion = [
                    'qty' => $request['selected-users-' . $teamUserId],
                    'updated_at' => date('Y-m-d H:i:s'),
                ];

                ProjectObserverTeam::where('project_id', $request['project_id'])
                    ->where('type_id', $request['type_id'])
                    ->where('id', $teamUserId)
                    ->update($insertion);
            }
        }

        if (! empty($request['user-checkbox'])) {
            $rowNo = count($request['user-checkbox']);
            for ($i = 0; $i < $rowNo; $i++) {
                $insertion = [
                    'team_user_id' => $request['user-checkbox'][$i],
                    'superior_id' => $request['superior_id'],
                    'type_id' => $request['type_id'],
                    'project_id' => $request['project_id'],
                    'qty' => 0,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ];

                ProjectObserverTeam::create($insertion);
            }
        }

        if (empty($request['user-checkbox']) && empty($request['selected-user-checkbox'])) {
            ProjectObserverTeam::where('project_id', $request['project_id'])
                ->where('type_id', $request['type_id'])
                ->delete();
        }

        return back()->with('success', trans('site.mission_completed'));
    }

    public function getResearchers($projectId)
    {
        $query = $this->model::with('status', 'type', 'region', 'customer', 'localDevelopment')->find($projectId);
        $this->blade_path = 'backoffice.observer.manage-team.researcher';

        $compact = [
            'project_id' => $projectId,
            'trans_file' => $this->trans_file,
            'resource' => $this->resource,
            'row' => $query,
            'team_members' => DB::table('users as user')->leftJoin('model_has_roles as role', 'role.model_id', '=', 'user.id')
                ->leftJoin('project_fieldwork_team as field', 'field.user_id', '=', DB::raw("user.id and field.project_id = $projectId"))
                ->select('user.id', 'user.name', 'user.email', 'role.role_id')->whereIn('role.role_id', [6, 7])->whereNull('field.user_id')->get(),
            'team_ranks' => TeamRankType::get(),
            'financial_bid_estimate' => ProjectFinancialEstimate::where('project_id', $projectId)->first(),
            'attracting_teams' => AttractingTeam::where('type_id', 4)->get(),
            'observer_teams' => ProjectObserverTeam::where('project_id', $projectId)->get(),
            'fieldwork_team' => ProjectFieldworkTeam::select('type_id', DB::raw('COUNT(type_id) as qty'))->where('project_id', $projectId)->groupBy('type_id')->get(),
            'fieldwork_teams' => DB::table('project_fieldwork_team as team')
                ->leftJoin('users as user', 'user.id', '=', 'team.user_id')->select('user.username', 'user.name', 'team.type_id', 'team.supervisor_qty')->where('project_id', $projectId)->get(),
            'team_rank_items' => DB::table('project_team_rank_item')
                ->select('type_id', DB::raw('COUNT(type_id) as qty'))->where('project_id', $projectId)->groupBy('type_id')->get(),
        ];

        return view($this->blade_path, $compact);
    }

    public function ajaxFilter($projectId, Request $request)
    {
        $filter = $request['filter'];
        $projectId = $request['projectId'];
        $type = $request['type'];
        $superior_id = $request['filter_superior_id'];

        if ($type == 'supervisor') {
            $view = 'partials.backoffice.observer.list';
            $q = DB::table('attracting_team as attracting')
                ->leftJoin('project_observer_team as observer', 'observer.team_user_id', '=', DB::raw("attracting.id and observer.project_id = $projectId"))
                ->where('attracting.name', 'like', '%' . $filter . '%')
                ->where('observer.type_id', 4);

            $compact = [
                'project_id' => $projectId,
                'attracting_teams' => AttractingTeam::where('type_id', 4)->get(),
                'observer_teams' => $q->get()
            ];
        }

        if ($type == 'researcher') {
            $view = 'partials.backoffice.researcher.list';
            $compact = [
                'selected_researchers' => ProjectObserverTeam::where('superior_team_id', $superior_id)
                    ->where('project_id', '=', $projectId)->where('type_id', 5)->get(),
                'project_id' => $projectId,
                'attracting_teams' => AttractingTeam::where('type_id', 5)->get(),
                'selected_attracting_teams' => DB::table('attracting_team as attracting')
                    ->leftJoin('project_observer_team as observer', 'observer.team_user_id', '=', DB::raw("attracting.id and observer.project_id = $projectId"))
                    ->select('attracting.id as id', 'attracting.name as name', 'attracting.mobile as mobile', 'attracting.type_id as type_id', 'attracting.enrolled_date as enrolled_date', 'attracting.accomplished_projects as accomplished_projects', 'attracting.performance_percentage as performance_percentage')
                    ->whereIn('attracting.type_id', [5])
                    ->where('attracting.name', 'like', '%' . $filter . '%')
                    ->whereNull('observer.team_user_id')
                    ->get(),
            ];
        }

        return response()->json([
            'views' => view($view, $compact)->render(),
        ]);
    }

    public function getCorrectionResearchers($projectId)
    {
        $query = $this->model::with('status', 'type', 'region', 'customer', 'localDevelopment')->find($projectId);
        $this->blade_path = 'backoffice.observer.manage-team.correction-researcher';

        $compact = [
            'project_id' => $projectId,
            'trans_file' => $this->trans_file,
            'resource' => $this->resource,
            'row' => $query,
            'team_members' => DB::table('users as user')->leftJoin('model_has_roles as role', 'role.model_id', '=', 'user.id')
                ->leftJoin('project_fieldwork_team as field', 'field.user_id', '=', DB::raw("user.id and field.project_id = $projectId"))
                ->select('user.id', 'user.name', 'user.email', 'role.role_id')->whereIn('role.role_id', [6, 7])->whereNull('field.user_id')->get(),
            'team_ranks' => TeamRankType::get(),
            'financial_bid_estimate' => ProjectFinancialEstimate::where('project_id', $projectId)->first(),
            'attracting_teams' => AttractingTeam::where('type_id', 4)->get(),
            'observer_teams' => ProjectObserverTeam::where('project_id', $projectId)->get(),
            'fieldwork_team' => ProjectFieldworkTeam::select('type_id', DB::raw('COUNT(type_id) as qty'))->where('project_id', $projectId)->groupBy('type_id')->get(),
            'fieldwork_teams' => DB::table('project_fieldwork_team as team')
                ->leftJoin('users as user', 'user.id', '=', 'team.user_id')->select('user.username', 'user.name', 'team.type_id', 'team.supervisor_qty')->where('project_id', $projectId)->get(),
            'team_rank_items' => DB::table('project_team_rank_item')
                ->select('type_id', DB::raw('COUNT(type_id) as qty'))->where('project_id', $projectId)->groupBy('type_id')->get(),
        ];

        return view($this->blade_path, $compact);
    }

    public function ajax($id, $projectId, $isCorrection)
    {
        $selectResearcherQuery = ProjectObserverTeam::where('superior_team_id', $id)->where('project_id', '=', $projectId)->where('type_id', 5);
        $team = DB::table('attracting_team as attracting')->leftJoin('project_observer_team as observer', 'observer.team_user_id', '=', DB::raw("attracting.id and observer.project_id = $projectId"))
            ->select('attracting.id as id', 'attracting.name as name', 'attracting.mobile as mobile', 'attracting.type_id as type_id', 'attracting.enrolled_date as enrolled_date', 'attracting.accomplished_projects as accomplished_projects', 'attracting.performance_percentage as performance_percentage')
            ->where('attracting.type_id', 5)->whereNull('observer.team_user_id');

        $compact = [
            'selected_researchers' => $selectResearcherQuery->get(),
            'attracting_teams' => AttractingTeam::where('type_id', 5)->get(),
            'selected_attracting_teams' => $team->get()
        ];

        if ($isCorrection == 'correction') {
            return response()->json([
                'views' => view('partials.backoffice.observer.correctionResearcherlist', $compact)->render(),
                'teamcount' => $selectResearcherQuery->count()
            ]);
        } else {
            return response()->json([
                'views' => view('partials.backoffice.observer.researcherlist', $compact)->render(),
                'teamcount' => $selectResearcherQuery->count()
            ]);
        }
    }

    public function saveResearcherList(Request $request)
    {
        $dAccounts = [];
        //BEGIN FOR REASEARCHER CORRECTION FEATURE
        if ($request['is_correction'] == 'true') {
            if (! empty($request['selected_researcher_checkbox'])) {
                $deSelectIds = ProjectObserverTeam::select('team_user_id')
                    ->where('project_id', $request['project_id'])
                    ->where('type_id', 5)
                    ->whereNotIn('team_user_id', $request['selected_researcher_checkbox'])
                    ->where('superior_team_id', $request['superior_id'])->get();

                foreach ($deSelectIds as $id) :
                    ProjectContracts::where('project_id', $request['project_id'])->where('type_id', 5)->where('team_user_id', $id->team_user_id)->delete();
                endforeach;
                //TO DO JOB We need to send the list of $id to equipment so, equipment will do his job to deactivate their accounts in Kashef system
                $q = ProjectObserverTeam::where('project_id', $request['project_id'])->where('type_id', 5)->whereNotIn('team_user_id', $request['selected_researcher_checkbox'])->where('superior_team_id', $request['superior_id']);
                $getDeactive = $q->get();

                foreach ($getDeactive as $v) :
                    $dAccounts[] = [
                        "team_user_id" => $v->team_user_id,
                        "type_id" => $v->type_id,
                        "project_id" => $v->project_id,
                        "user_id" => Auth::user()->id,
                        "superior_team_id" => (isset($v->superior_team_id) && ! is_null($v->superior_team_id)) ? $v->superior_team_id : NULL,
                        "created_at" => DB::raw('NOW()')
                    ];
                endforeach;
                $restore = DKA::insert($dAccounts);
                if ($restore) :
                    $q->delete();
                endif;
            } else {
                ProjectObserverTeam::where('project_id', $request['project_id'])->where('type_id', 5)->where('superior_team_id', $request['superior_id'])->delete();
            }

            if (! empty($request['researcher_id'])) {
                $rowNo = 0;
                if (! empty($request['researcher_id'])) {
                    $rowNo += count($request['researcher_id']);
                    if (! empty($request['selected_researcher_checkbox'])) {
                        $rowNo += count($request['selected_researcher_checkbox']);
                    }
                }

                $researcher_qty = DB::table('project_observer_team')->select(DB::raw('SUM(qty) as qty'))->where('project_id', $request['project_id'])->where('type_id', 4)->where('team_user_id', $request['superior_id'])->first();
                $researcherQty = $researcher_qty->qty;
                if ($rowNo > $researcherQty) {
                    // return back()->with('error', trans('إجمالي عدد الباحثين لا يتعدى ' . $researcherQty));
                    return response()->json(['MSG' => ' عدد الباحثين المحدد يجب ان لا يتجاوز العدد المسموح به : ' . $researcherQty, 'code' => 401]);
                    exit();
                }
            }

            if (! empty($request['researcher_id'])) {
                $rowNo = count($request['researcher_id']);
                for ($i = 0; $i < $rowNo; $i++) {
                    $insertion = [
                        'team_user_id' => $request['researcher_id'][$i],
                        'superior_team_id' => $request['superior_id'],
                        'type_id' => 5,
                        'project_id' => $request['project_id'],
                        'qty' => 0,
                        'is_correction' => '1',
                        'received_train' => '0',
                        'approved_member' => '0',
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s'),
                    ];

                    ProjectObserverTeam::create($insertion);
                }
            }

            $arr = array('msg' => __('site.mission_completed'), 'status' => true);
            return response()->json($arr);
        } else {
            if (! empty($request['researcher_id'])) {
                $rowNo = 0;
                if (! empty($request['researcher_id'])) {
                    $rowNo += count($request['researcher_id']);
                    if (! empty($request['selected_researcher_id'])) {
                        $rowNo += count($request['selected_researcher_id']);
                    }
                }

                $researcher_qty = DB::table('project_observer_team')->select(DB::raw('SUM(qty) as qty'))->where('project_id', $request['project_id'])->where('type_id', 4)->where('team_user_id', $request['superior_id'])->first();
                $researcherQty = $researcher_qty->qty;
                if ($rowNo > $researcherQty) {
                    // return back()->with('error', trans('إجمالي عدد الباحثين لا يتعدى ' . $researcherQty));
                    return response()->json(['MSG' => ' عدد الباحثين المحدد يجب ان لا يتجاوز العدد المسموح به : ' . $researcherQty, 'code' => 401]);
                    exit();
                }
            }

            if (! empty($request['selected_researcher_id'])) {
                ProjectObserverTeam::where('project_id', $request['project_id'])->where('type_id', 5)->whereNotIn('team_user_id', $request['selected_researcher_id'])->where('superior_team_id', $request['superior_id'])->delete();
                $rowNo = count($request['selected_researcher_id']);
                for ($i = 0; $i < $rowNo; $i++) {
                    $teamUserId = $request['selected_researcher_id'][$i];
                    $teamEmail = AttractingTeam::find($teamUserId)->email;
                    $query = ProjectObserverTeam::select('approved_member AS approve')->where('project_id', $request['project_id'])->where('type_id', 5)->where('superior_team_id', Auth::user()->id)->where('team_user_id', $teamUserId)->first();

                    $insertion = [
                        'team_user_id' => $teamUserId,
                        'superior_team_id' => $request['superior_id'],
                        'type_id' => 5,
                        'project_id' => $request['project_id'],
                        'qty' => 0,
                        'is_correction' => '0',
                        'received_train' => '0',
                        'approved_member' => '0',
                        'updated_at' => date('Y-m-d H:i:s'),
                    ];

                    ProjectObserverTeam::updateOrCreate(['project_id' => $request['project_id'], 'type_id' => 5, 'team_user_id' => $teamUserId, 'superior_team_id' => $request['superior_id']], $insertion);
                }
            } else {
                ProjectObserverTeam::where('project_id', $request['project_id'])->where('type_id', 5)->where('superior_team_id', $request['superior_id'])->delete();
            }

            if (! empty($request['researcher_id'])) {
                $rowNo = count($request['researcher_id']);
                for ($i = 0; $i < $rowNo; $i++) {
                    $insertion = [
                        'team_user_id' => $request['researcher_id'][$i],
                        'superior_team_id' => $request['superior_id'],
                        'type_id' => 5,
                        'project_id' => $request['project_id'],
                        'qty' => 0,
                        'is_correction' => '0',
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s'),
                    ];

                    ProjectObserverTeam::create($insertion);
                }
            }
        }

        return back()->with('success', trans('site.mission_completed'));
    }

    public function getTeamMembersForApproval($projectId, $taskType = null)
    {
        $query = $this->model::with('status', 'type', 'region', 'customer', 'localDevelopment')->find($projectId);
        $this->blade_path = 'backoffice.observer.manage-team.approve-member';

        $compact = [
            'trans_file' => $this->trans_file,
            'resource' => $this->resource,
            'row' => $query,
            'project_admin' => User::where('id', 2)->first(),
            'team_members' => DB::table('users as user')
                ->leftJoin('model_has_roles as role', 'role.model_id', '=', 'user.id')
                ->leftJoin('project_fieldwork_team as field', 'field.user_id', '=', DB::raw("user.id and field.project_id = $projectId"))
                ->select('user.id', 'user.name', 'user.email', 'role.role_id')->whereIn('role.role_id', [6, 7])->whereNull('field.user_id')->get(),
            'team_ranks' => TeamRankType::get(),
            'financial_bid_estimate' => ProjectFinancialEstimate::where('project_id', $projectId)->first(),
            'selected_researchers' => DB::table('project_observer_team')->where('project_id', $projectId)->where('type_id', 5)->where('approved_member', '0')
                ->whereIn(DB::raw('superior_team_id'), array(DB::raw('select team_user_id from project_observer_team where type_id = 4 and project_id = ' . $projectId . ' and superior_id = ' . Auth::user()->id)))->get(),
            'attracting_teams' => AttractingTeam::where('type_id', 5)->get(),
            'selected_attracting_teams' => DB::table('attracting_team as attracting')
                ->leftJoin('project_observer_team as observer', 'observer.team_user_id', '=', 'attracting.id')
                ->select('attracting.id as id', 'attracting.name as name', 'attracting.mobile as mobile', 'attracting.type_id as type_id', 'attracting.enrolled_date as enrolled_date', 'attracting.accomplished_projects as accomplished_projects', 'attracting.performance_percentage as performance_percentage')
                ->where('attracting.type_id', 4)->whereNull('observer.team_user_id')->get(),
            'fieldworkCounts' => ProjectFieldworkTeam::select(DB::raw('SUM(supervisor_qty) AS supervisors,SUM(researcher_qty) AS researchers,SUM(auditor_qty) AS auditors'))
                ->where('project_id', $projectId)->where('user_id', Auth::user()->id)->first(),
            'selected_observer_teams' => ProjectObserverTeam::where('project_id', $projectId)->where('type_id', 4)->get(),
            'observer_team' => ProjectObserverTeam::select('type_id', DB::raw('COUNT(type_id) as qty'))->where('project_id', $projectId)->groupBy('type_id')->get(),
            'fieldwork_team' => ProjectFieldworkTeam::select('type_id', DB::raw('COUNT(type_id) as qty'), DB::raw('SUM(researcher_qty) as researcher_qty'), DB::raw('SUM(supervisor_qty) as supervisor_qty'))->where('project_id', $projectId)->where('user_id', Auth::user()->id)->groupBy('type_id')->first(),
            'fieldwork_teams' => DB::table('project_fieldwork_team as team')
                ->leftJoin('users as user', 'user.id', '=', 'team.user_id')->select('user.username', 'user.name', 'team.type_id', 'team.supervisor_qty')->where('project_id', $projectId)->get(),
            'team_rank_items' => DB::table('project_team_rank_item')->select('type_id', DB::raw('COUNT(type_id) as qty'))->where('project_id', $projectId)->groupBy('type_id')->get(),
            'taskType' => $taskType ?? 'none'
        ];

        return view($this->blade_path, $compact);
    }

    public function approveTeamMembers(Request $request)
    {
        if (! empty($request['user-checkbox'])) {
            try {
                if ($request['taskType'] == 'approval') {
                    Project::where('id', $request['project_id'])->update([
                        'is_training_correction' => '0'
                    ]);

                    $attracting_team = AttractingTeam::whereIn('id', $request['user-checkbox'])->get();
                    foreach ($attracting_team as $value) {
                        if (! empty($value->email)) {
                            $params = [Crypt::encrypt($request['project_id']), Crypt::encrypt($value->id)];
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

                    $arr = ['msg' => __('site.mission_completed'), 'status' => true];
                    return response()->json($arr);
                } else {
                    // Send Mail To current Observer
                    $params = [Crypt::encrypt($request['project_id']), Crypt::encrypt(Auth::user()->id) . '?Case=' . Crypt::encrypt('ObserverContract')];
                    $mailData = [
                        'route' => route('team-member-contract', $params),
                        'label' => __('project.contract_details'),
                    ];
                    // Send Mail To Current logged in observer
                    $sent = Mail::to(Auth::user()->email)->send(new ApproveTeamMembers($mailData));
                    ProjectContracts::create([
                        'project_id' => $request['project_id'],
                        'type_id' => 1,
                        'user_id' => Auth::user()->id,
                        'send_date' => date('Y-m-d'),
                    ]);

                    if ($sent) {
                        // Send Mail To ALL Supervisors
                        $supervisors = ProjectObserverTeam::with('atttractingTeamInfo')->where('project_id', $request['project_id'])->where('type_id', 4)->where('superior_id', Auth::user()->id)->get();
                        foreach ($supervisors as $value) {
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

                        $observteam = ProjectObserverTeam::where('project_id', $request['project_id'])->whereIn('team_user_id', $request['user-checkbox']);
                        if ($observteam->exists()) {
                            $attracting_team = AttractingTeam::whereIn('id', $request['user-checkbox'])->get();
                            foreach ($attracting_team as $value) {
                                if (! empty($value->email)) {
                                    $params = [Crypt::encrypt($request['project_id']), Crypt::encrypt($value->id)];
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

                            ProjectObserverTeam::where('project_id', $request['project_id'])->where('type_id', 4)->update(['received_train' => '1', 'approved_member' => '1']);
                            ProjectObserverTeam::where('project_id', $request['project_id'])->whereIn('team_user_id', $request['user-checkbox'])->update(['received_train' => '1', 'approved_member' => '1']);
                            //We need to check if AUDITOR user has approved his team members first
                            if (ProjectAuditorTeam::where('project_id', $request['project_id'])->where('approved_member', '=', '1')->exists()) {
                                $this->COMMON_HELPER->changeProjectStatus($request, 9);
                                $this->COMMON_HELPER->handleCaptureTransaction($request, 17, '0', 9);
                            } else {
                                $isObserverDoneTask = ProjectTransactionHistory::where('project_id', $request['project_id'])->where('status_id', 15)->where('is_done', '1')->count() > 0;
                                $otherObserverNotDoneTask = ProjectTransactionHistory::where('project_id', $request['project_id'])->where('status_id', 15)->count();
                                $otherObserverDoneTask = ProjectTransactionHistory::where('project_id', $request['project_id'])->where('status_id', 15)->where('is_done', '1')->count();
                                $moveToTrainer = $otherObserverNotDoneTask == $otherObserverDoneTask ? true : false;
                                if ($isObserverDoneTask && $moveToTrainer) {
                                    $this->COMMON_HELPER->handleCaptureTransaction($request, 17, '0', 9);
                                }
                            }

                            $this->COMMON_HELPER->handleCaptureTransaction($request, 15, '1');
                            $arr = ['msg' => __('site.mission_completed'), 'status' => true];
                            return response()->json($arr);
                        } else {
                            $arr = ['msg' => __('site.storeMessageError'), 'status' => false];
                            return response()->json($arr); // 400 being the HTTP code for an invalid request.
                        }
                    }
                }
            } catch (Exception $e) {
                $arr = ['msg' => $e->getMessage(), 'status' => false];
                return response()->json($arr); // 400 being the HTTP code for an invalid request.
            }
        } else {
            $arr = ['msg' => __('site.mission_completed'), 'status' => true];
            return response()->json($arr); // 400 being the HTTP code for an invalid request.
        }
    }

    public function teamMemberContract($projectId, $teamuserId)
    {
        $CheckExistContractApproved = ProjectContracts::where('project_id', Crypt::decrypt($projectId))->where(function ($query) use ($teamuserId) {
            $query->where('team_user_id', Crypt::decrypt($teamuserId))->orWhere('user_id', Crypt::decrypt($teamuserId));
        })->where('approved', '1')->whereNull('rejection_reason')->exists();

        $CheckExistContractExp = ProjectContracts::where('project_id', Crypt::decrypt($projectId))->where(function ($query) use ($teamuserId) {
            $query->where('team_user_id', Crypt::decrypt($teamuserId))->orWhere('user_id', Crypt::decrypt($teamuserId));
        })->where('send_date', '<', Carbon::now()->subDay(1))->whereNull('rejection_reason')->exists();

        $CheckExistContract = ProjectContracts::where('project_id', Crypt::decrypt($projectId))->where(function ($query) use ($teamuserId) {
            $query->where('team_user_id', Crypt::decrypt($teamuserId))->orWhere('user_id', Crypt::decrypt($teamuserId));
        })->whereNull('rejection_reason')->exists();

        if ($CheckExistContractApproved || $CheckExistContractExp || ! $CheckExistContract) {
            $compact = ['msg' => 'رابط العقد إما قد تمت الموافقة عليه مسبقاً أو أنه انتهت صلاحيته'];
            $this->blade_path = 'backoffice.observer.manage-team.contractAlreadyApproved';
        } else {
            $this->blade_path = 'backoffice.observer.manage-team.contract';
            $date_obj = new Arabic('Date');

            if (! empty(\Request::get('Case'))) {
                if (! empty(Crypt::decrypt(\Request::get('Case'))) == 'ObserverContract') {
                    $compact = $this->getUserData($projectId, $teamuserId, $date_obj);
                } else {
                    $compact = $this->getAttractingTeamData($projectId, $teamuserId, $date_obj);
                }
            } else {
                $compact = $this->getAttractingTeamData($projectId, $teamuserId, $date_obj);
            }
        }

        return view($this->blade_path, $compact);
    }

    public function getUserData($projectId, $teamuserId, $date_obj)
    {
        $row = User::where('id', Crypt::decrypt($teamuserId))->firstOrFail();
        $compact = [
            'typeTd' => 5,
            'teamuserId' => $teamuserId,
            'projectId' => $projectId,
            'logo' => asset('assets/media/logos/alfares.jpg'),
            'div_class' => 'divContractPreview',
            'team_rank_item' => ProjectTeamRankItem::select('project_id', 'type_id', 'title')->where(['project_id' => Crypt::decrypt($projectId), 'type_id' => 1])->get(),
            'row' => $row,
            'today_day_arabic' => $date_obj->date('l', time()),
            'team_rank_type_trans' => 'dasdsad',
            'project_title' => Project::select('title')->where('id', Crypt::decrypt($projectId))->value('title'),
            'trans_file' => $this->trans_file,
            'resource' => $this->resource,
            'preview_pdf' => 1,
        ];

        return $compact;
    }

    public function getAttractingTeamData($projectId, $teamuserId, $date_obj)
    {
        $row = AttractingTeam::with('type', 'region', 'city')
            ->select('id', 'name', 'national_id', 'mobile', 'region_id', 'city_id', 'email', 'type_id')
            ->where('id', Crypt::decrypt($teamuserId))
            ->firstOrFail();

        $compact = [
            'projectId' => $projectId,
            'teamuserId' => $teamuserId,
            'typeTd' => Crypt::encrypt($row->type->id),
            'logo' => asset('assets/media/logos/alfares.jpg'),
            'div_class' => 'divContractPreview',
            'team_rank_item' => ProjectTeamRankItem::select('project_id', 'type_id', 'title')
                ->where(['project_id' => Crypt::decrypt($projectId), 'type_id' => $row->type_id])->get(),
            'row' => $row,
            'today_day_arabic' => $date_obj->date('l', time()),
            'team_rank_type_trans' => $row->type->trans,
            'project_title' => Project::select('title')->where('id', Crypt::decrypt($projectId))->value('title'),
            'trans_file' => $this->trans_file,
            'resource' => $this->resource,
            'contract_research_items' => ProjectContractResearchItem::where(['project_id' => Crypt::decrypt($projectId)]),
            'preview_pdf' => 1,
        ];

        return $compact;
    }

    public function generateTeamMemberContract(Request $request, $projectId, $teamuserId, $TypeId)
    {
        if ($request->has('term') && $request['term'] == "1") :
            $type = (int) Crypt::decrypt($TypeId);
            $projectID = (int) Crypt::decrypt($projectId);
            $teamID = (int) Crypt::decrypt($teamuserId);
            if ($type == 5) {
                $projectTitle = Project::findOrFail($projectID)->title;
                $teamName = AttractingTeam::findOrFail($teamID)->name;
                $teamNameEn = AttractingTeam::findOrFail($teamID)->en_name ?? "Researcher Name";
                $teamImg = AttractingTeam::findOrFail($teamID)->avatar;
                $teamTel = AttractingTeam::findOrFail($teamID)->mobile;
                $teamEmail = AttractingTeam::findOrFail($teamID)->email;
                $observerID = ProjectObserverTeam::where('team_user_id', $teamID)->where('type_id', 5)
                    ->where('project_id', $projectID)->first()->id ?? "0";

                //$frontCard = \App\Helpers\VirtualCard::_frontCard($teamImg, $observerID, $teamName, $teamNameEn, $projectTitle, $teamTel);
                //$backCard = \App\Helpers\VirtualCard::_backCard($teamName, $teamTel);
                $vCard = \App\Helpers\VirtualCard::_fullCard($teamImg, $observerID, $teamName, $teamNameEn, $projectTitle, $teamTel);
                Mail::to($teamEmail)->send(new VirtualCardMail($projectTitle, $vCard, $teamName));
            }
        endif;

        $typeTddb = $TypeId;
        if ($request['term'] == '1') {
            if ($request->case == 'observer') {
                $row = \App\Models\User::where('id', Crypt::decrypt($teamuserId))->firstOrFail();
                $date_obj = new Arabic('Date');
                $div_class = 'divContractPreview';
                $logo = 'assets/media/logos/alfares.jpg';
                $team_rank_item = ProjectTeamRankItem::select('project_id', 'type_id', 'title')->where(['project_id' => Crypt::decrypt($projectId), 'type_id' => 1])->get();
                $attracting = $row;
                $today_day_arabic = $date_obj->date('l', time());
                $team_rank_type_trans = '';
                $project_title = Project::select('title')->where('id', Crypt::decrypt($projectId))->value('title');
                $pdf_preview = 0;
                $tid = 1;
                $typeTddb = Crypt::encrypt($tid);
                $contractOutPut = $this->loadContractInfoObserver($attracting, $team_rank_item, $logo, $today_day_arabic, $project_title, $pdf_preview);
                $contract_url = $this->generateContract($contractOutPut, $team_rank_type_trans);
                if (ProjectContracts::where('project_id', Crypt::decrypt($projectId))->where('type_id', Crypt::decrypt($typeTddb))->where('type_id', Crypt::decrypt($typeTddb))->where('user_id', Crypt::decrypt($teamuserId))
                    ->update([
                        'contract_url' => $contract_url['contract_url'],
                        'approved' => '1',
                        'user_id' => $request->case == 'observer' ? Crypt::decrypt($teamuserId) : null
                    ])
                ) {
                    return redirect('https://al-fares.sa');
                }
            } else {
                $row = AttractingTeam::with('type', 'region', 'city')
                    ->select('id', 'name', 'national_id', 'mobile', 'region_id', 'city_id', 'email', 'type_id')
                    ->where('id', Crypt::decrypt($teamuserId))
                    ->firstOrFail();
                $date_obj = new Arabic('Date');
                $div_class = 'divContractPreview';
                $logo = 'assets/media/logos/alfares.jpg';
                $team_rank_item = ProjectTeamRankItem::select('project_id', 'type_id', 'title')->where(['project_id' => Crypt::decrypt($projectId), 'type_id' => $row->type_id])->get();
                $attracting = $row;
                $today_day_arabic = $date_obj->date('l', time());
                $team_rank_type_trans = $row->type->trans;
                $project_title = Project::select('title')->where('id', Crypt::decrypt($projectId))->first()->value('title');
                $pdf_preview = 0;
                $contract_research_items = ProjectContractResearchItem::where(['project_id' => Crypt::decrypt($projectId)])->with('realestateType');
                $contractOutPut = $this->loadContractInfo($attracting, $team_rank_item, $logo, $team_rank_type_trans, $today_day_arabic, $project_title, $pdf_preview, $contract_research_items);
                $contract_url = $this->generateContract($contractOutPut, $team_rank_type_trans);
                if (ProjectContracts::where('project_id', Crypt::decrypt($projectId))->where('type_id', Crypt::decrypt($typeTddb))->where('type_id', Crypt::decrypt($typeTddb))->where('team_user_id', Crypt::decrypt($teamuserId))
                    ->update([
                        'contract_url' => $contract_url['contract_url'],
                        'approved' => '1',
                        'user_id' => $request->case == 'observer' ? Crypt::decrypt($teamuserId) : null
                    ])
                ) {
                    return redirect('https://al-fares.sa');
                }
            }
        } else {
            if (! empty($request['rejection_reason'])) {
                if ($request->case == 'observer') {
                    if (ProjectContracts::where('project_id', Crypt::decrypt($projectId))->where('type_id', Crypt::decrypt($typeTddb))->where('type_id', Crypt::decrypt($typeTddb))->where('user_id', Crypt::decrypt($teamuserId))
                        ->update([
                            'contract_url' => '',
                            'approved' => '0',
                            'user_id' => $request->case == 'observer' ? Crypt::decrypt($teamuserId) : null,
                            'rejection_reason' => $request['rejection_reason']
                        ])
                    ) {
                        return redirect('https://al-fares.sa');
                    }
                } else {
                    if (ProjectContracts::where('project_id', Crypt::decrypt($projectId))->where('type_id', Crypt::decrypt($typeTddb))->where('type_id', Crypt::decrypt($typeTddb))->where('team_user_id', Crypt::decrypt($teamuserId))
                        ->update([
                            'contract_url' => '',
                            'approved' => '0',
                            'user_id' => $request->case == 'observer' ? Crypt::decrypt($teamuserId) : null,
                            'rejection_reason' => $request['rejection_reason']
                        ])
                    ) {
                        return redirect('https://al-fares.sa');
                    }
                }
            }
        }
    }

    public function handOverTask(Request $request)
    {
        $trainDate = [];
        if ($request->has("trainrequire")) :
            $trainDate = [
                'observer_training_date' => $request['observer_training_date'],
                'observer_training_required' => '1'
            ];
        else :
            $trainDate = [
                'observer_training_date' => NULL,
                'observer_training_required' => '0'
            ];
        endif;

        $isAuditorDoneTask = ProjectTransactionHistory::where('project_id', $request['project_id'])->where('status_id', 10)->where('is_done', '1')->count() > 0;
        $otherObserverNotDoneTask = ProjectTransactionHistory::where('project_id', $request['project_id'])->where('status_id', 9)->count();
        $otherObserverDoneTask = ProjectTransactionHistory::where('project_id', $request['project_id'])->where('status_id', 9)->where('is_done', '1')->count() + 1;
        $isCreateAccountsAppear = ProjectTransactionHistory::where('project_id', $request['project_id'])->where('status_id', 17)->where('is_done', '0')->count() == 0;
        $moveToTrainer = $otherObserverNotDoneTask == $otherObserverDoneTask ? true : false;

        if ($request['type_id'] == '9') {
            $this->COMMON_HELPER->handleCaptureTransaction($request, 21, '1');
            $this->COMMON_HELPER->handleCaptureTransaction($request, 22, '1', Auth::user()->id);
            $this->COMMON_HELPER->changeProjectStatus($request, 13);
        } elseif ($request['type_id'] == '12') {
            $this->COMMON_HELPER->handleCaptureTransaction($request, 9, '1');
            ProjectFinancialEstimate::where('project_id', $request['project_id'])->update($trainDate);
            if (ProjectFinancialEstimate::where('project_id', $request['project_id'])->where('is_espeical_training_needed', '1')->count() > 0) {
                if ($isAuditorDoneTask && $request->has("trainrequire")) {
                    $this->COMMON_HELPER->changeProjectStatus($request, 7);
                } else {
                    $this->COMMON_HELPER->changeProjectStatus($request, 9);
                }

                if ($moveToTrainer && $request->has("trainrequire")) {
                    $this->COMMON_HELPER->handleCaptureTransaction($request, 11, '0', 8);
                } else {
                    $this->COMMON_HELPER->handleCaptureTransaction($request, 17, '0', 9);
                }
            } else {
                if ($isAuditorDoneTask) {
                    $this->COMMON_HELPER->changeProjectStatus($request, 9);
                }
                $this->COMMON_HELPER->handleCaptureTransaction($request, 17, '0', 9);
            }
        } else {
            if ($request['is_trainer'] == 'true') {
                if ($isAuditorDoneTask) {
                    $this->COMMON_HELPER->changeProjectStatus($request, 13);
                }
                $this->COMMON_HELPER->handleCaptureTransaction($request, 22, '1');
                ProjectTrainingDetail::where('project_id', $request['project_id'])->update(['training_date' => $request['observer_training_date']]);
            } else {
                if ($moveToTrainer && $request->has("trainrequire")) {
                    $this->COMMON_HELPER->changeProjectStatus($request, 71);
                } elseif ($moveToTrainer) {
                    $this->COMMON_HELPER->changeProjectStatus($request, 9);
                }

                $this->COMMON_HELPER->handleCaptureTransaction($request, 9, '1');
                if ($request->has("trainrequire")) {
                    $this->COMMON_HELPER->handleCaptureTransaction($request, 11, '0', 8);
                } elseif ($isCreateAccountsAppear) {
                    $this->COMMON_HELPER->handleCaptureTransaction($request, 17, '0', 9);
                }
            }
        }
        $emailTo = [];
        $oldQE = ProjectFieldworkTeam::select('supervisor_qty', 'researcher_qty', 'old_supervisor_qty', 'old_researcher_qty')
            ->where('project_id', $request['project_id'])->where('user_id', Auth::user()->id)->first();

        if (($oldQE->old_supervisor_qty != 0 && ! is_null($oldQE->old_supervisor_qty)) ||
            ($oldQE->old_researcher_qty != 0 && ! is_null($oldQE->old_researcher_qty))) :

            $projectTitle = Project::find($request['project_id'])->title;
            $userName = Auth::user()->name;
            $route = url('/project/followup/' . $request['project_id']);

            $users = User::with('roles')->get();
            foreach ($users as $user) :
                if (($user->roles[0]->id == 3 && $user->roles[0]->name == 'operation') || ($user->roles[0]->id == 5 && $user->roles[0]->name == 'fieldwork')) :
                    $emailTo[] = $user->email;
                endif;
            endforeach;

            foreach ($emailTo as $to) :
                Mail::to($to)->send(new KaderChange($projectTitle, $userName, $route, $oldQE->old_supervisor_qty, $oldQE->old_researcher_qty, $oldQE->supervisor_qty, $oldQE->researcher_qty));
            endforeach;
        endif;
        return Redirect::to(url('/' . Auth::user()->roles[0]->name . '/projects'))->with('success', trans('site.mission_finished')); // redirect
    }

    public function handOverTour(Request $request)
    {
        $users = User::with('roles')->has('roles')->get();
        foreach ($users as $usr) :
            if ($usr->roles[0]->name == "operation" && $usr->roles[0]->id == 3) :
                static::$operationEmails[] = $usr->email;
            endif;
        endforeach;

        ProjectExploreTour::where('project_id', $request['project_id'])->update(['is_observer_done' => '1']);
        $currentProject = Project::find($request['project_id']);
        $route = url('/operations/' . $request['project_id'] . '/edit/' . $currentProject->status_id);
        $reminder = "no";
        try {
            foreach (static::$operationEmails as $email) :
                Mail::to($email)->send(new ProjectEndTour($currentProject->title, $route, $reminder));
            endforeach;
            return Redirect::to(url('/' . Auth::user()->roles[0]->name . '/projects/tour'))->with('success', trans('site.doneExplorationTour')); // redirect
        } catch (\Exception $e) {
            return response()->json(["MSG" => $e->getMessage()]);
        }
    }

    public function handOverCorrection(Request $request)
    {
        Project::where('id', $request['project_id'])->update(['is_training_correction' => '1']);
        return Redirect::to(url('/' . Auth::user()->roles[0]->name . '/correct-project'))->with('success', trans('site.doneCorrection')); // redirect
    }

    public function uploadTourFiles(Request $request)
    {
        $validatedData['file'] = ! empty($request->file) ? $this->uploadOne($request->file, 'tour') : null;
        ProjectTourFile::create([
            'explore_tour_id' => $request['tour_id'],
            'file_type' => $request['fileType'],
            'file' => $validatedData['file'],
        ]);
    }

    public function updateIsTrainersNeeded($project_id, $is_trainers_needed)
    {
        ProjectTrainingDetail::updateOrCreate(
            ['project_id' => $project_id],
            [
                'project_id' => $project_id,
                'is_trainers_needed' => $is_trainers_needed == 'true' ? '1' : '0',
            ],
        );
    }

    public function uploadTrainingFiles(Request $request)
    {
        $validatedData['file'] = ! empty($request->file) ? $this->uploadOne($request->file, 'tour') : null;
        ProjectTrainingDetail::updateOrCreate(
            ['project_id' => $request['project_id']],
            [
                'project_id' => $request['project_id'],
                'file' => $validatedData['file'],
            ],
        );
    }

    public function removeTourFile(Request $request)
    {
        $object = ProjectTourFile::where('id', $request['id'])->first();
        if (Storage::disk('public')->exists($object->file)) {
            Storage::disk('public')->delete($object->file);
        }

        if (ProjectTourFile::where('id', $request['id'])->delete()) {
            $arr = ['msg' => __('site.mission_completed'), 'status' => true];
        } else {
            $arr = ['msg' => __('site.error'), 'status' => false];
        }

        return response()->json($arr);
    }

    public function update()
    {
    }

    public function importResearcheres(Request $request)
    {
        $file = $request->imported_researchers;
        $filename = $file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension(); //Get extension of uploaded file
        $tempPath = $file->getRealPath();
        $fileSize = $file->getSize(); //Get size of uploaded file in bytes//Check for file extension and size
        $location = 'uploads'; //Created an "uploads" folder for that
        $file->move($location, $filename);
        $filepath = public_path($location . '/' . $filename);

        if ($xlsx = SimpleXLSX::parse($filepath)) {
            $array_ins = [];
            $team_user_id = [];
            $national_id = [];
            $excel_national_ids = $xlsx->rows();
            $project_id = $request->import_project_id;
            $superior_id = $request->import_superior_id;
            $researchers = AttractingTeam::where('type_id', 5)->whereIn('national_id', $excel_national_ids);

            // First Validate If Records are Exists
            if ($researchers->count() > 0) {
                //// Standard Code For all cases /////////////////////////////////////////////////
                foreach ($researchers->get() as $researcher) {
                    $team_user_id[] = $researcher->id;
                    $national_id[] = $researcher->national_id;
                    $array_ins[] = [
                        'team_user_id' => $researcher->id,
                        'type_id' => 5,
                        'project_id' => $project_id,
                        'superior_team_id' => $superior_id,
                        'qty' => 0,
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')
                    ];
                }

                /////////////////////////////Case Valid and Invalid National Ids/////////////////////////
                $invalid_national_ids = [];
                foreach ($excel_national_ids as $r) {
                    $invalid_national_ids[] = implode('', $r);
                }

                $valid_national_ids_checker = array_intersect($national_id, $invalid_national_ids);
                if (count(array_diff($invalid_national_ids, $national_id)) > 0) {
                    $researchers_after_check = AttractingTeam::where('type_id', 5)->whereIn('national_id', $valid_national_ids_checker);
                    foreach ($researchers_after_check->get() as $researcher) {
                        $res_id[] = $researcher->id;
                        $array_ins_after_check[] = [
                            'team_user_id' => $researcher->id,
                            'type_id' => 5,
                            'project_id' => $project_id,
                            'superior_team_id' => $superior_id,
                            'qty' => 0,
                            'created_at' => date('Y-m-d H:i:s'),
                            'updated_at' => date('Y-m-d H:i:s')
                        ];
                    }

                    $cc = ProjectObserverTeam::where(
                        [
                            'team_user_id' => $res_id,
                            'type_id' => 5,
                            'project_id' => $project_id,
                            'superior_team_id' => $superior_id
                        ]
                    );
                    if ($cc->count() == 0 && ProjectObserverTeam::insert($array_ins_after_check)) {
                        $msg['key'] = 'تم الإدخال بنجاح لكن لم يتم العثور على الهويات التالية';
                        $invalid_n_ids = implode('<br/>', array_diff($invalid_national_ids, $national_id));
                        $HTMLMessage = "<h4 class=\"card-title align-items-start flex-column\"><span class=\"card-label fw-bold text-danger\">لم يتم العثور على الهويات التالية</span></h4><br/>";
                        $msg['values'] = $HTMLMessage . '<span class="text-gray-900 fw-bolder fs-6">' . $invalid_n_ids . '</span>';
                        $arr = ['msg' => $msg, 'status' => 'info'];
                    }
                } else {
                    $check_before_insertProjectObserverTeam = ProjectObserverTeam::whereIn('team_user_id', $team_user_id)
                        ->where('type_id', 5)
                        ->where('project_id', $request->import_project_id)
                        ->where('superior_team_id', $request->import_superior_id);

                    if ($check_before_insertProjectObserverTeam->count() == 0) {
                        if (ProjectObserverTeam::insert($array_ins)) {
                            $arr = ['msg' => __('site.mission_completed'), 'status' => true];
                        }
                    } else {
                        $arr = ['msg' => 'بعض أرقام الهويه قد أدخلت من قبل', 'status' => 'duplicate'];
                    }
                }
            } else { // All National ids are invalid
                $msg['key'] = __('site.error');
                $HTMLMessage = "<h4 class=\"card-title align-items-start flex-column\"><span class=\"card-label fw-bold text-danger\">لم يتم العثور على الهويات التالية</span></h4><br/>";
                $msg['values'] = $HTMLMessage . '<span class="text-gray-900 fw-bolder fs-6">' . $xlsx->toHTML(0) . '</span>';
                $arr = ['msg' => $msg, 'status' => false];
            }

            return response()->json($arr);
        }
    }

    public function updateTeamQty(Request $request)
    {
        ProjectFinancialEstimate::updateOrCreate(
            ['project_id' => $request['project_id']],
            [
                'supervisor_qty' => $request['supervisor_qty'],
                'researcher_qty' => $request['researcher_qty']
            ],
        );

        $oldQ = ProjectFieldworkTeam::select('supervisor_qty', 'researcher_qty')
            ->where('project_id', $request['project_id'])
            ->where('user_id', Auth::user()->id)->first();

        ProjectFieldworkTeam::updateOrCreate(
            [
                'project_id' => $request['project_id'],
                'user_id' => Auth::user()->id
            ],
            [
                'old_supervisor_qty' => $oldQ->supervisor_qty,
                'old_researcher_qty' => $oldQ->researcher_qty,
                'supervisor_qty' => $request['supervisor_qty'],
                'researcher_qty' => $request['researcher_qty']
            ],
        );

        return back()->with('success', trans('site.update_completed'));
    }

    public function get_rejection_reason(Request $request)
    {
        return ProjectContracts::select('rejection_reason')->find($request->id);
    }
}