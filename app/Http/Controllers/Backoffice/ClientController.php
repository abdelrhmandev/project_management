<?php

namespace App\Http\Controllers\Backoffice;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\ProjectTrainingType;
use App\Models\ProjectInspectionVisit;
use App\Models\ProjectEmpowerCharity;
use App\Models\ProjectRedFlagAttachment;
use App\Models\ProjectEquipments as PEQ;
use App\Models\ProjectStatus;
use App\Models\ProjectType;
use App\Models\Region;
use App\Models\Customer;
use App\Models\Equipment;
use App\Models\TeamRankType;
use App\Models\User;
use App\Models\ProjectLocalDevelopment;
use App\Models\ProjectObserverTeam;
use App\Models\ProjectFinancialEstimate;
use App\Models\ProjectKashefAccounts;
use App\Models\ProjectSurveyAccounts;
use App\Models\ProjectTransactionHistory;
use App\Models\ProjectFieldworkTeam;
use App\Models\ProjectFamilyDevelopment;
use App\Models\ProjectClientAttachments;
use App\Models\ProjectRequirements;
use App\Models\ProjectRedFlag;
use App\Models\ProjectExecutivePlanning;
use App\Models\ProjectOutcome;
use App\Traits\UploadAble;
use Illuminate\Http\Request;
use App\Mail\ProjectNotApproved;

class ClientController extends Controller
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
        $this->blade_path = 'backoffice.client.index';
        $compact = [];
        return view($this->blade_path, $compact);
    }

    public function projects()
    {
        $this->blade_path = 'backoffice.client.projects';
        $row = $this->model::with('status')->leftJoin('customers', 'customers.id', '=', 'projects.customer_id')
            ->select('projects.status_id', 'projects.id', 'projects.logo', 'projects.title', 'projects.cases_count', 'projects.start_date', 'projects.end_date', 'projects.status_id', 'projects.progress_bar', 'projects.created_at')->where('customers.user_id', Auth::user()->id);
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
            'list' => 'قائمه المشاريع',
            'placeholder' => 'إسم المشروع',
            'title' => 'المشاريع',
        ];
        return view($this->blade_path, $compact);
    }

    public function followup(Request $req, $id)
    {
        $query = Project::with('status', 'type', 'region', 'customer', 'localDevelopment', 'ExecutivePlanning')->find($id);
        $this->blade_path = 'backoffice.client.followup';
        $users = ProjectTransactionHistory::select('project_id', 'user_id')->with('user')->where('project_id', $id)->get();
        $teamMembers = ProjectObserverTeam::selectRaw('name, national_id, occupation, qualification_id,attracting_team.type_id AS type')
            ->join("attracting_team", "attracting_team.id", "=", "project_observer_team.team_user_id")
            ->where("project_id", $id)->orderBy("project_observer_team.created_at", "ASC")->paginate(4);

        $compact = [
            'trans_file' => $this->trans_file,
            'resource' => $this->resource,
            'row' => $query,
            'maps' => DB::table('project_maps')->where("project_id",$id)->get(),
            'team_ranks' => TeamRankType::get(),
            'users' => $users,
            'project_admin' => User::where('id', 2)->first(),
            'project_fieldwork_teams' => ProjectFieldworkTeam::where("project_id", $id)->with('user', 'type')->paginate(12),
            'transactions_history' => ProjectTransactionHistory::select('status_id', 'is_done', 'created_at')->where('project_id', $id)->orderBy('is_done', 'ASC')->get(),
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
            'teamMembers' => $teamMembers,
            'files' => ProjectClientAttachments::select('id', 'file', 'user_add', 'user_edit', 'created_at', 'updated_at')->where('project_id', $id)->get(),
            'requirements' => ProjectRequirements::select('id', 'title', 'file', 'notes', DB::raw('DATE(created_at) AS date'))->where('project_id', $id)->get(),
            'outcomes' => ProjectOutcome::select('id', 'title', 'file', 'description', 'template', 'is_accepted', 'is_template_approved', 'template_reject_reason')->where('project_id', $id)->get(),
            'outcomesAccpted' => ProjectOutcome::where('project_id', $id)->where('is_template_approved', '1')->count(),
            'outcomesAll' => ProjectOutcome::where('project_id', $id)->count(), 'id' => $id ?? 0,
            'type' => $type ?? 'user',
            'messengerColor' => Auth::user()->messenger_color ?? $this->messengerFallbackColor,
            'dark_mode' => Auth::user()->dark_mode < 1 ? 'light' : 'dark',
            'coordinatex' => strstr($query->coordinates, ',', true) ?? '',
            'coordinatey' => explode(',', $query->coordinates, 2)[1] ?? '',
            'RedFlags' => ProjectRedFlag::where(['project_id' => $id, 'client_id' => Auth::user()->id])->get(),
            'RedFlagsCount' => ProjectRedFlag::where(['project_id' => $id, 'client_id' => Auth::user()->id])->count()
        ];
        if ($req->ajax()) {
            return view('backoffice.client.data', ['teamMembers' => $teamMembers]);
        } else {
            return view($this->blade_path, $compact);
        }
    }

    static public function _clientExcel(Request $req)
    {
        $project = (int) $req['projectID'];
        $projectName = Project::find($project)->title;
        $name = "فريق عمل العميل مشروع {$projectName}";
        return \Excel::download(new \App\Exports\ClientTeamExport($project), $name . '.xlsx');
    }

    public static function _clientFilter(Request $req)
    {
        $output = "";
        $teamMembers = ProjectObserverTeam::selectRaw('name, national_id, occupation, qualification_id,attracting_team.type_id AS type')
            ->join("attracting_team", "attracting_team.id", "=", "project_observer_team.team_user_id")
            ->where("project_id", $req['project'])
            ->where(function ($q) use ($req) {
                if ($req['teamtype'] == "-1") {
                    $q->whereIn('attracting_team.type_id', [4, 5]);
                } else {
                    $q->where('attracting_team.type_id', $req['teamtype']);
                }
            })
            ->orderBy("project_observer_team.created_at", "ASC")->get();
        foreach ($teamMembers as $v) :
            $rank = \App\Models\TeamRankType::find($v->type)->trans;
            $quali = \App\Models\Qualification::find($v->qualification_id)->title ?? "";
            $output .= "<div class='card card-xl-stretch tab-pane memb'>
            <div class='card-header cursor-pointer pt-5'>
                <h3 class='card-title align-items-start flex-column'>
                    <span class='card-label fw-bold fs-3 mb-1'>
                        {$v->name}
                    </span>
                </h3>
            </div>
            <div class='card-body py-3'>
                <div class='table-responsive'>
                    <table class='table align-middle gs-0 gy-3 fw-bold wmemb'>
                        <tr>
                            <td class='img'>
                                <img src='/assets/media/team/vuesax-linear-profile.png'
                                    alt=''>
                            </td>
                            <td>
                                <span>الدور</span>
                                <p>{$rank}</p>
                            </td>
                            <td class='img'>
                                <img src='/assets/media/team/vuesax-linear-user-square.png'
                                    alt=''>
                            </td>
                            <td>
                                <span>رقم الهوية</span>
                                <p>{$v->national_id}</p>
                            </td>
                        </tr>
                        <tr>
                            <td class='img'>
                                <img src='/assets/media/team/vuesax-linear-teacher.png'
                                    alt=''>
                            </td>
                            <td>
                                <span>المؤهل الدراسى</span>
                                <p>{$quali}</p>
                            </td>
                            <td class='img'>
                                <img src='/assets/media/team/vuesax-linear-briefcase.png'
                                    alt=''>
                            </td>
                            <td>
                                <span>المهنة</span>
                                <p>{$v->occupation}</p>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>";
        endforeach;
        echo $output;
    }

    public static function _delFile(Request $req)
    {
        ProjectClientAttachments::where('project_id', $req['P'])->where('id', '=', $req['F'])->delete();
    }

    public function redirectToKashef()
    {
        return redirect()->away("https://www.kashif-sa.com/tanmia/public/management/login")
            ->with('message', 'Something went wrong!')->withInput(["email" => 'aalshalfi@al-fares.sa']);
    }

    public static function _addClientFiles(Request $req)
    {
        if ($req->hasFile('file')) {
            $target = storage_path() . '/app/public/uploads/projects/client';
            $source = $req['file']->getClientOriginalName();
            $req['file']->move($target, $source);
            $ext = $req['file']->getClientOriginalExtension();
            $out = storage_path() . "/app/public/uploads/projects/client/" . uniqid(date('t-M')) . "." . $ext;
            rename(storage_path() . "/app/public/uploads/projects/client/" . $source, $out);
            ProjectClientAttachments::insert([
                'project_id' => $req['project_id'],
                'file' => stristr($out, "/uploads/"),
                'user_add' => Auth::user()->id,
                "created_at" => \DB::raw('NOW()')
            ]);

        } else {
            echo 'please select file';
        }
    }

    public static function _deleteClientFiles(Request $req)
    {
        ProjectClientAttachments::where('project_id', $req['ID'])->where('file', '=', $req['file'])->delete();
    }

    public function _addNewRequirement(Request $req)
    {
        $err = [];
        $ins = [];
        foreach ($req['req'] as $k => $v) :
            if ($v == "") {
                $err[$k] = "يجب إدخال عنوان الطلب";
            } else {
                $ins[] = [
                    "title" => $v,
                    "project_id" => $req['project'],
                    "client_id" => Auth::user()->id,
                    "created_at" => DB::raw('NOW()')
                ];
            }
        endforeach;
        if (empty($err)) {
            ProjectRequirements::insert($ins);
            return response()->json(['msg' => 'تم إرسال الطلب بنجاح', 'code' => 200]);
        } else {
            return response()->json(['err' => $err, 'code' => 401]);
        }
    }

    public function _delRequirement(Request $req)
    {
        ProjectRequirements::where([
            "id" => $req['R'],
            "project_id" => $req['P'],
        ])->delete();
    }

    public function _editRequirement(Request $req)
    {
        ProjectRequirements::where([
            "id" => $req['R'],
            "project_id" => $req['P'],
        ])->update([
                    "title" => $req['T'],
                    "updated_at" => DB::raw('NOW()')
                ]);
        $title = ProjectRequirements::select('title')->where([
            "id" => $req['R'],
            "project_id" => $req['P']
        ])->first()->title;

        echo $title;
    }

    public function _viewNRequirement(Request $req)
    {
        $req = ProjectRequirements::select('file', 'notes')->where('project_id', $req['P'])->where('id', $req['R'])->first();
        return response()->json(['req' => $req]);
    }

    public function _approveProject(Request $req)
    {
        if (! empty($req['projectId'])) {
            if (ProjectExecutivePlanning::where('project_id', $req['projectId'])->update([
                'is_approved' => '1',
                'created_at' => \DB::raw('NOW()')
            ])) {
                return response()->json(['msg' => 'تم أعتماد خطه المشروع بنجاح', 'status' => true, 'code' => 200]);
            }
        } else {
            return response()->json(['msg' => 'خطأ في أعتماد خطه المشروع', 'status' => false, 'code' => 401]);
        }
    }

    static public function _acceptOrReject(Request $req)
    {
        if ($req['C'] == 'A') {
            DB::beginTransaction();
            $value = ($req['C'] == 'A') ? '1' : '0';
            $msg = ($req['C'] == 'A') ? '<i class="bi bi-check-circle-fill text-success"></i>' : '<i class="bi bi-exclamation-circle-fill text-danger"></i>';
            try {
                ProjectOutcome::where([
                    'project_id' => $req['P'],
                    'id' => $req['ID']
                ])->update([
                            'is_accepted' => $value,
                            'updated_at' => DB::raw('NOW()')
                        ]);
                DB::commit();
                return response()->json(['MSG' => $msg, 'value' => $value]);
            } catch (\PDOException $e) {
                DB::rollBack();
                return response()->json(['MSG' => $e->getMessage()]);
            }
        }
    }

    static public function _addNOutcome(Request $req)
    {
        $ins = [];
        $err = [];
        foreach ($req['titleOut'] as $k => $v) :
            if (! empty($v) && ! empty($req['descOut'][$k]) && ! empty($req['fileOut'][$k])) :
                $target = storage_path() . '/app/public/uploads/projects';
                $source = $req['fileOut'][$k]->getClientOriginalName();
                $req['fileOut'][$k]->move($target, $source);
                $ext = $req['fileOut'][$k]->getClientOriginalExtension();
                $out = storage_path() . '/app/public/uploads/projects/' . \Str::random(25) . "." . $ext;
                rename(storage_path() . '/app/public/uploads/projects/' . $source, $out);
                $file = stristr($out, "uploads/");

                $ins[] = [
                    'project_id' => $req['project'],
                    'title' => $v,
                    'description' => $req['descOut'][$k],
                    'template' => $file,
                    'user_add' => Auth::user()->id,
                    'created_at' => DB::raw('NOW()')
                ];
            else :
                $err[] = "يجب أدخال جميع الحقول";
            endif;
        endforeach;
        if (empty($err)) {
            ProjectOutcome::insert($ins);
            return response()->json(["MSG" => "success", "code" => 200]);
        } else {
            return response()->json(["MSG" => $err[0], "code" => 400]);
        }
    }

    static public function _templateAcceptOrReject(Request $req)
    {
        DB::beginTransaction();
        try {
            foreach ($req['tOutcome'] as $k => $v) :
                $value = ($req['tStatus'][$k] == 'A') ? '1' : '0';
                ProjectOutcome::where('project_id', $req['project'])->where('id', $v)
                    ->update([
                        'is_template_approved' => $value,
                        'template_reject_reason' => $req['tRemarks'][$k] ?? ProjectOutcome::select('template_reject_reason AS coz')->where('project_id', $req['project'])->where('id', $v)->first()->coz ?? NULL
                    ]);
            endforeach;
            DB::commit();
            return back();
        } catch (\PDOException $e) {
            DB::rollBack();
            return response()->json(['MSG' => $e->getMessage()]);
        }
    }

    public function _notApproveProject(Request $req)
    {
        if (! (empty($req['rejection_note']))) {
            $rejection_file = NULL;
            if (! (empty($req['project_executive_rejection_file']))) {
                $target = storage_path() . '/app/public/uploads/projects/client';
                $source = $req['project_executive_rejection_file']->getClientOriginalName();
                $req['project_executive_rejection_file']->move($target, $source);
                $ext = $req['project_executive_rejection_file']->getClientOriginalExtension();
                $out = storage_path() . "/app/public/uploads/projects/client/" . uniqid(date('t-M')) . "." . $ext;
                rename(storage_path() . "/app/public/uploads/projects/client/" . $source, $out);
                $rejection_file = stristr($out, "/uploads/");
            }

            #send mail to project manager inform him that
            if (ProjectExecutivePlanning::where('project_id', $req['project_id'])->update([
                'rejection_file' => $rejection_file,
                'rejection_note' => $req['rejection_note'],
                'is_approved' => '0',
                'is_updated' => '0',
                'created_at' => \DB::raw('NOW()')
            ])) {

                $project = (int) $req['project_id'];
                $projectName = Project::find($project)->title;
                $mailData = ['project_title' => $projectName, 'url' => url('project/RejectedProjectsPlanning')];
                $user = User::whereHas('roles', function ($q) {
                    $q->where('id', 2);
                })->first();
                Mail::to($user->email)->send(new ProjectNotApproved($mailData));
                return response()->json(['url' => url('/client/projects/'), 'msg' => 'تم عدم أعتماد خطه المشروع بنجاح', 'status' => true, 'code' => 200]);
            }

        } else {
            return response()->json(['msg' => 'برجاء كتابه سبب رفض أعتماد المشروع', 'status' => false, 'code' => 401]);
        }
    }

    public function _storeRedflag(Request $req)
    {
        if (! (empty($req['redflag'])))
            $redflag_id = DB::table('project_red_flags')->insertGetId([
                "title" => strip_tags($req['redflag']) ?? NULL,
                "project_id" => $req['project_id'],
                "client_id" => Auth::user()->id,
                "created_at" => DB::raw('NOW()')
            ]);
        if ($redflag_id) {
            if (! (empty($req->file('RedFlag_file')))) {
                foreach ($req->file('RedFlag_file') as $key => $file) {
                    $target = storage_path() . '/app/public/uploads/projects/client';
                    $source = $file->getClientOriginalName();
                    $file->move($target, $source);
                    $ext = $file->getClientOriginalExtension();
                    $out = storage_path() . "/app/public/uploads/projects/client/" . uniqid(date('t-M')) . "." . $ext;
                    rename(storage_path() . "/app/public/uploads/projects/client/" . $source, $out);
                    $redflag_file = stristr($out, "/uploads/");
                    ProjectRedFlagAttachment::insert([
                        "redflag_id" => $redflag_id,
                        "file" => $redflag_file,
                    ]);
                }
            }
        }
        if (! (empty($req['redflag']))) {
            return response()->json(['icon' => 'success', 'msg' => 'تم إرسال البلاغ بنجاح', 'status' => true, 'code' => 200]);
        } else {
            return response()->json(['icon' => 'error', 'msg' => 'برجاء كتابه عنوان البلاغ', 'status' => false, 'code' => 401]);
        }
    }
}