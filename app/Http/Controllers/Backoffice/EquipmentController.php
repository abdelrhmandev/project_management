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
use App\Models\ProjectFinancialEstimate;
use Illuminate\Support\Facades\DB;
use App\Traits\UploadAble;
use App\Models\ProjectKashefAccounts;
use App\Models\ProjectFieldworkTeam;
use Illuminate\Http\Request;
use App\Models\ProjectEquipments;
use App\Models\ProjectFamilyDevelopment;
use App\Models\ProjectEquipmentsFile;
use App\Models\ProjectLocalDevelopment;
use App\Models\ProjectInspectionVisit;
use App\Models\ProjectEmpowerCharity;
use App\Models\User;
use App\Models\ProjectEquipmentsDiv;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\Models\ProjectTransactionHistory;
use App\Models\ProjectTrainingType;
use App\Models\ProjectSurveyAccounts;
use App\Mail\EquipmentHandOver;

class EquipmentController extends Controller
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
        $this->resource = 'equipments';
        $this->blade_path = 'backoffice.equipment';
        $this->trans_file = 'project';
        $this->COMMON_HELPER = app('App\Helpers\Common');
    }

    public function index()
    {
        $this->blade_path = 'backoffice.equipment.index';
        $compact = [
            'rows' => $this->model::select('id', 'logo', 'title', 'building_count', 'cases_count', 'start_date', 'end_date', 'status_id', 'progress_bar')->where('status_id', '>=', 5)->latest()->paginate(12),
            'project_transaction_history' => ProjectTransactionHistory::get(),
            'trans_file' => $this->trans_file,
            'resource' => $this->resource,
            'status' => ProjectStatus::select('id', 'title', 'trans')->get(),
            'types' => ProjectType::select('id', 'title')->get(),
            'regions' => Region::select('id', 'title')->get(),
            'customers' => Customer::select('id', 'title')->get(),
            'equipments' => Equipment::get(),
            'counter' => $this->model::select('id', 'logo', 'title', 'building_count', 'cases_count', 'start_date', 'end_date', 'status_id', 'progress_bar')->where('status_id', '>=', 5)->count(),
        ];

        return view($this->blade_path, $compact);
    }

    public function edit(Request $request, $projectId)
    {
        $projectCurrentStatus = Project::select('status_id AS status')->where('id', $projectId)->first()->status;
        if (isset($request['status']) && $request['status'] == $projectCurrentStatus) :
            $this->blade_path = 'backoffice.equipment.edit';
        elseif (! isset($request['status'])) :
            $this->blade_path = 'backoffice.equipment.edit';
        else :
            return redirect('/equipment/projects');
        endif;

        $query = $this->model::with('status', 'type', 'region', 'customer', 'localDevelopment')->find($projectId);
        $compact = [
            'trans_file' => $this->trans_file,
            'resource' => $this->resource,
            'row' => $query,
            'users' => ProjectTransactionHistory::with('user')->where('project_id', $projectId)->groupBy('user_id')->get(),
            'project_admin' => User::where('id', 2)->first(),
            'project_transaction_history' => ProjectTransactionHistory::where("project_id", $projectId)->where("status_id", 8)->first(),
            'equipments' => Equipment::get(),
            'project_equipments_files' => ProjectEquipmentsFile::where("project_id", $projectId)->get(),
            'project_equipments' => DB::table('project_equipments as pe')->leftJoin('equipments as e', 'e.id', '=', 'pe.equipment_id')
                ->select('pe.id', 'pe.qty', 'pe.price', 'pe.equipment_type', 'e.title', 'pe.send_equipment_receipt', 'pe.equipment_id')->where("project_id", $projectId)->get(),
            'equipment_type' => EquipmentType::get(),
            'training' => ProjectTrainingType::where('project_id', $projectId)->first(),
            'project_empower_charity' => ProjectEmpowerCharity::where('project_id', $projectId)->first(),
            'financial_bid_estimate' => ProjectFinancialEstimate::where("project_id", $projectId)->first(),
            'project_family_development' => ProjectFamilyDevelopment::where("project_id", $projectId)->first(),
            'project_local_development' => ProjectLocalDevelopment::where("project_id", $projectId)->first(),
            'supervisors' => DB::table('project_observer_team AS POT')->join("attracting_team", "attracting_team.id", "=", "POT.team_user_id")
                ->select('attracting_team.id AS ID', 'name', 'email', 'avatar', 'mobile', 'region_id')
                ->where("project_id", $projectId)->where("attracting_team.type_id", '4')->get(),
            'remaining_equipment' => DB::table('project_equipments as equip')->leftJoin('project_equipments_division as divi', 'equip.equipment_id', '=', 'divi.equipment_id')
                ->select('equip.equipment_id as equipment_id', DB::raw('round((equip.qty - COALESCE(divi.amount,0)), 0) as remain'))->groupBy('equip.project_id', 'equip.equipment_id')
                ->where("equip.project_id", $projectId)->get(),
        ];

        return view($this->blade_path, $compact);
    }

    public static function _eqDivFiles(Request $req)
    {
        $err = [];
        $arr = [];
        $old = ProjectEquipmentsDiv::select('files')->where('equipment_id', $req['eqID'])
            ->where('equipment_type', $req['eqType'])
            ->where('project_id', $req['project'])
            ->where('observer_id', $req['observer']);

        if ($req['observer'] == "-1") {
            $err['observer'] = "يجب اختيار المشرف";
        }
        if (! $req->filled('amount')) {
            $err['amount'] = "يجب ادخال الكمية";
        }
        if ($req->filled('amount') && ! is_numeric($req['amount'])) {
            $err['amount'] = "يجب ان تكون الكمية رقم";
        }

        if (! $req->filled('notes')) {
            $err['notes'] = "يجب ادخال الملاحظات";
        }

        if ($req->hasFile('file')) :
            $target = storage_path() . '/app/public/uploads/projects/division';
            $source = $req['file']->getClientOriginalName();
            $req['file']->move($target, $source);
            $ext = $req['file']->getClientOriginalExtension();

            $out = storage_path() . "/app/public/uploads/projects/division/" . uniqid(date('t-M')) . "." . $ext;
            rename(storage_path() . "/app/public/uploads/projects/division/" . $source, $out);
            if ($old->exists()) {
                if (isset($old->first()->files) && ! is_null($old->first()->files)) {
                    $files = json_decode($old->first()->files, true);
                    $files['F-' . rand(100, 900)] = stristr($out, "/uploads/");
                } else {
                    $files = [];
                    $files['F-' . rand(100, 900)] = stristr($out, "/uploads/");
                }
            } else {
                $files = [];
                $files['F-' . rand(100, 900)] = stristr($out, "/uploads/");
            }
        else :
            $err['file'] = "يجب  أرفاق ملف واحد على الاقل";
        endif;

        $divQ = ProjectEquipmentsDiv::selectRaw('SUM(amount) AS Q')->where('equipment_id', $req['eqID'])
            ->where('equipment_type', $req['eqType'])
            ->where('project_id', $req['project'])->first()->Q ?? 0;
        $remainQ = intval($req['eqQty']) - $divQ;

        if ($req['status'] == "edit") {
            $arr = [
                'notes' => strip_tags(trim($req['notes'])),
                'updated_at' => DB::raw('NOW()')
            ];
        } else {
            if (intval($req['amount']) > intval($req['eqQty'])) {
                $err['amount'] = "يجب ان تكون الكمية اقل من او يساوي الكمية المطلوبة :{$req['eqQty']}";
            } else if (intval($req['amount']) > $remainQ) {
                $err['amount'] = "يجب ان تكون الكمية اقل من او يساوي الكمية المتبقية :{$remainQ}";
            }

            $arr = [
                'amount' => $req['amount'],
                'notes' => strip_tags(trim($req['notes'])),
                'files' => @json_encode($files),
                'created_at' => DB::raw('NOW()')
            ];
        }

        if (count($err) == 1) {
            ProjectEquipmentsDiv::updateOrCreate([
                'equipment_id' => $req['eqID'],
                'equipment_type' => $req['eqType'],
                'project_id' => $req['project'],
                'observer_id' => $req['observer']
            ], $arr);
            return response()->json(['MSG' => "تم تقسيم التجهيز بنجاح", 'code' => 200]);
        } else {
            return response()->json(['err' => $err, 'code' => 400]);
        }
    }

    static public function _eqDivGetFiles(Request $req)
    {
        $out = "";
        $files = ProjectEquipmentsDiv::select('observer_id', 'amount', 'notes', 'files')->where('equipment_id', $req['E'])
            ->where('equipment_type', '1')
            ->where('project_id', $req['P'])
            ->where('observer_id', $req['O'])->first();

        if (isset($files->files) && ! is_null($files->files)) {
            $data = json_decode($files->files, true);

            foreach ($data as $k => $v) :

                if (pathinfo(asset('storage' . $v), PATHINFO_EXTENSION) == 'pdf') {
                    $f = asset('storage' . $v);
                    $ext = asset('assets/media/svg/files/pdf.svg');
                    $d = "<a href='{$f}'>
          <img class='py-2' data-dz-thumbnail='' alt='1' src='{$ext}' width='120px' height='120px'>
      </a>";

                } else {
                    $f = asset('storage' . $v);
                    $d = "<a class='d-block overlay' data-fslightbox='lightbox-basic' href='{$f}'>
            <img data-dz-thumbnail='' alt='' src='{$f}' width='120px' height='120px'>
        </a>";
                }

                $out .= "<div class='dz-preview dz-processing dz-image-preview dz-success dz-complete' data-file='{$k}'>
        <div class='dz-image'>
           $d
        </div>
        <div class='dz-progress'>
            <span class='dz-upload' data-dz-uploadprogress='' style='width: 100%;'></span>
        </div>
        <div class='dz-error-message'><span data-dz-errormessage=''></span>
        </div>
        <div class='dz-success-mark'>
            <svg width='54px' height='54px' viewBox='0 0 54 54' version='1.1' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink'>
                <title>Check</title>
                <g stroke='none' stroke-width='1' fill='none' fill-rule='evenodd'>
                    <path d='M23.5,31.8431458 L17.5852419,25.9283877 C16.0248253,24.3679711 13.4910294,24.366835 11.9289322,25.9289322 C10.3700136,27.4878508 10.3665912,30.0234455 11.9283877,31.5852419 L20.4147581,40.0716123 C20.5133999,40.1702541 20.6159315,40.2626649 20.7218615,40.3488435 C22.2835669,41.8725651 24.794234,41.8626202 26.3461564,40.3106978 L43.3106978,23.3461564 C44.8771021,21.7797521 44.8758057,19.2483887 43.3137085,17.6862915 C41.7547899,16.1273729 39.2176035,16.1255422 37.6538436,17.6893022 L23.5,31.8431458 Z M27,53 C41.3594035,53 53,41.3594035 53,27 C53,12.6405965 41.3594035,1 27,1 C12.6405965,1 1,12.6405965 1,27 C1,41.3594035 12.6405965,53 27,53 Z' stroke-opacity='0.198794158' stroke='#747474' fill-opacity='0.816519475' fill='#FFFFFF'></path>
                </g>
            </svg>
        </div>
        <div class='dz-error-mark'>
            <svg width='54px' height='54px' viewBox='0 0 54 54' version='1.1' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink'>
                <title>Error</title>
                <g stroke='none' stroke-width='1' fill='none' fill-rule='evenodd'>
                    <g stroke='#747474' stroke-opacity='0.198794158' fill='#FFFFFF' fill-opacity='0.816519475'>
                        <path d='M32.6568542,29 L38.3106978,23.3461564 C39.8771021,21.7797521 39.8758057,19.2483887 38.3137085,17.6862915 C36.7547899,16.1273729 34.2176035,16.1255422 32.6538436,17.6893022 L27,23.3431458 L21.3461564,17.6893022 C19.7823965,16.1255422 17.2452101,16.1273729 15.6862915,17.6862915 C14.1241943,19.2483887 14.1228979,21.7797521 15.6893022,23.3461564 L21.3431458,29 L15.6893022,34.6538436 C14.1228979,36.2202479 14.1241943,38.7516113 15.6862915,40.3137085 C17.2452101,41.8726271 19.7823965,41.8744578 21.3461564,40.3106978 L27,34.6568542 L32.6538436,40.3106978 C34.2176035,41.8744578 36.7547899,41.8726271 38.3137085,40.3137085 C39.8758057,38.7516113 39.8771021,36.2202479 38.3106978,34.6538436 L32.6568542,29 Z M27,53 C41.3594035,53 53,41.3594035 53,27 C53,12.6405965 41.3594035,1 27,1 C12.6405965,1 1,12.6405965 1,27 C1,41.3594035 12.6405965,53 27,53 Z'></path>
                    </g>
                </g>
            </svg>
        </div>
        
    </div>";
            endforeach;
        }

        return response()->json(['out' => $out, 'obs' => $files->observer_id, 'qty' => $files->amount, 'note' => $files->notes]);
    }

    public static function _eqDiv(Request $req)
    {
        $err = [];
        if ($req['observer'] == "-1") {
            $err['observer'] = "يجب اختيار المراقب";
        }
        if (! $req->filled('amount')) {
            $err['amount'] = "يجب ادخال الكمية";
        }
        if ($req->filled('amount') && ! is_numeric($req['amount'])) {
            $err['amount'] = "يجب ان تكون الكمية رقم";
        }

        if (! $req->filled('notes')) {
            $err['notes'] = "يجب ادخال الملاحظات";
        }

        $divQ = ProjectEquipmentsDiv::selectRaw('SUM(amount) AS Q')->where('equipment_id', $req['eqID'])
            ->where('equipment_type', $req['eqType'])
            ->where('project_id', $req['project'])->first()->Q ?? 0;
        $remainQ = intval($req['eqQty']) - $divQ;

        if ($req['status'] == "edit") {
            $arr = [
                'notes' => strip_tags(trim($req['notes'])),
                'updated_at' => DB::raw('NOW()')
            ];
        } else {
            if (intval($req['amount']) > intval($req['eqQty'])) {
                $err['amount'] = "يجب ان تكون الكمية اقل من او يساوي الكمية المطلوبة :{$req['eqQty']}";
            } else if (intval($req['amount']) > $remainQ) {
                $err['amount'] = "يجب ان تكون الكمية اقل من او يساوي الكمية المتبقية :{$remainQ}";
            }

            $arr = [
                'amount' => $req['amount'],
                'notes' => strip_tags(trim($req['notes'])),
                'created_at' => DB::raw('NOW()')
            ];
        }

        if (empty($err)) {
            ProjectEquipmentsDiv::updateOrCreate([
                'equipment_id' => $req['eqID'],
                'equipment_type' => $req['eqType'],
                'project_id' => $req['project'],
                'observer_id' => $req['observer']
            ], $arr);
            return response()->json(['MSG' => "تم تقسيم التجهيز بنجاح", 'code' => 200]);
        } else {
            return response()->json(['err' => $err, 'code' => 400]);
        }

    }

    static public function _eqElohade(Request $request, $projectID)
    {
        $team = [];
        $q = Project::with('status', 'type', 'region', 'customer', 'localDevelopment')->find($projectID);
        $observers = DB::table('project_observer_team AS POT')
            ->join('users AS U', 'U.id', '=', 'POT.superior_id')
            ->distinct()
            ->select('U.id AS ID', 'name')
            ->where('POT.project_id', $projectID)
            ->get();

        foreach ($observers as $k => $v) :
            $team[$k]['ID'] = $v->ID;
            $team[$k]['name'] = $v->name;

            $supervisors = DB::table('project_observer_team AS POT')
                ->join('attracting_team AS AT', 'AT.id', '=', 'POT.team_user_id')
                ->select('AT.id AS ID', 'POT.team_user_id AS TUID', 'name', 'enrolled_date', 'accomplished_projects', 'performance_percentage', 'is_good', 'notes', 'equipments')
                ->where('POT.type_id', 4)
                ->where('POT.project_id', $projectID)
                ->where("superior_id", $v->ID)
                ->get();
            foreach ($supervisors as $kk => $vv) {
                $team[$k]['supervisors'][$kk] = [
                    'id' => $vv->ID,
                    'name' => $vv->name,
                    'enrolled_date' => $vv->enrolled_date,
                    'accomplished_projects' => $vv->accomplished_projects,
                    'performance_percentage' => $vv->performance_percentage,
                    'is_good' => $vv->is_good,
                    'notes' => $vv->notes,
                    'equipments' => $vv->equipments
                ];

                $researchers = DB::table('project_observer_team AS POT')
                    ->join('attracting_team AS AT', 'AT.id', '=', 'POT.team_user_id')
                    ->select('AT.id AS ID', 'POT.team_user_id AS TUID', 'name', 'enrolled_date', 'accomplished_projects', 'performance_percentage', 'is_good', 'notes', 'equipments')
                    ->where('POT.type_id', 5)
                    ->where('POT.project_id', $projectID)
                    ->where("superior_team_id", $vv->ID)
                    ->get();

                foreach ($researchers as $kkk => $vvv) {
                    $team[$k]['supervisors'][$kk]['researchers'][$kkk] = [
                        'id' => $vvv->ID,
                        'name' => $vvv->name,
                        'enrolled_date' => $vvv->enrolled_date,
                        'accomplished_projects' => $vvv->accomplished_projects,
                        'performance_percentage' => $vvv->performance_percentage,
                        'is_good' => $vvv->is_good,
                        'notes' => $vvv->notes,
                        'equipments' => $vvv->equipments
                    ];

                }
            }

        endforeach;
        // return $team;
        return view('backoffice.equipment._EqElohades')->with(['row' => $q, 'allTeam' => $team]);
    }

    public function UploadProjectEquipmentFile(Request $request)
    {
        $uploads = "";
        $target = storage_path() . '/app/public/uploads/project_equipment_files';
        $eqFiles = ProjectEquipmentsFile::select('file')
            ->where('project_id', $request['project_id'])
            ->where('equipment_type', $request['equipment_type'])
            ->where('user_id', Auth::user()->id);
        $exits = $eqFiles->exists();
        if ($exits) :
            $getFiles = $eqFiles->first()->file;
        else :
            $getFiles = "";
        endif;

        if ($request->hasFile('file')) :
            $file = $request['file'];
            $source = $file->getClientOriginalName();
            $file->move($target, $source);
            $ext = $file->getClientOriginalExtension();
            $out = storage_path() . '/app/public/uploads/project_equipment_files/' . uniqid(date('t-M')) . "." . $ext;
            $filePath = stristr($out, "uploads/");
            if ($getFiles == "") {
                $uploads .= $filePath;
            } else {
                $uploads .= $filePath . "&&" . $getFiles;
            }
            rename(storage_path() . '/app/public/uploads/project_equipment_files/' . $source, $out);
        endif;

        ProjectEquipmentsFile::updateOrCreate(
            [
                'project_id' => $request['project_id'],
                'equipment_type' => $request['equipment_type'],
                "user_id" => Auth::user()->id
            ],
            [
                'file' => $uploads
            ]
        );

        $arr = array('msg' => __('site.mission_completed'), 'status' => true);
        return response()->json($arr);
    }

    public function RemoveProjectEquipmentFile(Request $request)
    {
        $eqFiles = ProjectEquipmentsFile::select('file')
            ->where('project_id', $request['projectId'])
            ->where('equipment_type', $request['eqType'])
            ->where('user_id', Auth::user()->id)
            ->first()->file;
        if ($request->has('file')) :
            if (str_contains($eqFiles, "&&")) {
                $chunks = explode('&&', $eqFiles);
                unset($chunks[array_search($request['file'], $chunks)]);
                $newFiles = join('&&', $chunks);
            } else {
                $newFiles = NULL;
            }
        endif;

        ProjectEquipmentsFile::where('project_id', $request['projectId'])
            ->where('equipment_type', $request['eqType'])
            ->where('user_id', Auth::user()->id)
            ->update([
                "file" => $newFiles
            ]);

        $arr = ['msg' => __('site.mission_completed'), 'status' => true];
        return response()->json($arr);
    }

    public function saveShipReceipt(Request $request)
    {
        $col = '';
        if ($request->path() == "equipment/save-ship-receipt/handover") {
            $col = "return_equipment_receipt";
        } else {
            $col = "send_equipment_receipt";
        }

        if (! empty($request['equipment_id'])) {
            $rowNo = count($request['equipment_id']);
            for ($i = 0; $i < $rowNo; $i++) {
                ProjectEquipments::where('project_id', '=', $request["project_id"])->where('equipment_id', '=', $request['equipment_id'][$i])->update([$col => '1']);
            }

            ProjectEquipments::where('project_id', '=', $request["project_id"])->whereNotIn('equipment_id', $request['equipment_id'])->update([$col => '0']);
        } else {
            ProjectEquipments::where('project_id', '=', $request["project_id"])->update([$col => '0']);
        }

        return back()->with('success', trans('site.updateMessageSuccess'));
    }

    public function handOverTask(Request $request)
    {
        if (! empty($request->equipment_id)) {
            $project_equipments = DB::table('project_equipments as pe')->leftJoin('equipments as e', 'e.id', '=', 'pe.equipment_id')->select('pe.id', 'pe.qty', 'pe.price', 'e.type_id', 'e.title', 'pe.send_equipment_receipt', 'pe.equipment_id')->where("project_id", $request->project_id)->count();
            if (count($request->equipment_id) == $project_equipments) {
                $this->COMMON_HELPER->handleCaptureTransaction($request, 8, '1');
            } else {
                return back()->with('error', 'يجب توفير كل التجهزيات الفرعيه المتاحه حتي يمكنك  إنهاء و تسليم المهمة');
            }
        } else {
            $this->COMMON_HELPER->handleCaptureTransaction($request, 8, '1');
        }

        return Redirect::to(url('/' . Auth::user()->roles[0]->name . '/projects'))->with('success', trans('site.mission_finished')); // redirect
    }

    public function showAccounts($projectId)
    {
        $query = $this->model::with('status', 'type', 'region', 'customer', 'localDevelopment')->find($projectId);
        $this->blade_path = 'backoffice.equipment.show-accounts';
        $compact = [
            'trans_file' => $this->trans_file,
            'resource' => $this->resource,
            'row' => $query,
            'project_admin' => User::where('id', 2)->first(),
            'project_fieldwork_teams' => ProjectFieldworkTeam::where("project_id", $projectId)->with('user', 'type')->paginate(12),
            'financial_bid_estimate' => ProjectFinancialEstimate::where("project_id", $projectId)->first(),
            'project_family_development' => ProjectFamilyDevelopment::where("project_id", $projectId)->first(),
            'project_local_development' => ProjectLocalDevelopment::where("project_id", $projectId)->first(),
            'project_inspection_visit' => ProjectInspectionVisit::where('project_id', $projectId)->first(),
            'project_empower_charity' => ProjectEmpowerCharity::where('project_id', $projectId)->first(),
            'kashef_accounts' => ProjectKashefAccounts::where("project_id", $projectId)->first(),
            'survey_accounts' => ProjectSurveyAccounts::where("project_id", $projectId)->first(),
            'project_transaction_history' => ProjectTransactionHistory::where("project_id", $projectId)->where("status_id", 17)->first(),
        ];

        return view($this->blade_path, $compact);
    }

    public function _deactivateProjects()
    {
        $this->blade_path = 'backoffice.equipment._deactivateProjects';
        $compact = [
            'rows' => Project::select('projects.id AS id', 'logo', 'title', 'building_count', 'cases_count', 'start_date', 'end_date', 'status_id', 'progress_bar', 'projects.created_at AS created_at')
                ->join("deactivate_kashef_accounts", "deactivate_kashef_accounts.project_id", "=", "projects.id")->groupBy('deactivate_kashef_accounts.project_id')->latest()->paginate(12),
            'project_transaction_history' => ProjectTransactionHistory::get(),
            'trans_file' => $this->trans_file,
            'resource' => $this->resource,
            'status' => ProjectStatus::select('id', 'title', 'trans')->get(),
            'types' => ProjectType::select('id', 'title')->get(),
            'regions' => Region::select('id', 'title')->get(),
            'customers' => Customer::select('id', 'title')->get(),
            'equipments' => Equipment::get(),
        ];

        return view($this->blade_path, $compact);
    }

    public function _showDeactivateAccounts($projectId)
    {
        $query = $this->model::with('status', 'type', 'region', 'customer', 'localDevelopment')->find($projectId);
        $this->blade_path = 'backoffice.equipment._showDeactivateAccounts';
        $daccounts = DB::table('attracting_team')->select('name', 'mobile', 'email', 'deactivate_kashef_accounts.type_id AS type', 'superior_team_id')
            ->join("deactivate_kashef_accounts", "deactivate_kashef_accounts.team_user_id", "=", "attracting_team.id")
            ->whereIn('deactivate_kashef_accounts.type_id', [4, 5])->where('project_id', $projectId)->get();

        $compact = [
            'trans_file' => $this->trans_file,
            'resource' => $this->resource,
            'row' => $query,
            'project_admin' => User::where('id', 2)->first(),
            'project_fieldwork_teams' => ProjectFieldworkTeam::where("project_id", $projectId)->with('user', 'type')->paginate(12),
            'financial_bid_estimate' => ProjectFinancialEstimate::where("project_id", $projectId)->first(),
            'project_family_development' => ProjectFamilyDevelopment::where("project_id", $projectId)->first(),
            'project_local_development' => ProjectLocalDevelopment::where("project_id", $projectId)->first(),
            'project_inspection_visit' => ProjectInspectionVisit::where('project_id', $projectId)->first(),
            'project_empower_charity' => ProjectEmpowerCharity::where('project_id', $projectId)->first(),
            'kashef_accounts' => ProjectKashefAccounts::where("project_id", $projectId)->first(),
            'deactivateAccounts' => $daccounts,
        ];

        return view($this->blade_path, $compact);
    }

    public function _exportExcel(Request $req)
    {
        $projectId = $req['projectId'];
        $title = Project::findOrFail($projectId)->title;
        return \Excel::download(new \App\Exports\ExcelExportObserver($projectId), 'فريق العمل - ' . $title . '.xlsx');
    }

    public function accountsCreated(Request $request)
    {
        $project_observer_team = DB::table('project_observer_team')->where('project_id', $request->project_id)->where('approved_member', '1');
        $project_auditor_team = DB::table('project_auditor_team')->where('project_id', $request->project_id)->where('approved_member', '1');
        if ($project_observer_team->count() == $project_observer_team->where('created_kashef', '1')->count() && $project_auditor_team->count() == $project_auditor_team->where('created_kashef', '1')->count()) {
            $this->COMMON_HELPER->changeProjectStatus($request, 10);
            $this->COMMON_HELPER->handleCaptureTransaction($request, 17, '1');
            $this->COMMON_HELPER->handleCaptureTransaction($request, 18, '0', 5);
        } else {
            return back()->with('error', 'يجب إضافة كل أفراد فريق العمل الخاص بالباحثين والمدققين حتي يمكنك إنهاء و تسليم المهمة');
        }

        if (($request->is_send_kashif_accounts == null)) {
            $projectId = $request->project_id;
            $userIdT1 = '';
            $userIdT2 = '';

            $fieldwork_teams = ProjectFieldworkTeam::where("project_id", $request->project_id)->with('user', 'type')->get();
            foreach ($fieldwork_teams as $fieldwork_team) {
                if ($fieldwork_team->type_id == 1) {
                    $userIdT1 .= $fieldwork_team->user_id;
                }
                if ($fieldwork_team->type_id == 2) {
                    $userIdT2 .= $fieldwork_team->user_id;
                }
            }

            // Type 1 Code
            $T1Q = \App\Models\ProjectObserverTeam::where("project_observer_team.project_id", $projectId)->leftJoin('project_contracts as con', 'project_observer_team.project_id', '=', DB::raw('con.project_id and project_observer_team.team_user_id = con.team_user_id'))
                ->leftJoin('attracting_team as attract', 'attract.id', '=', 'project_observer_team.team_user_id')
                ->where('approved_member', '1')->with('type', 'superior', 'teamSuperior', 'children')
                ->where(DB::raw('(project_observer_team.superior_id'), DB::raw($userIdT1 . ' OR project_observer_team.superior_team_id IN(select team_user_id from project_observer_team where superior_id = ' . $userIdT1 . ' and project_id = ' . $projectId . '))'))->get();

            $T2Q = \App\Models\ProjectAuditorTeam::where("project_auditor_team.project_id", $projectId)->leftJoin('project_contracts as con', 'project_auditor_team.project_id', '=', DB::raw('con.project_id and project_auditor_team.team_user_id = con.team_user_id'))
                ->leftJoin('attracting_team as attract', 'attract.id', '=', 'project_auditor_team.team_user_id')
                ->where('approved_member', '1')->with('user', 'type', 'superior')
                ->where('project_auditor_team.superior_id', DB::raw($userIdT2))->get();

            $project = Project::select('title')->where('id', $projectId)->first();
            $kashef_accounts = ProjectKashefAccounts::select('url')->where('project_id', $projectId)->first();
            // Send Mail For team 1
            foreach ($T1Q as $value) {
                $email = $value->email;
                if ($request->is_kashif_accounts_changed == 1) {
                    if (! (empty($request->kashif_email_accounts_prefix))) {
                        $email = strstr($email, '@', true) . $request->kashif_email_accounts_prefix . strstr($email, '@');
                    }
                }
                $mailData = [
                    'project_title' => $project->title,
                    'email' => $email,
                    'url' => $kashef_accounts->url,
                ];
                Mail::to($value->email)->send(new EquipmentHandOver($mailData));
            }
            // Send Mail For team 2
            foreach ($T2Q as $value) {
                $email = $value->email;
                if ($request->is_kashif_accounts_changed == 1) {
                    if (! (empty($request->kashif_email_accounts_prefix))) {
                        $email = strstr($email, '@', true) . $request->kashif_email_accounts_prefix . strstr($email, '@');
                    }
                }
                $mailData = [
                    'project_title' => $project->title,
                    'email' => $email,
                    'url' => $kashef_accounts->url,
                ];
                Mail::to($value->email)->send(new EquipmentHandOver($mailData));
            }
        }

        return Redirect::to(url('/' . Auth::user()->roles[0]->name . '/projects'))->with('success', trans('site.mission_completed')); // redirect
    }
}