<?php

namespace App\Http\Controllers\Backoffice;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\UploadAble;
use App\Models\Project;
use App\Models\ProjectStatus;
use App\Models\ProjectType;
use App\Models\Region;
use App\Models\Customer;
use App\Models\User;
use App\Models\Calendar;
use App\Models\ProjectTrainingType;
use App\Models\ProjectInspectionVisit;
use App\Models\ProjectEmpowerCharity;
use App\Models\ProjectLocalDevelopment;
use App\Models\ProjectOutcome;
use App\Mail\NewProjectAdded;
use App\Mail\NewProjectRejected;
use App\Mail\NewProjectUpdated;
use App\Models\ProjectExecutivePlanning;
use App\Models\ProjectRedFlag;
use App\Models\ProjectRedFlagReply;
use App\Models\ProjectRedFlagReplyAttachment;
use App\Mail\ProjectExecutivePlanningUpdated;
use App\Mail\ProjectWarning;
use Carbon\Carbon;
use App\Models\ProjectFinancialEstimate;
use App\Models\ProjectTeamRankItem;
use App\Models\ProjectTransactionHistory;
use Illuminate\Support\Facades\Storage;
use App\Models\ProjectFamilyDevelopment;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Notification;
use App\Notifications\ProjectNotification;
use App\Models\RejectedProject;
use App\Models\ProjectEquipments as PEQ;
use App\Models\Equipment;
use DataTables;

class ProjectController extends Controller
{
    protected $model;
    protected $resource;
    protected $trans_file;
    protected $blade_path;
    protected $COMMON_HELPER;
    public static $emails;
    use UploadAble;

    public function __construct(Project $model)
    {
        $this->middleware('seen', ['only' => ['edit']]);
        $this->model = $model;
        $this->resource = 'projects';
        $this->blade_path = 'backoffice.project';
        $this->trans_file = 'project';
        $this->COMMON_HELPER = app('App\Helpers\Common');
        static::$emails = [];
    }

    public function _replyRedflagPMAdmin(Request $request)
    {
        if (! (empty($request['redflagReply'])) && ! (empty($request->file('RedFlag_file')))) {
            ProjectRedFlag::where([
                'id' => $request['redflag_id'],
                'project_id' => $request['project_id'],
            ])->update(['status' => 'inprogress', 'type' => 'replied_by_pm']);

            $red_flag_reply_id = ProjectRedFlagReply::insertGetId([
                'reply' => strip_tags(trim($request['redflagReply'])) ?? NULL,
                'redflag_id' => $request['redflag_id'],
                'reply_user_id' => Auth::user()->id,
                'created_at' => DB::raw('NOW()')
            ]);

            // if (! (empty($request->file('RedFlag_file')))) {
            foreach ($request->file('RedFlag_file') as $key => $file) {
                $target = storage_path() . '/app/public/uploads/projects/client';
                $source = $file->getClientOriginalName();
                $file->move($target, $source);
                $ext = $file->getClientOriginalExtension();
                $out = storage_path() . "/app/public/uploads/projects/client/" . uniqid(date('t-M')) . "." . $ext;
                rename(storage_path() . "/app/public/uploads/projects/client/" . $source, $out);
                $redflag_file = stristr($out, "/uploads/");
                ProjectRedFlagReplyAttachment::insert([
                    "red_flag_reply_id" => $red_flag_reply_id,
                    "file" => $redflag_file,
                ]);
            }
            //  }
            return response()->json(['icon' => 'success', 'msg' => 'تم إرسال الرد علي البلاغ بنجاح', 'status' => true, 'code' => 200]);
        } else {
            return response()->json(['icon' => 'error', 'msg' => 'برجاء كتابة الرد على البلاغ واضافة ملف المرفقات', 'status' => false, 'code' => 401]);
        }
    }

    public function _replyRedflag(Request $request)
    {
        if (isset($request['type'])) {
            #case project manager replied on admin red flag reply
            $type = $request['type'];
            ProjectRedFlag::where([
                'id' => $request['redflag_id'],
                'project_id' => $request['project_id'],
            ])->update(['type' => $type]);
        }

        if (! (empty($request['redflagReply'])) && ! (empty($request->file('RedFlag_file')))) {
            ProjectRedFlag::where([
                'id' => $request['redflag_id'],
                'project_id' => $request['project_id'],
            ])->update(['status' => 'inprogress']);

            $red_flag_reply_id = ProjectRedFlagReply::insertGetId([
                'reply' => strip_tags(trim($request['redflagReply'])) ?? NULL,
                'redflag_id' => $request['redflag_id'],
                'reply_user_id' => Auth::user()->id,
                'created_at' => DB::raw('NOW()')
            ]);

            // if (! (empty($request->file('RedFlag_file')))) {
            foreach ($request->file('RedFlag_file') as $key => $file) {
                $target = storage_path() . '/app/public/uploads/projects/client';
                $source = $file->getClientOriginalName();
                $file->move($target, $source);
                $ext = $file->getClientOriginalExtension();
                $out = storage_path() . "/app/public/uploads/projects/client/" . uniqid(date('t-M')) . "." . $ext;
                rename(storage_path() . "/app/public/uploads/projects/client/" . $source, $out);
                $redflag_file = stristr($out, "/uploads/");
                ProjectRedFlagReplyAttachment::insert([
                    "red_flag_reply_id" => $red_flag_reply_id,
                    "file" => $redflag_file,
                ]);
            }
            //  }
            return response()->json(['icon' => 'success', 'msg' => 'تم إرسال الرد علي البلاغ بنجاح', 'status' => true, 'code' => 200]);
        } else {
            return response()->json(['icon' => 'error', 'msg' => 'برجاء كتابة الرد على البلاغ واضافة ملف المرفقات', 'status' => false, 'code' => 401]);
        }
    }

    public function RejectedProjectsPlanning(Request $request)
    {
        $query = Project::with('ExecutivePlanning')->whereHas('ExecutivePlanning', function ($q) {
            $q->where('is_approved', '0');
        });
        if ($request->ajax()) {
            return Datatables::of($query->latest())
                ->addIndexColumn()
                ->editColumn('file', function ($row) {
                    $file = asset('storage/' . $row->ExecutivePlanning->rejection_file);
                    $icon = asset('assets/media/svg/files/docx.svg');
                    $div = "<a href=" . $file . " title=" . $row->title . " class=\"text-hover-primary d-flex flex-column text-gray-800\">
                    <div class=\"symbol symbol-60px mb-5\">
                        <img src=" . $icon . " class=\"theme-light-show\" alt=\"\" />
                    </div>
                    <span>تحميل الملف</span>
                </a>";
                    return $div;
                })
                ->editColumn('rejection_file_created_at', function ($row) {
                    return $row->ExecutivePlanning->created_at->format('d/m/Y');
                })
                ->editColumn('actions', function ($row) {
                    return "<a href=" . route('RejectedProjectsPlanningUploadExFile', $row->id) . ">تفاصيل</a>";
                })
                ->rawColumns(['file', 'created_at', 'actions'])
                ->make(true);
        }
        $compact = [
            'counter' => $query->count(),
        ];

        return view('backoffice.client.rejectedprojectsplanning', $compact);
    }

    public function RejectedProjectsPlanningSubmitUploadExFile(Request $request, $p_id)
    {
        $info = Project::with('customer')->where('id', $p_id)->first();
        $mailData = [
            'project_title' => $info->title,
            'url' => url('client/projects/' . $p_id . '#kt_executive_planing_tab'),
        ];
        $user = User::whereHas(
            'roles', function ($q) {
                $q->where('id', 14);
            }
        )->first();
        Mail::to($info->customer->principal_email)->send(new ProjectExecutivePlanningUpdated($mailData));

        if (! (empty($request->file('executive_planning_file')))) {
            $executive_planning_file = $this->uploadOne($request->executive_planning_file, 'projects');
            ProjectExecutivePlanning::where('project_id', $p_id)->update([
                'executive_planning_file' => $executive_planning_file,
                'is_updated' => '1',
                'is_approved' => '0',
                'created_at' => \DB::raw('NOW()')
            ]);
            return redirect(route('RejectedProjectsPlanning'))->with("success", 'تم رفع ملف الخطه التنفيذيه الخاصه بالمشروع');

        } else {
            return back()->with('error', trans('برجاء رفع ملف الخطه التنفيذيه الخاصه بالمشروع'));
            exit();
        }
    }

    public function RejectedProjectsPlanningUploadExFile($projectId)
    {
        $query = Project::with('ExecutivePlanning')->find($projectId);
        $compact = [
            'row' => $query
        ];
        return view('backoffice.client.upoadexecutiveplanningfile', $compact);
    }

    public function index(Request $request, $projectStatus = 0)
    {
        if ($request->ajax()) {
            if ($request->path() == "project/ajax") {
                $compact = [
                    'list' => 'قائمه المشاريع',
                    'placeholder' => 'إسم المشروع',
                    'title' => 'مشاريع',
                    'rows' => $this->model::select('id', 'logo', 'title', 'cases_count', 'building_count', 'start_date', 'end_date', 'status_id', 'progress_bar')->where('title', 'like', '%' . $request['projectName'] . '%')->latest()->paginate(12),
                    'resource' => $this->resource,
                ];
            } else {
                if ($projectStatus > 0) {
                    $compact = [
                        'list' => 'قائمه المشاريع',
                        'placeholder' => 'إسم المشروع',
                        'title' => 'مشاريع',
                        'rows' => $this->model::select('id', 'logo', 'title', 'cases_count', 'building_count', 'start_date', 'end_date', 'status_id', 'progress_bar')->where('status_id', $projectStatus)->latest()->paginate(12),
                        'resource' => $this->resource,
                    ];
                } else {
                    $compact = [
                        'list' => 'قائمه المشاريع',
                        'placeholder' => 'إسم المشروع',
                        'title' => 'مشاريع',
                        'rows' => $this->model::select('id', 'logo', 'title', 'cases_count', 'building_count', 'start_date', 'end_date', 'status_id', 'progress_bar')->latest()->paginate(12),
                        'resource' => $this->resource,
                    ];
                }
            }
            return response()->json([
                'views' => view('partials.backoffice.project.list', $compact)->render(),
            ]);
        }

        $this->blade_path = 'backoffice.project.index';
        $compact = [
            'list' => 'قائمه المشاريع',
            'placeholder' => 'إسم المشروع',
            'title' => 'مشاريع',
            'rows' => $this->model::with('status')->select('id', 'logo', 'title', 'building_count', 'cases_count', 'start_date', 'end_date', 'status_id', 'progress_bar')->latest()->paginate(12),
            'trans_file' => $this->trans_file,
            'resource' => $this->resource,
            'customers' => Customer::select('id', 'title')->get(),
            'status' => ProjectStatus::select('id', 'title', 'trans')->get(),
            'types' => ProjectType::select('id', 'title', 'icon')->get(),
            'regions' => Region::select('id', 'title')->get(),
            'counter' => $this->model->count(),
        ];
        return view($this->blade_path, $compact);
    }

    public function _getGooMaps(Request $req){
      foreach($req['google_map'] as $file) {       
        $source=$file->getClientOriginalName();
        echo "<span class='gfile'> {$source} <i class='bi bi-map-fill'></i> </span>";
      }	
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
        ]);
        // Uploaded Files
        $validatedData['rfp'] = ! empty($request->rfp) ? $this->uploadOne($request->rfp, 'projects') : null;
        $validatedData['additional_questions'] = ! empty($request->additional_questions) ? $this->uploadOne($request->additional_questions, 'projects') : null;
        $validatedData['requirements_specifications'] = ! empty($request->requirements_specifications) ? $this->uploadOne($request->requirements_specifications, 'projects') : null;
        $validatedData['executive_planning_file'] = ! empty($request->executive_planning_file) ? $this->uploadOne($request->executive_planning_file, 'projects') : null;
       // $validatedData['google_map'] = ! empty($request->google_map) ? $this->uploadOne($request->google_map, 'projects') : null;
        $validatedData['logo'] = ! empty($request->logo) ? $this->uploadOne($request->logo, 'projects') : null;
        if ($request->has('opening')) {
            $reserveHall = $request['opening_reserve_hall'] ?? '0';
            if ($request->filled('opening_date')) {
                $openDate = date('Y-m-d', strtotime($request['opening_date']));
            } else {
                $openDate = NULL;
            }
        } else {
            $reserveHall = '0';
            $openDate = NULL;
        }
        if ($request->has('closing')) {
            $closeReserveHall = $request['closing_reserve_hall'] ?? '0';
            if ($request->filled('closing_date')) {
                $closeDate = date('Y-m-d', strtotime($request['closing_date']));
            } else {
                $closeDate = NULL;
            }
        } else {
            $closeReserveHall = '0';
            $closeDate = NULL;
        }
        $project_date_range = $request['project_date_range'];
        $start_date = explode('-', $project_date_range)[0];
        $end_date = explode('-', $project_date_range)[1];
        $insertion = [
            'status_id' => $request->save == 'save' ? '2' : '1',
            'progress_bar' => 16.6,
            'logo' => $validatedData['logo'],
            'type_id' => $request['type_id'],
            'coordinates' => $request['coordinates'],
            'title' => $request['title'],
            'start_date' => date('Y-m-d', strtotime($start_date)),
            'end_date' => date('Y-m-d', strtotime($end_date)),
            'cases_count' => $request['cases_count'],
            'building_count' => $request['building_count'],
            'customer_id' => $request['customer_id'],
            'user_add' => Auth::user()->id,
            'opening' => $request['opening'] ?? '0',
            'opening_reserve_hall' => $reserveHall,
            'opening_attendance_nature' => $request['opening_attendance_nature'],
            'opening_date' => $openDate,
            'closing' => $request['closing'] ?? '0',
            'closing_reserve_hall' => $closeReserveHall,
            'closing_attendance_nature' => $request['closing_attendance_nature'],
            'closing_date' => $closeDate,
            'rfp' => $validatedData['rfp'],
            'additional_questions' => $validatedData['additional_questions'],
            'requirements_specifications' => $validatedData['requirements_specifications'],
            'google_map' => NULL, //$validatedData['google_map'],
            'flexibility_project_dates' => $request['flexibility_project_dates'] ?? '0',
            'is_client_involved' => $request['is_client_involved'] ?? '0',
        ];
        #If save button in save
        if ($request->save == 'save') {
            $users = User::has('roles')->whereNotIn('id', [6, 7])->get();
            $mailData = [
                'project_title' => $request['title'],
            ];
            #check mail send or not
            try {
                $sendMail = Mail::to($users)->send(new NewProjectAdded($mailData));
                if ($sendMail) {
                    DB::beginTransaction();
                    try {
                        # if mail sent insert data
                        $project = $this->model::create($insertion);

                        // Set New Record In project_executive_planning
                        ProjectExecutivePlanning::create([
                            'project_id' => $project->id,
                            'is_approved' => '0',
                            'is_updated' => '1',
                            'executive_planning_file' => $validatedData['executive_planning_file']
                        ]);
                        // Database Notification
                        $projectData = [
                            'msg' => $request['title'],
                            'project_id' => $project->id
                        ];
                        Notification::send($users, new ProjectNotification($projectData));
                        $project->region()->sync((array) $request->input('region_ids'));

                        $this->storeByTypeIds($request, $project->id);
                        Calendar::create([
                            'title' => $request['title'],
                            'description' => Customer::select('title')->where('id', $request['customer_id'])->get()[0]->title,
                            'start' => date('Y-m-d', strtotime($start_date)),
                            'end' => date('Y-m-d', strtotime($end_date)),
                            'className' => 'fc-event-danger fc-event-solid-warning',
                        ]);

                        $request['project_id'] = $project->id;
                        $this->COMMON_HELPER->handleCaptureTransaction($request, 1, '1');
                        $this->COMMON_HELPER->handleCaptureTransaction($request, 2, '1');
                        $this->COMMON_HELPER->handleCaptureTransaction($request, 3, '0', 3);
                        DB::commit();
                        return response()->json(['status' => true, 'msg' => trans($this->trans_file . '.storeMessageSuccess')]);
                    } catch (\PDOException $e) {
                        DB::rollBack();
                        return response()->json(['status' => false, 'msg' => trans($this->trans_file . '.storeMessageError')]);
                    }
                }
                return response()->json(['status' => false, 'msg' => trans($this->trans_file . '.storeMessageError')]);
            } catch (\Exception $e) {
                return response()->json(['status' => false, 'message' => $e->getMessage()]);
            }
        } elseif ($request->save == 'save_only') {
            DB::beginTransaction();
            try {
                # insert data
                $project = $this->model::create($insertion);
                $project->region()->sync((array) $request->input('region_ids'));
                $this->storeByTypeIds($request, $project->id);
                Calendar::create([
                    'title' => $request['title'],
                    'description' => Customer::select('title')->where('id', $request['customer_id'])->get()[0]->title,
                    'start' => date('Y-m-d', strtotime($start_date)),
                    'end' => date('Y-m-d', strtotime($end_date)),
                    'className' => 'fc-event-danger fc-event-solid-warning',
                ]);

                $request['project_id'] = $project->id;
                $this->COMMON_HELPER->handleCaptureTransaction($request, 1, '1');
                $this->COMMON_HELPER->handleCaptureTransaction($request, 2, '0', 2);
                DB::commit();
                return response()->json(['status' => true, 'msg' => trans($this->trans_file . '.storeMessageSuccess')]);
            } catch (\PDOException $e) {
                DB::rollBack();
                return response()->json(['status' => false, 'msg' => trans($this->trans_file . '.storeMessageError')]);
            }
        }
    }

    public function storeByTypeIds($request, $projectId)
    {
        $outComeIns = [];

        $target= storage_path().'/app/public/uploads/projects/maps';
        foreach($request['google_map'] as $file) {       
            $source=$file->getClientOriginalName(); 
             $file->move($target, $source);
             $ext = $file->getClientOriginalExtension(); 
             $out=storage_path()."/app/public/uploads/projects/maps/".uniqid("map-").".".$ext;
             rename(storage_path()."/app/public/uploads/projects/maps/".$source,$out);	
             DB::table('project_maps')->insert([
                'project_id' => $projectId,  
                'user_add' => Auth::user()->id,
                'google_map' => stristr($out,"uploads/"),
                'created_at' => DB::raw('NOW()')
             ]);
          }	

        foreach ($request['titleOutcome'] as $k => $v) :
            if (! empty($v) && ! empty($request['descOutcome'][$k]) && ! empty($request['fileOutcome'][$k])) {
                $outComeIns[] = [
                    'project_id' => $projectId,
                    'title' => $v,
                    'description' => $request['descOutcome'][$k],
                    'template' => $this->uploadOne($request['fileOutcome'][$k], 'projects'),
                    'user_add' => Auth::user()->id,
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s')
                ];
            }
        endforeach;
        ProjectOutcome::insert($outComeIns);
        if (($request['type_id'] == 2 || $request['type_id'] == 12) && ! empty($request->research_survey)) {
            $validatedData['research_survey'] = ! empty($request->research_survey) ? $this->uploadOne($request->research_survey, 'projects') : null;
            ProjectLocalDevelopment::create([
                'project_id' => $projectId,
                'research_survey' => $validatedData['research_survey'],
                'user_add' => Auth::user()->id,
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ]);
        } elseif ($request['type_id'] == 9) {
            $validatedData['charity_list'] = ! empty($request->charity_list) ? $this->uploadOne($request->charity_list, 'projects') : null;
            ProjectEmpowerCharity::create([
                'project_id' => $projectId,
                'charity_count' => $request['charity_count'],
                'charity_list_file' => $validatedData['charity_list'],
                'user_add' => Auth::user()->id,
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ]);
        } elseif ($request['type_id'] == 10) {
            ProjectInspectionVisit::create([
                'project_id' => $projectId,
                'mine_title' => $request['mine_title'],
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ]);
        } elseif ($request['type_id'] == 14) {
            $validatedData['training_agenda'] = ! empty($request->training_agenda) ? $this->uploadOne($request->training_agenda, 'projects') : null;
            $validatedData['trainee_list'] = ! empty($request->trainee_list) ? $this->uploadOne($request->trainee_list, 'projects') : null;
            ProjectTrainingType::create([
                'project_id' => $projectId,
                'training_count' => $request['training_count'],
                'training_on' => $request['training_on'],
                'training_headquarter' => $request['training_headquarter'],
                'training_type' => $request['training_type'],
                'participant_type' => $request['participant_type'],
                'duration' => $request['duration'],
                'training_date' => date('Y-m-d', strtotime($request['training_date'])),
                'is_hall_required' => $request['is_hall_required'] ?? '0',
                'user_add' => Auth::user()->id,
                'training_agenda' => $validatedData['training_agenda'],
                'trainee_list' => $validatedData['trainee_list'],
            ]);
        }
    }

    public function UpdateByTypeIds($request, $project)
    {
        #تنمية محلية
        if (($request['type_idEdit'] == 2 || $request['type_idEdit'] == 12) && ! empty($request->research_survey)) {
            $validatedData['research_survey'] = $project->localDevelopment->research_survey ?? '';
            if (! empty($request->research_survey)) {
                if (Storage::disk('public')->exists($project->localDevelopment->research_survey)) {
                    Storage::disk('public')->delete($project->localDevelopment->research_survey);
                }
                $validatedData['research_survey'] = $this->uploadOne($request->research_survey, 'projects');
            }
            ProjectLocalDevelopment::where('project_id', $project->id)->update([
                'research_survey' => $validatedData['research_survey'],
            ]);
        }
        #تمكين الجمعيات
        elseif ($request['type_idEdit'] == 9) {
            $validatedData['charity_list'] = $project->EmpowerCharity->charity_list_file ?? '';
            if (! empty($request->charity_list)) {
                if (Storage::disk('public')->exists($project->EmpowerCharity->charity_list_file)) {
                    Storage::disk('public')->delete($project->EmpowerCharity->charity_list_file);
                }
                $validatedData['charity_list'] = $this->uploadOne($request->charity_list_file, 'projects');
            }
            ProjectEmpowerCharity::where('project_id', $project->id)->update([
                'charity_count' => $request['charity_count'],
                'charity_list_file' => $validatedData['charity_list'],
            ]);
        }
        #زيارة تفتيشية
        elseif ($request['type_idEdit'] == 10) {
            ProjectInspectionVisit::where('project_id', $project->id)->update([
                'mine_title' => $request['mine_title'],
            ]);
        }
        #تدريب تعاوني
        elseif ($request['type_idEdit'] == 14) {
            $validatedData['training_agenda'] = $project->TrainingType->training_agenda ?? '';
            if (! empty($request->training_agenda)) {
                if (Storage::disk('public')->exists($project->TrainingType->training_agenda)) {
                    Storage::disk('public')->delete($project->TrainingType->training_agenda);
                }
                $validatedData['training_agenda'] = $this->uploadOne($request->training_agenda, 'projects');
            }
            $validatedData['trainee_list'] = $project->TrainingType->trainee_list ?? '';
            if (! empty($request->trainee_list)) {
                if (Storage::disk('public')->exists($project->TrainingType->trainee_list)) {
                    Storage::disk('public')->delete($project->TrainingType->trainee_list);
                }
                $validatedData['trainee_list'] = $this->uploadOne($request->trainee_list, 'projects');
            }
            ProjectTrainingType::where('project_id', $project->id)->update([
                'training_count' => $request['training_count'],
                'training_on' => $request['training_on'],
                'training_type' => $request['training_type'],
                'training_headquarter' => $request['training_headquarter'],
                'participant_type' => $request['participant_type'],
                'duration' => $request['duration'],
                'training_date' => date('Y-m-d', strtotime($request['training_date'])),
                'is_hall_required' => $request['is_hall_required'] ?? '0',
                'training_agenda' => $validatedData['training_agenda'],
                'trainee_list' => $validatedData['trainee_list'],
            ]);
        }
    }

    public static function _sendProjectApproveDateEmail()
    {
        $projectEmails = [];
        $users = User::with('roles')->get();
        foreach ($users as $user) :
            if ($user->roles[0]->id == 2 && $user->roles[0]->name == 'project') :
                $projectEmails[] = $user->email;
            endif;
        endforeach;
        $projects = Project::select('id', 'title', 'potential_approved_date AS PADate', DB::raw('CURDATE() AS cDate'))
            ->whereNotNull('potential_approved_date')
            ->get();
        foreach ($projects as $p) :
            if ($p->PADate >= $p->cDate) :
                $mailData = [
                    'project_title' => $p->title,
                    'route' => url('/projects/' . $p->id . '/edit')
                ];
                foreach ($projectEmails as $email) :
                    Mail::to($email)->send(new \App\Mail\ProjectApproveDate($mailData));
                endforeach;
            endif;
        endforeach;
    }

    static public function _getEmails() : array
    {
        $users = User::with('roles')->get();
        foreach ($users as $user) :
            if (($user->roles[0]->id == 3 && $user->roles[0]->name == 'operation') ||
                ($user->roles[0]->id == 5 && $user->roles[0]->name == 'fieldwork')) :
                static::$emails[] = $user->email;
            endif;
        endforeach;
        return static::$emails;
    }

    static public function _sendProjectWarningEmail()
    {
        $emails = static::_getEmails();
        $query = DB::table("project_transaction_history AS PTH")
            ->join("projects AS P", "P.id", "=", "PTH.project_id")
            ->select("P.id AS ID", "preparation_days AS PD", "title", \DB::raw('DATEDIFF(CURDATE(),DATE(PTH.updated_at)) AS RDays'))
            ->groupBy("PTH.project_id")
            ->where("P.status_id",'>=','5')
            ->where("PTH.status_id",'>=','5')
            ->where("PTH.is_done",'=','1')
            ->get();
         
        foreach ($query as $v) :
            $obEmails = DB::table("project_fieldwork_team AS PFT")
                ->join("users", "users.id", "=", "PFT.user_id")
                ->select("email")
                ->groupBy("PFT.project_id")
                ->where("PFT.project_id", $v->ID)->where("PFT.type_id", "1")->first();
            if (isset($obEmails->email) && ! is_null($obEmails->email)) :
                $emails[] = $obEmails->email;
            endif;
            $route = url("/projects/" . $v->ID . "/edit");
            if ($v->PD == $v->RDays) :
                foreach ($emails as $e) {
                    Mail::to($e)->send(new ProjectWarning($v->title, $route, "caution"));
                }
            elseif ($v->PD == 0 && $v->RDays == 1) :
                foreach ($emails as $e) {
                    Mail::to($e)->send(new ProjectWarning($v->title, $route, "warning"));
                }
            endif;
        endforeach;
    }

    static public function _sendProjectWarningExEmail()
    {
        $emails = static::_getEmails();
        $query = DB::table("project_transaction_history AS PTH")
            ->join("projects AS P", "P.id", "=", "PTH.project_id")
            ->select("P.id AS ID", "execution_days AS ED", "title", \DB::raw('DATEDIFF(CURDATE(),DATE(PTH.updated_at)) AS RDays'))
            ->groupBy("PTH.project_id")
            ->where("P.status_id",'>=','19')
            ->where("PTH.status_id",'>=','19')
            ->where("PTH.is_done",'=','1')
            ->get();
        foreach ($query as $v) :
            $obEmails = DB::table("project_fieldwork_team AS PFT")
                ->join("users", "users.id", "=", "PFT.user_id")
                ->select("email")
                ->groupBy("PFT.project_id")
                ->where("PFT.project_id", $v->ID)->where("PFT.type_id", "1")->first();
            if (isset($obEmails->email) && ! is_null($obEmails->email)) :
                $emails[] = $obEmails->email;
            endif;
            $route = url("/projects/" . $v->ID . "/edit");
            if ($v->ED == $v->RDays) :
                foreach ($emails as $e) {
                    Mail::to($e)->send(new ProjectWarning($v->title, $route, "excaution"));
                }
            elseif ($v->ED == 0 && $v->RDays == 1) :
                foreach ($emails as $e) {
                    Mail::to($e)->send(new ProjectWarning($v->title, $route, "exwarning"));
                }
            endif;
        endforeach;
    }

    public function editModal(Request $request)
    {
        $id = $request->id;
        $response = [];
        $response['row'] = $this->model::with('localDevelopment', 'InspectionVisit', 'EmpowerCharity', 'TrainingType', 'status', 'type', 'region', 'customer')->find($id);
        $region_ids = [];
        foreach ($response['row']->region()->get() as $s) {
            $region_ids[] = $s->id;
        }
        $response['type'] = $response['row']->type;
        $response['research_survey'] = $response['row']->localDevelopment->research_survey ?? '';
        $response['mine_title'] = $response['row']->InspectionVisit->mine_title ?? '';
        $response['charity_count'] = $response['row']->EmpowerCharity->charity_count ?? '';
        $response['charity_list_file'] = $response['row']->EmpowerCharity->charity_list_file ?? '';
        $response['training_type'] = $response['row']->TrainingType;
        $response['region_ids'] = $region_ids;
        // media project var
        $response['pdf_icon'] = url('assets/media/svg/files/pdf.svg');
        $response['logo'] = asset('storage/' . $response['row']->logo);
        $response['rfp'] = asset('storage/' . $response['row']->rfp);
        $response['additional_questions'] = asset('storage/' . $response['row']->additional_questions);
        $response['requirements_specifications'] = asset('storage/' . $response['row']->requirements_specifications);
        $response['google_map'] = asset('storage/' . $response['row']->google_map);
        $response['project_type_icon'] = asset('assets/media/svg/project-types/' . $response['type']->icon . '.svg');
        return $response;
    }

    public function edit(Request $request, $id)
    {
        $projectCurrentStatus = Project::select('status_id AS status')->where('id', $id)->first()->status;
        if (isset($request['status']) && $request['status'] == $projectCurrentStatus) :
            $this->blade_path = 'backoffice.project.approval';
        elseif (! isset($request['status'])) :
            $this->blade_path = 'backoffice.project.approval';
        else :
            return redirect('/project/projects');
        endif;
        $query = $this->model::with('status', 'type', 'region', 'customer', 'localDevelopment')->find($id);
        $compact = [
            'trans_file' => $this->trans_file,
            'resource' => $this->resource,
            'row' => $query,
            'users' => ProjectTransactionHistory::with('user')->where('project_id', $id)->groupBy('user_id')->get(),
            'training' => ProjectTrainingType::where('project_id', $id)->first(),
            'project_equipments' => DB::table('project_equipments as pe')->leftJoin('equipments as e', 'e.id', '=', 'pe.equipment_id')->select('pe.id AS peID', 'pe.qty', 'pe.price', 'e.type_id', 'e.title', 'pe.send_equipment_receipt', 'pe.equipment_id')->where('project_id', $id)->get(),
            'selected_equipments' => PEQ::where("project_id", $id)->get(),
            'equipments' => Equipment::get(),
            'remaining_equipments' => DB::table('equipments as e')->whereNotIn('e.id', [DB::raw('(SELECT equipment_id FROM project_equipments as pe WHERE pe.project_id = ' . $id . ')')])->get(),
            'project_finanical_estimate' => ProjectFinancialEstimate::where('project_id', $id)->first(),
            'project_family_development' => ProjectFamilyDevelopment::where("project_id", $id)->first(),
            'project_local_development' => ProjectLocalDevelopment::where("project_id", $id)->first(),
            'project_empower_charity' => ProjectEmpowerCharity::where('project_id', $id)->first(),
        ];

        return view($this->blade_path, $compact);
    }

    public function updateModal(Request $request)
    {
        $project = $this->model::with('localDevelopment', 'InspectionVisit', 'EmpowerCharity', 'TrainingType', 'status', 'type', 'region', 'customer')->find($request->id);
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
        ]);
        $validatedData['rfp'] = $project->rfp ?? '';
        if (! empty($request->rfp)) {
            if (Storage::disk('public')->exists($project->rfp)) {
                Storage::disk('public')->delete($project->rfp);
            }
            $validatedData['rfp'] = $this->uploadOne($request->rfp, 'projects');
        }
        $validatedData['additional_questions'] = $project->additional_questions ?? '';
        if (! empty($request->additional_questions)) {
            if (Storage::disk('public')->exists($project->additional_questions)) {
                Storage::disk('public')->delete($project->additional_questions);
            }
            $validatedData['additional_questions'] = $this->uploadOne($request->additional_questions, 'projects');
        }
        $validatedData['requirements_specifications'] = $project->requirements_specifications ?? '';
        if (! empty($request->requirements_specifications)) {
            if (Storage::disk('public')->exists($project->requirements_specifications)) {
                Storage::disk('public')->delete($project->requirements_specifications);
            }
            $validatedData['requirements_specifications'] = $this->uploadOne($request->requirements_specifications, 'projects');
        }

        $validatedData['google_map'] = $project->google_map ?? '';
        if (! empty($request->google_map)) {
            if (Storage::disk('public')->exists($project->google_map)) {
                Storage::disk('public')->delete($project->google_map);
            }
            $validatedData['google_map'] = $this->uploadOne($request->google_map, 'projects');
        }
        $validatedData['logo'] = $project->logo ?? '';
        if (! empty($request->logo)) {
            if (Storage::disk('public')->exists($project->logo)) {
                Storage::disk('public')->delete($project->logo);
            }
            $validatedData['logo'] = $this->uploadOne($request->logo, 'projects');
        }
        if ($request->has('opening')) {
            $reserveHall = $request['opening_reserve_hall'] ?? '0';
            if ($request->filled('opening_date')) {
                $openDate = date('Y-m-d', strtotime($request['opening_date']));
            } else {
                $openDate = NULL;
            }
        } else {
            $reserveHall = '0';
            $openDate = NULL;
        }
        if ($request->has('closing')) {
            $closeReserveHall = $request['closing_reserve_hall'] ?? '0';
            if ($request->filled('closing_date')) {
                $closeDate = date('Y-m-d', strtotime($request['closing_date']));
            } else {
                $closeDate = NULL;
            }
        } else {
            $closeReserveHall = '0';
            $closeDate = NULL;
        }
        $project_date_range = $request['project_date_range'];
        $start_date = explode('-', $project_date_range)[0];
        $end_date = explode('-', $project_date_range)[1];
        $update = [
            'status_id' => $request->save == 'save' ? '2' : '1',
            'progress_bar' => 16.6,
            'logo' => $validatedData['logo'],
            'type_id' => $request['type_idEdit'],
            'title' => $request['title'],
            'start_date' => date('Y-m-d', strtotime($start_date)),
            'end_date' => date('Y-m-d', strtotime($end_date)),
            'cases_count' => $request['cases_count'],
            'building_count' => $request['building_count'],
            'customer_id' => $request['customer_id'],
            'opening' => $request['opening'] ?? '0',
            'opening_reserve_hall' => $reserveHall,
            'opening_attendance_nature' => $request['opening_attendance_nature'],
            'opening_date' => $openDate,
            'closing' => $request['closing'] ?? '0',
            'closing_reserve_hall' => $closeReserveHall,
            'closing_attendance_nature' => $request['closing_attendance_nature'],
            'closing_date' => $closeDate,
            'rfp' => $validatedData['rfp'],
            'additional_questions' => $validatedData['additional_questions'],
            'requirements_specifications' => $validatedData['requirements_specifications'],
            'google_map' => $validatedData['google_map'],
        ];
        #If save button in save
        if ($request->save == 'save') {
            $users = User::has('roles')->whereNotIn('id', [6, 7])->get();
            $mailData = [
                'project_title' => $request['title'],
            ];
            #check mail send or not
            try {
                $sendMail = Mail::to($users)->send(new NewProjectUpdated($mailData));
                if ($sendMail) {
                    DB::beginTransaction();
                    try {
                        # if mail sent insert data
                        $query = $this->model::where('id', $request->id)->update($update);
                        // Database Notification
                        $projectData = [
                            'msg' => $request['title'],
                            'project_id' => $project->id
                        ];
                        Notification::send($users, new ProjectNotification($projectData));
                        $PRegions = $this->model::findOrFail($request->id)->region()->sync($request->region_ids);
                        $this->storeByTypeIds($request, $request->id);
                        Calendar::where('id', $request->id)->update([
                            'title' => $request['title'],
                            'description' => Customer::select('title')
                                ->where('id', $request['customer_id'])
                                ->get()[0]->title,
                            'start' => date('Y-m-d', strtotime($start_date)),
                            'end' => date('Y-m-d', strtotime($end_date)),
                            'className' => 'fc-event-danger fc-event-solid-warning',
                        ]);

                        $request['id'] = $request->id;
                        $request['project_id'] = $request->id;
                        $this->COMMON_HELPER->handleCaptureTransaction($request, 1, '1');
                        $this->COMMON_HELPER->handleCaptureTransaction($request, 2, '1');
                        $this->COMMON_HELPER->handleCaptureTransaction($request, 3, '0', 3);
                        DB::commit();
                        return response()->json(['status' => true, 'msg' => trans($this->trans_file . '.updateMessageSuccess')]);
                    } catch (\PDOException $e) {
                        DB::rollBack();
                        return response()->json(['status' => true, 'msg' => trans($this->trans_file . '.updateMessageSuccess')]);
                    }
                }
            } catch (\Exception $e) {
                return response()->json(['error' => false, 'msg' => trans($this->trans_file . '.mailFailed')]);
            }
        } elseif ($request->save == 'save_only') {
            DB::beginTransaction();
            try {
                # if mail sent insert data
                $project = $this->model::where('id', $request->id)->update($update);
                $PRegions = $this->model::findOrFail($request->id)->region()->sync($request->region_ids);
                $this->storeByTypeIds($request, $request->id);
                Calendar::where('id', $request->id)->update([
                    'title' => $request['title'],
                    'description' => Customer::select('title')
                        ->where('id', $request['customer_id'])
                        ->get()[0]->title,
                    'start' => date('Y-m-d', strtotime($start_date)),
                    'end' => date('Y-m-d', strtotime($end_date)),
                    'className' => 'fc-event-danger fc-event-solid-warning',
                ]);

                $request['id'] = $request->id;
                DB::commit();
                return response()->json(['status' => true, 'msg' => trans($this->trans_file . '.updateMessageSuccess')]);
            } catch (\PDOException $e) {
                DB::rollBack();
                return response()->json(['status' => false, 'msg' => trans($this->trans_file . '.upateMessageError')]);
            }
        }
    }

    public function update(Request $request, $id)
    {
        $request['project_id'] = $id;
        if ($request['kt_project_status_select'] == 'approved') {
            $confirm_letter = ! empty($request->confirm_letter) ? $this->uploadOne($request->confirm_letter, 'projects') : null;
            $family_list = ! empty($request->family_list) ? $this->uploadOne($request->family_list, 'projects') : null;
            $coordinate_file = ! empty($request->coordinate_file) ? $this->uploadOne($request->coordinate_file, 'projects') : null;
            $this->COMMON_HELPER->changeProjectStatus($request, 4);
            $this->COMMON_HELPER->handleCaptureTransaction($request, 4, '1'); #current status
            $this->COMMON_HELPER->handleCaptureTransaction($request, 5, '0', 3);
            if ($request->has('opening')) {
                $reserveHall = $request['opening_reserve_hall'] ?? '0';
                if ($request->filled('opening_date')) {
                    $openDate = date('Y-m-d', strtotime($request['opening_date']));
                } else {
                    $openDate = NULL;
                }
            } else {
                $reserveHall = '0';
                $openDate = NULL;
            }

            if ($request->has('closing')) {
                $closeReserveHall = $request['closing_reserve_hall'] ?? '0';
                if ($request->filled('closing_date')) {
                    $closeDate = date('Y-m-d', strtotime($request['closing_date']));
                } else {
                    $closeDate = NULL;
                }
            } else {
                $closeReserveHall = '0';
                $closeDate = NULL;
            }
            try {
                Project::where('id', $id)->update([
                    'start_date' => date('Y-m-d', strtotime($request['start_date'])),
                    'end_date' => date('Y-m-d', strtotime($request['end_date'])),
                    'opening' => $request['opening'] ?? '0',
                    'opening_reserve_hall' => $reserveHall,
                    'opening_attendance_nature' => $request['opening_attendance_nature'] == '0' ? 'regulars' : 'leaders',
                    'opening_date' => $openDate,
                    'closing' => $request['closing'] ?? '0',
                    'closing_reserve_hall' => $closeReserveHall,
                    'closing_attendance_nature' => $request['closing_attendance_nature'] == '0' ? 'regulars' : 'leaders',
                    'closing_date' => $closeDate,
                    'confirm_letter' => $confirm_letter,
                ]);
            } catch (QueryException $ex) {
                dd($ex->getMessage());
            }
            if (! empty($request->family_list)) {
                ProjectFamilyDevelopment::updateOrCreate(['project_id' => $id], [
                    'project_id' => $id,
                    'user_add' => Auth::user()->id,
                    'family_list' => $family_list,
                ]);
            }
            if (! empty($request->coordinate_file)) {
                ProjectLocalDevelopment::updateOrCreate(['project_id' => $id], [
                    'project_id' => $id,
                    'user_add' => Auth::user()->id,
                    'coordinate_file' => $coordinate_file,
                ]);
            }
        } else if ($request['kt_project_status_select'] == 'reject') {
            $this->COMMON_HELPER->changeProjectStatus($request, 17);
            RejectedProject::updateOrCreate(['project_id' => $id], [
                'project_id' => $id,
                'reason' => $request['rejection_reason'],
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ]);
            $users = User::has('roles')->whereNotIn('id', [6, 7])->get();
            $mailData = [
                'project_title' => Project::find($id)->title
            ];
            $sendMail = Mail::to($users)->send(new NewProjectRejected($mailData));
        } else {
            $potentialDate = NULL;
            if ($request->filled('kt_pending_date')) {
                $potentialDate = date('Y-m-d', strtotime($request['kt_pending_date']));
            }
            Project::updateOrCreate(['id' => $id], [
                'potential_approved_date' => $potentialDate,
                'status_id' => 16,
            ]);
        }
        return Redirect::to(url('/' . Auth::user()->roles[0]->name . '/projects'))->with('success', trans('site.mission_finished')); // redirect
    }

    public function destroy($id)
    {
        $item = $this->model::find($id);
        if ($item->delete()) {
            return back()->with('success', trans($this->trans_file . '.deleteMessageSuccess'));
        }
    }

    public function destroyMultiple(Request $request)
    {
        $deleteMessageSuccess = __('admin.deleteMessageSuccess');
        return response()->json([
            'status' => 'success',
            'msg' => $deleteMessageSuccess,
        ]);
    }

    public function getTeamItemList($projectId, $typId)
    {
        $compact = [
            'team_ranks_items' => ProjectTeamRankItem::where('project_id', $projectId)
                ->where('type_id', $typId)
                ->get(),
        ];
        return response()->json([
            'views' => view('partials.backoffice.project.team-item-list', $compact)->render(),
        ]);
    }
    ////////////////////////////////////////////////////////////////////////////


    public function getCustomerInfo(Request $request)
    {
        $id = $request->id;
        $data = Customer::select('id', 'principal_name')->find($id);
        $response['id'] = $data->id;
        $response['principal_name'] = $data->principal_name;
        return $response;
    }






}