<?php

namespace app\Helpers;

use App\Models\ProjectFinancialEstimate;
use App\Models\Project;
use App\Models\User;
use App\Mail\ProjectTransaction;
use Illuminate\Http\Request;
use App\Models\ProjectTransactionHistory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Models\ProjectObstacle;

class Common
{
    public function notifications()
    {
        if (Auth::check()) {
            $notifications = auth()->user()->unreadNotifications;
            return $notifications;
        }
    }

    public function project_notifications()
    {
        if (Auth::check()) {
            $project_notifications = auth()->user()->unreadNotifications->where('type', 'App\Notifications\ProjectNotification');
            return $project_notifications;
        }
    }

    public function RejectedProjectsPlanningCounter()
    {
        return DB::table('project_executive_planning')->where('is_approved', '0')->whereNotNull('rejection_file')->count();
    }

    public function fieldwork_notifications()
    {
        if (Auth::check()) {
            $fieldwork_notifications = auth()->user()->unreadNotifications->where('type', 'App\Notifications\FieldWorkNotification');
            return $fieldwork_notifications;
        }
    }

    public function getChatunseenMessageCounter()
    {
        $unseenCounter = 0;
        if (Auth::check()) {
            $unseenCounter = DB::table('ch_messages')->where('seen', 0)->where('to_id', Auth::user()->id)->count();
        }
        return $unseenCounter;
    }

    public function projectCounter()
    {
        $query = Project::get();
        if (Auth::check()) {
            if (@Auth::user()->hasRole('admin')) {
                $query = $query;
            } elseif (Auth::user()->hasAnyRole(['project'])) {
                $query = $query;
            } elseif (Auth::user()->hasAnyRole(['operation'])) {
                $query = $query->where('status_id', '>=', 3);
            } elseif (Auth::user()->hasAnyRole(['it'])) {
                $query = DB::table('projects as p')->select('p.id', 'p.logo', 'p.title', 'p.cases_count', 'p.start_date', 'p.end_date', 'p.status_id', 'p.progress_bar', 'p.created_at')->leftJoin('project_kashef_accounts as k', 'k.project_id', '=', 'p.id')
                    ->where('p.status_id', '>=', 4)->where('p.type_id', '!=', 12)->whereNULL('k.project_id');
            } elseif (Auth::user()->hasAnyRole(['fieldwork'])) {
                $query = $query->where('status_id', '>=', 5)->whereNotIn('type_id', [13, 14]);
            } elseif (Auth::user()->hasAnyRole(['observer'])) {
                $query = DB::table('project_fieldwork_team as pf')
                    ->leftJoin('projects as project', 'pf.project_id', '=', DB::raw('project.id and pf.user_id = ' . Auth::user()->id))
                    ->leftJoin('project_financial_estimate as bid', 'bid.project_id', '=', 'project.id')
                    ->leftJoin('project_transaction_history as pth', 'pth.project_id', '=', 'project.id')
                    ->select('project.id', 'project.logo', 'project.title', 'project.cases_count', 'project.start_date', 'project.end_date', 'project.status_id', 'project.progress_bar', 'project.created_at')
                    ->whereIN('project.status_id', [6, 8, 9, 10])
                    ->whereIN('pth.status_id', [9, 15, 21])
                    ->whereNotIn('project.type_id', [13, 14])
                    ->where('pth.is_done', '0')
                    ->where('pth.user_id', Auth::user()->id);
            } elseif (Auth::user()->hasAnyRole(['auditor'])) {
                $query = DB::table('project_fieldwork_team as pf')
                    ->leftJoin('projects as project', 'pf.project_id', '=', 'project.id')
                    ->leftJoin('project_financial_estimate as bid', 'bid.project_id', '=', 'project.id')
                    ->leftJoin('project_transaction_history as pth', 'pth.project_id', '=', 'project.id')
                    ->select('project.id', 'project.logo', 'project.title', 'project.cases_count', 'project.start_date', 'project.end_date', 'project.status_id', 'project.progress_bar', 'project.created_at')
                    ->whereIN('project.status_id', [6, 8, 9, 10])
                    ->whereIn('pth.status_id', [10, 16])
                    ->whereNotIn('project.type_id', [13, 14])
                    ->where('pth.is_done', '0')
                    ->where('pf.user_id', Auth::user()->id);
            } elseif (Auth::user()->hasAnyRole(['trainer'])) {
                $query = $query->whereIn('status_id', [7, 19]);
            } elseif (Auth::user()->hasAnyRole(['equipment'])) {
                $query = $query->where('status_id', '>=', 5);
            } elseif (Auth::user()->hasAnyRole(['creator'])) {
                $query = DB::table('projects as project')->leftJoin('project_transaction_history as pth', 'pth.project_id', '=', 'project.id')
                    ->whereIn('project.type_id', [10, 12])->where('pth.status_id', 23)->where('pth.is_done', '0');
            } elseif (Auth::user()->hasAnyRole(['inspector'])) {
                $query = $query->where('type_id', '==', 10)->where('status_id', '>=', 10);
            } elseif (Auth::user()->hasAnyRole(['client'])) {
                $query = $row = DB::table('projects')
                    ->leftJoin('customers', 'customers.id', '=', 'projects.customer_id')
                    ->select('projects.status_id', 'projects.id', 'projects.logo', 'projects.title', 'projects.cases_count', 'projects.start_date', 'projects.end_date', 'projects.status_id', 'projects.progress_bar', 'projects.created_at')
                    ->where('customers.user_id', Auth::user()->id);
            } elseif (Auth::user()->hasAnyRole(['finance'])) {
                $query = DB::table('projects')->where('projects.status_id', 20);
            }
        }

        return $query->count();
    }

    public function estimateBidCounter()
    {
        $sqlQuery = DB::table('projects')->select('id', 'logo', 'title', 'cases_count', 'start_date', 'end_date', 'status_id', 'progress_bar')->where('status_id', 2)->where('deleted_at', null);
        return $sqlQuery->count();
    }

    public function handoverEquipmentCount()
    {
        $row = DB::table('project_fieldwork_team as pf')
            ->leftJoin('projects as project', 'pf.project_id', '=', 'project.id')
            ->leftJoin('project_financial_estimate as bid', 'bid.project_id', '=', 'project.id')
            ->select('project.id AS PID', 'project.logo', 'project.title', 'project.cases_count', 'project.start_date', 'project.end_date', 'project.status_id', 'project.progress_bar', 'project.created_at')
            ->where('project.status_id', '=', 12)->where('pf.user_id', Auth::user()->id);

        return $row->count();
    }

    public function projectCorrection()
    {
        if (Auth::user()->hasAnyRole(['observer'])) {
            return DB::table('project_fieldwork_team as pf')->leftJoin('projects as project', 'pf.project_id', '=', 'project.id')->where('project.is_training_correction', '1')->where('pf.user_id', Auth::user()->id)->count();
        } else {
            return Project::select('id', 'logo', 'title', 'building_count', 'cases_count', 'start_date', 'end_date', 'status_id', 'progress_bar')->where('is_training_correction', '1')->count();
        }
    }

    public function projectObsticales()
    {
        if (Auth::user()->hasAnyRole(['admin'])) {
            return ProjectObstacle::select('sender_id', 'user_id', 'project_id')->groupby('project_id')->get()->count();
        } else {
            return ProjectObstacle::select('sender_id', 'user_id', 'project_id')->where('is_close', '0')->where(function ($query) {
                $query->where('sender_id', Auth::user()->id)->orWhere('user_id', Auth::user()->id)->orwhere('user_id', null);
            })->groupby('project_id')->get()->count();
        }
    }

    public function tourCounter()
    {
        if (Auth::check()) {
            $sqlQuery = null;
            if (@Auth::user()->hasRole('operation')) {
                $sqlQuery = DB::table('project_financial_estimate as pf')->select('pr.id', 'pr.logo', 'pr.title', 'pr.cases_count', 'pr.start_date', 'pr.end_date', 'pr.status_id', 'pr.progress_bar', 'pr.created_at')
                    ->leftJoin('projects as pr', 'pr.id', '=', 'pf.project_id')
                    ->where('pf.is_explore_tour_required', '1')->where('deleted_at', null);
            } elseif (Auth::user()->hasAnyRole(['fieldwork'])) {
                $sqlQuery = DB::table('project_financial_estimate as pf')
                    ->select('pr.id', 'pr.logo', 'pr.title', 'pr.cases_count', 'pr.start_date', 'pr.end_date', 'pr.status_id', 'pr.progress_bar', 'pr.created_at')
                    ->leftJoin('projects as pr', 'pr.id', '=', 'pf.project_id')
                    ->leftJoin('project_explore_tour as et', 'pr.id', '=', 'et.project_id')
                    ->where('pf.is_explore_tour_required', '1')->where('et.is_fieldwork_done', '0')->where('deleted_at', null);
            } elseif (Auth::user()->hasAnyRole(['observer'])) {
                $sqlQuery = DB::table('project_financial_estimate as pf')
                    ->select('pr.id', 'pr.logo', 'pr.title', 'pr.cases_count', 'pr.start_date', 'pr.end_date', 'pr.status_id', 'pr.progress_bar', 'pr.created_at')
                    ->leftJoin('projects as pr', 'pr.id', '=', 'pf.project_id')
                    ->leftJoin('project_explore_tour as et', 'pr.id', '=', 'et.project_id')
                    ->where('pf.is_explore_tour_required', '1')->where('deleted_at', null)->where('et.is_fieldwork_done', '1')->where('et.is_observer_done', '0')->where('et.user_id', Auth::user()->id);
            }

            if ($sqlQuery != null) {
                return $sqlQuery->count();
            }
        }
    }

    public function changeProjectStatus(Request $request, $statusId)
    {
        $trainDate = [];
        switch ($statusId) {
            case 3:
                Project::where('id', $request['project_id'])->update([
                    'status_id' => 3,
                    'progress_bar' => 24.9,
                ]);
                break;
            case 4:
                Project::where('id', $request['project_id'])->update([
                    'status_id' => 4,
                    'progress_bar' => 8.3,
                ]);
                break;
            case 5:
                Project::where('id', $request['project_id'])->update([
                    'status_id' => 5,
                    'progress_bar' => 41.5,
                ]);
                break;
            case 6:
                Project::where('id', $request['project_id'])->update([
                    'status_id' => 6,
                    'progress_bar' => 49.8,
                ]);
                break;
            case 7:
                Project::where('id', $request['project_id'])->update([
                    'status_id' => 7,
                    'progress_bar' => 58.1,
                ]);
                break;
            case 71:
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
                ProjectFinancialEstimate::where('project_id', $request['project_id'])->update($trainDate);
                if (
                    ProjectFinancialEstimate::where('project_id', $request['project_id'])
                        ->whereNotNull('auditor_training_date')
                        ->count() > 0
                ) {
                    Project::where('id', $request['project_id'])->update([
                        'status_id' => 7,
                        'progress_bar' => 58.1,
                    ]);
                }
                break;
            case 72:
                if ($request->has("trainrequire")) :
                    $trainDate = [
                        'auditor_training_date' => $request['auditor_training_date'],
                        'auditor_training_required' => '1'
                    ];
                else :
                    $trainDate = [
                        'auditor_training_date' => NULL,
                        'auditor_training_required' => '0'
                    ];
                endif;

                ProjectFinancialEstimate::where('project_id', $request['project_id'])->update($trainDate);
                if (
                    ProjectFinancialEstimate::where('project_id', $request['project_id'])
                        ->whereNotNull('observer_training_date')
                        ->count() > 0
                ) {
                    Project::where('id', $request['project_id'])->update([
                        'status_id' => 7,
                        'progress_bar' => 58.1,
                    ]);
                }
                break;
            case 8:
                Project::where('id', $request['project_id'])->update([
                    'status_id' => 8,
                    'progress_bar' => 66.4,
                ]);
                break;
            case 9:
                Project::where('id', $request['project_id'])->update([
                    'status_id' => 9,
                    'progress_bar' => 66.4,
                ]);
                break;
            case 10:
                Project::where('id', $request['project_id'])->update([
                    'status_id' => 10,
                    'progress_bar' => 83,
                ]);
                break;
            case 11:
                Project::where('id', $request['project_id'])->update([
                    'status_id' => 11,
                    'progress_bar' => 91.3,
                ]);
                break;
            case 12:
                Project::where('id', $request['project_id'])->update([
                    'status_id' => 12,
                    'progress_bar' => 100,
                ]);
                break;
            case 13:
                Project::where('id', $request['project_id'])->update([
                    'status_id' => 13,
                    'progress_bar' => 91.3,
                ]);
                break;
            case 17:
                Project::where('id', $request['project_id'])->update([
                    'status_id' => 17,
                    'progress_bar' => 0,
                ]);
                break;
            case 18:
                Project::where('id', $request['project_id'])->update([
                    'status_id' => 18,
                    'progress_bar' => 100,
                ]);
                break;
            case 19:
                Project::where('id', $request['project_id'])->update([
                    'status_id' => 19,
                    'progress_bar' => 50,
                ]);
                break;
            case 20:
                Project::where('id', $request['project_id'])->update([
                    'status_id' => 20,
                    'progress_bar' => 10,
                ]);
                break;
            default:
                break;
        }

        return true;
    }

    public function handleCaptureTransaction(Request $request, $statusId, $isDone, $userId = 0)
    {
        if ($isDone === '1') {
            $insertions = [
                'user_id' => Auth::user()->id,
                'status_id' => $statusId,
                'is_done' => $isDone,
                'updated_at' => date('Y-m-d H:i:s'),
            ];

            ProjectTransactionHistory::updateOrCreate(['project_id' => $request->project_id, 'status_id' => $statusId, 'user_id' => Auth::user()->id], $insertions);
        } else {
            $insertions = [
                'user_id' => $userId,
                'project_id' => $request->project_id,
                'status_id' => $statusId,
                'is_done' => $isDone,
                'created_at' => date('Y-m-d H:i:s'),
            ];

            ProjectTransactionHistory::create($insertions);
            if ($statusId != 7) {
                $user = User::with('roles')->findOrFail($userId);
                $currentProject = Project::findOrFail($request['project_id']);
                $userEmail = $user->email;
                $userName = $user->roles[0]->name;
                $route = '';
                if ($statusId == 17)
                    $route = url('/equipment/show-accounts/' . $request['project_id']);
                else
                    $route = url('/' . $userName . 's/' . $request['project_id'] . '/edit/' . $currentProject->status_id);

                $mailData = [
                    'project_title' => $currentProject->title,
                    'route' => $route,
                    'reminder' => "no"
                ];

                try {
                    $sendMail = Mail::to($userEmail)->send(new ProjectTransaction($mailData));
                    if ($sendMail) {
                        DB::beginTransaction();
                        try {
                            $exist = DB::table('project_views')->where('user_id', $userId)->where('project_id', $request->project_id)->where('status_id', $statusId)->exists();
                            if (! $exist) :
                                DB::table('project_views')->insert([
                                    'user_id' => $userId,
                                    'project_id' => $request->project_id,
                                    'status_id' => $statusId,
                                    'created_at' => DB::raw('NOW()')
                                ]);
                            endif;
                            DB::commit();
                            return response()->json(['status' => true, 'msg' => __('project.storeMessageSuccess')]);
                        } catch (\PDOException $e) {
                            DB::rollBack();
                            return response()->json(['status' => false, 'msg' => $e->getMessage()]);
                        }
                    }
                } catch (\Exception $e) {
                    return response()->json(['status' => false, 'msg' => $e->getMessage()]);
                }
            }
        }
    }
}