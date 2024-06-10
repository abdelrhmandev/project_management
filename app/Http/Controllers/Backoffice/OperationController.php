<?php

namespace App\Http\Controllers\Backoffice;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\ProjectEquipments;
use App\Models\ProjectStatus;
use App\Models\ProjectType;
use App\Models\Region;
use App\Models\Customer;
use App\Models\Equipment;
use App\Models\EquipmentType;
use App\Models\TeamRankType;
use App\Models\ProjectFinancialEstimate;
use App\Models\ProjectInspectionVisit;
use App\Models\ProjectEmpowerCharity;
use App\Models\ProjectTrainingType;
use App\Models\ProjectTeamRankItem;
use Illuminate\Support\Facades\DB;
use App\Models\RealestateType;
use App\Models\ProjectContractResearchItem;
use App\Mail\FieldworkEnded;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Models\ProjectTransactionHistory;
use App\Models\AttractingTeam;
use App\Models\ProjectFamilyDevelopment;
use App\Models\ProjectLocalDevelopment;
use App\Models\ProjectFieldworkTeam;
use App\Models\ProjectExploreTour;
use App\Mail\ProjectExploreTour as PET;
use Illuminate\Support\Facades\Auth;
use App\Notifications\FieldWorkNotification;
use Notification;

class OperationController extends Controller
{
    protected $model;
    protected $resource;
    protected $trans_file;
    protected $blade_path;
    protected $COMMON_HELPER;
    private static $fieldWorkEmails;

    public function __construct(Project $model)
    {
        $this->middleware('seen', ['only' => ['edit']]);
        $this->model = $model;
        $this->resource = 'operations';
        $this->blade_path = 'backoffice.operation';
        $this->trans_file = 'project';
        $this->COMMON_HELPER = app('App\Helpers\Common');
        static::$fieldWorkEmails = [];
    }

    public function index()
    {
        $this->blade_path = 'backoffice.operation.index';
        $compact = [
            'list' => 'قائمه التقديرات ',
            'placeholder' => 'إسم التقدير',
            'title' => 'التقديرات ',
            'rows' => $this->model::select('id', 'logo', 'title', 'building_count', 'cases_count', 'start_date', 'end_date', 'status_id', 'progress_bar')->where('status_id', 2)->latest()->paginate(12),
            'trans_file' => $this->trans_file,
            'resource' => $this->resource,
            'status' => ProjectStatus::select('id', 'title', 'trans')->get(),
            'types' => ProjectType::select('id', 'title')->get(),
            'regions' => Region::select('id', 'title')->get(),
            'customers' => Customer::select('id', 'title')->get(),
            'equipments' => Equipment::get(),
            'counter' => $this->model::select('id', 'logo', 'title', 'building_count', 'cases_count', 'start_date', 'end_date', 'status_id', 'progress_bar')->where('status_id', 2)->count(),
        ];

        return view($this->blade_path, $compact);
    }

    public function projects()
    {
        $this->blade_path = 'backoffice.operation.index';
        $compact = [
            'list' => 'قائمه المشاريع',
            'placeholder' => 'إسم المشروع',
            'title' => 'مشاريع',
            'rows' => $this->model::select('id', 'logo', 'title', 'building_count', 'cases_count', 'start_date', 'end_date', 'status_id', 'progress_bar')->where('status_id', '>=', 3)->latest()->paginate(12),
            'trans_file' => $this->trans_file,
            'resource' => $this->resource,
            'status' => ProjectStatus::select('id', 'title', 'trans')->get(),
            'types' => ProjectType::select('id', 'title')->get(),
            'regions' => Region::select('id', 'title')->get(),
            'customers' => Customer::select('id', 'title')->get(),
            'equipments' => Equipment::get(),
            'counter' => $this->model::select('id', 'logo', 'title', 'building_count', 'cases_count', 'start_date', 'end_date', 'status_id', 'progress_bar')->where('status_id', '>=', 3)->count(),
        ];

        return view($this->blade_path, $compact);
    }

    public function edit(Request $request, $projectId)
    {
        $projectCurrentStatus = Project::select('status_id AS status')->where('id', $projectId)->first()->status;
        if (isset($request['status']) && $request['status'] != $projectCurrentStatus) :
            return redirect('/operation/projects');
        endif;

        $query = $this->model::with('status', 'type', 'region', 'customer', 'localDevelopment')->find($projectId);
        if ($query->status_id != 4) {
            $this->blade_path = 'backoffice.operation.edit';

            $compact = [
                'trans_file' => $this->trans_file,
                'resource' => $this->resource,
                'row' => $query,
                'users' => ProjectTransactionHistory::with('user')->where('project_id', $projectId)->groupBy('user_id')->get(),
                'status' => ProjectStatus::select('id', 'title', 'trans')->get(),
                'types' => ProjectType::select('id', 'title')->get(),
                'regions' => Region::select('id', 'title')->get(),
                'customers' => Customer::select('id', 'title')->get(),
                'remaining_equipments' => DB::table('equipments as e')->whereNotIn('e.id', [DB::raw('(SELECT equipment_id FROM project_equipments as pe WHERE pe.project_id = ' . $projectId . ')')])->get(),
                'equipments' => Equipment::get(),
                'equipment_type' => EquipmentType::get(),
                'team_ranks' => TeamRankType::get(),
                'realestate_types' => RealestateType::get(),
                'project_admin' => User::where('id', 2)->first(),
                'project_tour_files' => DB::table('project_explore_tour as pe')->leftJoin('project_tour_file as pf', 'pe.id', '=', 'pf.explore_tour_id')
                    ->where('pe.project_id', $projectId)->get(),
                'project_explore_tour' => ProjectExploreTour::where("project_id", $projectId)->first(),
                'project_inspection_visit' => ProjectInspectionVisit::where("project_id", $projectId)->first(),
                'project_contract_research_items' => ProjectContractResearchItem::where("project_id", $projectId)->with('realestateType')->get(),
                'project_empower_charity' => ProjectEmpowerCharity::where("project_id", $projectId)->first(),
                'training' => ProjectTrainingType::where('project_id', $projectId)->first(),
                'selected_equipments' => ProjectEquipments::where("project_id", $projectId)->get(),
                'financial_bid_estimate' => ProjectFinancialEstimate::where("project_id", $projectId)->first(),
                'project_family_development' => ProjectFamilyDevelopment::where("project_id", $projectId)->first(),
                'project_local_development' => ProjectLocalDevelopment::where("project_id", $projectId)->first(),
                'project_empower_charity' => ProjectEmpowerCharity::where('project_id', $projectId)->first(),
                'team_rank_items' => DB::table('project_team_rank_item')->select('type_id', DB::raw('COUNT(type_id) as qty'))->where('project_id', $projectId)->groupBy('type_id')->get(),
                'project_equipments' => DB::table('project_equipments as pe')->leftJoin('equipments as e', 'e.id', '=', 'pe.equipment_id')
                    ->select('e.type_id', DB::raw('SUM(pe.qty) as qty'), DB::raw('SUM(pe.price) as price'))->where('project_id', $projectId)->groupBy('e.type_id')->get(),
            ];

            return view($this->blade_path, $compact);
        } else {
            return Redirect::to('operation/projects');
        }
    }

    public function _changeKaderQty(Request $request)
    {
        DB::beginTransaction();
        try {
            ProjectFinancialEstimate::updateOrCreate(['project_id' => $request["project_id"]], [$request['team_title'] . '_qty' => $request['qty']]);
            DB::commit();
            return response()->json(["MSG" => 'Success']);
        } catch (\PDOException $e) {
            DB::rollBack();
            return response()->json(["MSG" => $e->getMessage()]);
        }
    }

    public function _changeKaderPrice(Request $request)
    {
        DB::beginTransaction();
        try {
            ProjectFinancialEstimate::updateOrCreate(['project_id' => $request["project_id"]], [$request['team_title'] . '_price' => $request['price']]);
            DB::commit();
            return response()->json(["MSG" => 'Success']);
        } catch (\PDOException $e) {
            DB::rollBack();
            return response()->json(["MSG" => $e->getMessage()]);
        }
    }

    public function getTeamItemList($projectId, $typId)
    {
        $compact = [
            'team_ranks_items' => ProjectTeamRankItem::where("project_id", $projectId)->where("type_id", $typId)->get(),
        ];

        return response()->json([
            'views' => view('partials.backoffice.operation.team-item-list', $compact)->render(),
        ]);
    }

    public function create(Request $request)
    {
        // when u make redirect it will ignore the next code
        if (! empty($request['selected-equipment-checkbox'])) {
            ProjectEquipments::where('project_id', $request['project_id'])->where('equipment_type', $request['equipment_type'])->whereNotIn('equipment_id', $request['selected-equipment-checkbox'])->delete();

            $rowNo = count($request['selected-equipment-checkbox']);
            for ($i = 0; $i < $rowNo; $i++) {
                $equipId = $request['selected-equipment-checkbox'][$i];
                $equipment = ProjectEquipments::where('project_id', $request['project_id'])->where('equipment_id', $equipId);
                $insertion = [
                    'equipment_id' => $equipId,
                    'equipment_type' => $request['equipment_type'],
                    'project_id' => $request['project_id'],
                    'price' => $request['selected-equipment-price'][$equipId],
                    'qty' => $request['selected-equipment-qty'][$equipId],
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ];
                if (! (empty($request['selected-equipment-price'][$equipId])) && ! (empty($request['selected-equipment-qty'][$equipId]))) {

                    $equipment->update($insertion);
                }
            }
        }

        if (! empty($request['equipment-checkbox'])) {
            $rowNo = count($request['equipment-checkbox']);
            for ($i = 0; $i < $rowNo; $i++) {
                $equipId = $request['equipment-checkbox'][$i];
                $insertion = [
                    'equipment_id' => $equipId,
                    'equipment_type' => $request['equipment_type'],
                    'project_id' => $request['project_id'],
                    'price' => $request['equipment-price'][$equipId],
                    'qty' => $request['equipment-qty'][$equipId],
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ];

                if (! (empty($request['equipment-price'][$equipId])) && ! (empty($request['equipment-qty'][$equipId]))) {
                    ProjectEquipments::create($insertion);
                }
            }
        }

        if (empty($request['selected-equipment-checkbox']) && ! empty($request['equipment-checkbox'])) {
            ProjectEquipments::where('project_id', $request['project_id'])->where('equipment_type', $request['equipment_type'])->whereNotIn('equipment_id', $request['equipment-checkbox'])->delete();
        }

        if (empty($request['selected-equipment-checkbox']) && empty($request['equipment-checkbox'])) {
            ProjectEquipments::where('project_id', $request['project_id'])->where('equipment_type', $request['equipment_type'])->delete();
        }

        return back()->with('success', trans('site.mission_completed'));
    }

    public function createById(Request $request, $projectId)
    {
        $rowNo = count($request->all()) / 4;
        for ($i = 0; $i < $rowNo; $i++) {
            $insertion = [
                'equipment_id' => $request["row-" . $i + 1 . "-id"],
                'equipment_type' => $request['equipment_type'],
                'project_id' => $projectId,
                'qty' => $request["row-" . $i + 1 . "-qty"],
                'price' => $request["row-" . $i + 1 . "-price"],
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];

            ProjectEquipments::create($insertion);
        }
    }

    public function createTeamQuote(Request $request)
    {
        if (! empty($request["contract_term_repeater"])) {
            $rowNo = count($request["contract_term_repeater"]);
            for ($i = 0; $i < $rowNo; $i++) {
                if (! empty($request["contract_term_repeater"][$i]['contract-term'])) {
                    $insertion = [
                        'title' => $request["contract_term_repeater"][$i]['contract-term'],
                        'type_id' => $request["type_id"],
                        'project_id' => $request["project_id"],
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')
                    ];

                    ProjectTeamRankItem::create($insertion);
                }
            }
        }

        if (! empty($request['written-contract-term'])) {
            foreach ($request['written-contract-term'] as $index => $item) {
                ProjectTeamRankItem::where('project_id', $request["project_id"])->where('id', $index)->update(['title' => $item]);
            }
        }

        return back()->with('success', trans('site.mission_completed'));
    }

    public function createContractResearchItem(Request $request)
    {
        if (! empty($request["realestate_term_repeater"])) {
            $rowNo = count($request["realestate_term_repeater"]);
            for ($i = 0; $i < $rowNo; $i++) {
                $rowRepeater = $request["realestate_term_repeater"][$i];
                if (! empty($rowRepeater["realestate-type"])) {
                    $insertion = [
                        'realestate_id' => $rowRepeater["realestate-type"],
                        'price' => $rowRepeater['category-price'],
                        'project_id' => $request["project_id"],
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')
                    ];

                    ProjectContractResearchItem::create($insertion);
                }
            }
        }

        if (! empty($request['written-category-price'])) {
            foreach ($request['written-category-price'] as $index => $item) {
                ProjectContractResearchItem::where('project_id', $request["project_id"])->where('id', $index)->update(['price' => $item]);
            }
        }

        return back()->with('success', trans('site.mission_completed'));
    }

    public function financialBidEstimates(Request $request)
    {
        $date_range = $request['date_range'];
        $insertion = [
            'project_id' => $request["project_id"],
            'beneficiary_preparation_pricing' => $request["beneficiary_preparation_pricing"],
            'writing_report_cost' => $request["writing_report_cost"],
            'is_family_list_required' => $request["is_family_list_required"] ?? '0',
            'is_coordinate_required' => $request["is_coordinate_required"] ?? '0',
            'is_explore_tour_required' => $request["is_explore_tour_required"] ?? '0',
            'start_date' => $request['date_range'] != null ? date('Y-m-d', strtotime(explode('-', $date_range)[0])) : null,
            'end_date' => $request['date_range'] != null ? date('Y-m-d', strtotime(explode('-', $date_range)[1])) : null,
            'observer_qty' => $request["team-1-qty"],
            'observer_price' => $request["team-1-price"],
            'observer_audit_qty' => $request["team-2-qty"],
            'observer_audit_price' => $request["team-2-price"],
            'auditor_qty' => $request["team-3-qty"],
            'auditor_price' => $request["team-3-price"],
            'supervisor_qty' => $request["team-4-qty"],
            'supervisor_price' => $request["team-4-price"],
            'researcher_qty' => $request["team-5-qty"],
            'researcher_price' => $request["team-5-price"],
            'inspector_qty' => $request["team-6-qty"],
            'inspector_price' => $request["team-6-price"],
            'trainer_qty' => $request["team-7-qty"],
            'trainer_price' => $request["team-7-price"],
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        ProjectFinancialEstimate::updateOrCreate(['project_id' => $request["project_id"]], $insertion);
        $this->COMMON_HELPER->changeProjectStatus($request, 20);
        $this->COMMON_HELPER->handleCaptureTransaction($request, 3, '1');
        $this->COMMON_HELPER->handleCaptureTransaction($request, 27, '0', 29);
        return Redirect::to(url('/' . Auth::user()->roles[0]->name . '/projects'))->with('success', trans('site.mission_finished')); // redirect
    }

    public function deptTiming(Request $request)
    {
        $projectType = Project::where('id', $request["project_id"])->first()->type_id;
        if ($projectType == 14 || $projectType == 13) {
            $this->COMMON_HELPER->changeProjectStatus($request, 19);
            $this->COMMON_HELPER->handleCaptureTransaction($request, 26, '0', 8);
        } else {
            $this->COMMON_HELPER->changeProjectStatus($request, 5);
            if ($projectType == 12 || $projectType == 10) {
                $this->COMMON_HELPER->handleCaptureTransaction($request, 23, '0', 23);
            } else {
                $this->COMMON_HELPER->handleCaptureTransaction($request, 6, '0', 4);
            }

            if ($projectType != 10) {
                $this->COMMON_HELPER->handleCaptureTransaction($request, 7, '0', 5);
            } else {
                $this->COMMON_HELPER->handleCaptureTransaction($request, 24, '0', 5);
            }

            $insertion = [
                'preparation_days' => $request["preparation_days"],
                'execution_days' => $request["execution_days"],
                'updated_at' => date('Y-m-d H:i:s')
            ];

            Project::where('id', $request["project_id"])->update($insertion);
        }

        $this->COMMON_HELPER->handleCaptureTransaction($request, 5, '1');
        $this->COMMON_HELPER->handleCaptureTransaction($request, 8, '0', 9);
        return response()->json(['status' => "success", 'msg' => trans('site.mission_completed'), 'url' => url('/' . Auth::user()->roles[0]->name . '/projects')]);
    }

    public function update(Request $request, $id)
    {
    }

    public function destroy($isRealEstate, $itemId)
    {
        if ($isRealEstate == 'true') {
            ProjectContractResearchItem::where('id', $itemId)->delete();
        } else {
            ProjectTeamRankItem::where('id', $itemId)->delete();
        }
    }

    public function show($id)
    {
    }

    public function destroyMultiple(Request $request)
    {
        $deleteMessageSuccess = __('admin.deleteMessageSuccess');
        return response()->json([
            'status' => "success",
            'msg' => $deleteMessageSuccess
        ]);
    }

    public function endField(Request $request)
    {
        $this->COMMON_HELPER->changeProjectStatus($request, 12);
        $users = User::select('id', 'name', 'email')->has('roles')->whereNotIn('id', [6, 7])->get();
        $mailData = [
            'project_title' => $request['project_title'],
            'route' => url('/')
        ];

        Mail::to($users)->send(new FieldworkEnded($mailData));
        $FieldWorkNotification = [
            'msg' => config('custom.FieldWorkNotificationEnd') . " (" . $request['project_title'] . ").",
            'project_id' => $request['project_id']
        ];

        Notification::send($users, new FieldWorkNotification($FieldWorkNotification));
        $this->COMMON_HELPER->handleCaptureTransaction($request, 19, '1');
        $project_fieldwork_teams = ProjectFieldworkTeam::select('user_id')->where("project_id", $request['project_id'])->where("type_id", 1)->get();
        foreach ($project_fieldwork_teams as $project_fieldwork_team) {
            $this->COMMON_HELPER->handleCaptureTransaction($request, 20, '0', $project_fieldwork_team->user_id);
        }

        $pObservers = DB::table("project_observer_team")->select('team_user_id')->where('project_id', $request['project_id'])->whereIn('type_id', [3, 4, 5]);
        $pAuditors = DB::table("project_auditor_team")->select('team_user_id')->where('project_id', $request['project_id'])->whereIn('type_id', [3, 4, 5]);
        $allTeam = $pObservers->union($pAuditors)->get();
        foreach ($allTeam as $team) :
            AttractingTeam::where('id', $team->team_user_id)->increment('accomplished_projects', 1);
        endforeach;

        $arr = array('msg' => __('site.mission_completed'), 'status' => true);
        return response()->json($arr);
    }

    public function requestExplorationTour(Request $request)
    {
        $email = User::where('username', 'fieldwork')->first()->email;
        ProjectExploreTour::insert(['project_id' => $request['project_id'], 'is_fieldwork_done' => '0', 'created_at' => date('Y-m-d H:i:s')]);
        ProjectFinancialEstimate::updateOrCreate(['project_id' => $request['project_id']], ['is_explore_tour_required' => '1']);
        $projectTitle = Project::find($request['project_id'])->title;
        $projectStatus = Project::find($request['project_id'])->status_id;
        $route = url('/fieldworks/' . $request['project_id'] . '/edit/' . $projectStatus);
        $reminder = "no";
        try {
            Mail::to($email)->send(new PET($projectTitle, $route, $reminder));
            return Redirect::to(url('/' . Auth::user()->roles[0]->name . '/estimate-quote'))->with('success', trans('site.requestExplorationTour')); // redirect
        } catch (\Exception $e) {
            return response()->json(["MSG" => $e->getMessage()]);
        }
    }

    public function removeTeamRankItem(Request $request)
    {
        if (ProjectTeamRankItem::where('id', $request['id'])->delete()) {
            $arr = ['msg' => __('site.mission_completed'), 'status' => true];
        } else {
            $arr = ['msg' => __('site.error'), 'status' => false];
        }
        return response()->json($arr);
    }
}