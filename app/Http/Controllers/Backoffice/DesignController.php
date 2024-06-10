<?php

namespace App\Http\Controllers\Backoffice;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\AttractingTeam;
use DataTables;
use App\Traits\UploadAble;

class DesignController extends Controller
{
    protected $model;
    protected $resource;
    protected $trans_file;
    protected $blade_path;
    protected $COMMON_HELPER;
    use UploadAble;

    public function __construct()
    {
        $this->middleware('seen', ['only' => ['edit']]);
        $this->resource = 'design';
        $this->blade_path = 'backoffice.design';
        $this->trans_file = 'project';
        $this->COMMON_HELPER = app('App\Helpers\Common');
    }

    public function index()
    {
        $this->blade_path = 'backoffice.design.index';

        $compact = [
            // 'rows'                            => $this->model::select('id', 'logo', 'title', 'building_count', 'cases_count', 'start_date', 'end_date', 'status_id', 'progress_bar')->where('is_training_correction', '1')->latest()->paginate(12),
            // 'trans_file'                      => $this->trans_file,
            // 'resource'                        => $this->resource,
            // 'status'                          => ProjectStatus::select('id', 'title', 'trans')->get(),
            // 'types'                           => ProjectType::select('id', 'title')->get(),
            // 'regions'                         => Region::select('id', 'title')->get(),
            // 'customers'                       => Customer::select('id', 'title')->get(),
            // 'equipments'                      => Equipment::get(),
            // 'task_type'                       => 'correction',
            // 'counter'                         => $this->model::select('id', 'logo', 'title', 'building_count', 'cases_count', 'start_date', 'end_date', 'status_id', 'progress_bar')->where('is_training_correction', '1')->count(),
        ];

        return view($this->blade_path, $compact);
    }

    public function processed(Request $request)
    {
        $query = AttractingTeam::select('id', 'name', 'en_name', 'avatar', 'is_processed')->where('is_processed', '1');
        if ($request->ajax()) {
            return Datatables::of($query->latest())
                ->addIndexColumn()
                ->editColumn('name', function ($row) {
                    return $row->name;
                })
                ->editColumn('en_name', function ($row) {
                    return $row->en_name ?? 'غير متاح';
                })
                ->editColumn('avatar', function ($row) {
                    $route = '';
                    $div = "<div class=\"d-flex align-items-center\">";
                    if ($row->avatar) {
                        $src = asset('storage/' . $row->avatar);
                        $div .= "<a href=" . $src . " download class=\"badge badge-light-success\"><div class=\"symbol-group symbol-hover p-2 mb-2\">
                       <div class=\"symbol symbol-circle symbol-25px\"><img src=" . $src . " alt=\"\" /></div>
                       &nbsp;
                       <span class=\"fs-7 fw-bold text-muted\">تحميل الصور</span></div> </a>";
                    }
                    return $div;
                })
                ->editColumn('actions', function ($row) {
                    return '<button type="button" id="' . $row->id . '" data-id="' . $row->id . '" onclick="return attractingTeamDetails(' . $row->id . ')" class="btn btn-sm btn-flex btn-light-success">تعديل</button>';
                })

                ->rawColumns(['name', 'avatar', 'en_name', 'actions'])
                ->make(true);
        }
        $compact = [
            'trans_file' => 'user',
            'resource' => 'admin.users.',
            'counter' => $query->count(),
        ];

        return view('backoffice.design.processed', $compact);
    }

    public function unprocessed(Request $request)
    {
        $query = AttractingTeam::select('id', 'name', 'en_name', 'avatar', 'is_processed')->where('avatar', '!=', '')->where('is_processed', '0');
        if ($request->ajax()) {
            return Datatables::of($query->latest())
                ->addIndexColumn()
                ->editColumn('name', function ($row) {
                    return $row->name;
                })
                ->editColumn('en_name', function ($row) {
                    return $row->en_name ?? 'غير متاح';
                })
                ->editColumn('avatar', function ($row) {
                    $route = '';
                    $div = "<div class=\"d-flex align-items-center\">";
                    if ($row->avatar) {
                        $src = $row->avatar;
                        $div .= "<a href=" . $src . " download class=\"badge badge-light-success\"><div class=\"symbol-group symbol-hover p-2 mb-2\">
                       <div class=\"symbol symbol-circle symbol-25px\"><img src=" . $src . " alt=\"\" /></div>
                       &nbsp;
                       <span class=\"fs-7 fw-bold text-muted\">تحميل الصور</span></div> </a>";
                    }

                    return $div;
                })
                ->editColumn('actions', function ($row) {
                    return '<button type="button" id="' . $row->id . '" data-id="' . $row->id . '" onclick="return attractingTeamDetails(' . $row->id . ')" class="btn btn-sm btn-flex btn-light-success">تعديل</button>';
                })
                ->rawColumns(['name', 'avatar', 'en_name', 'actions'])
                ->make(true);
        }

        $compact = [
            'trans_file' => 'user',
            'resource' => 'admin.users.',
            'counter' => $query->count(),
        ];

        return view('backoffice.design.unprocessed', $compact);
    }

    public function attractingTeamEdit(Request $request)
    {
        $id = $request->id;
        $response = AttractingTeam::select('id', 'name', 'en_name', 'avatar', 'is_processed')->find($id);
        return $response;
    }

    public function attractingTeamPost(Request $request)
    {
        $AttractingTeam = AttractingTeam::where('id', $request->id)->first();
        $avatar = $AttractingTeam->avatar;
        if (! empty($request->avatar)) {
            if (Storage::disk('public')->exists($AttractingTeam->avatar)) {
                Storage::disk('public')->delete($AttractingTeam->avatar);
            }

            $avatar = $this->uploadOne($request->avatar, 'users-avatar');
        }

        $is_processed = $request->is_processed;
        if (AttractingTeam::where('id', $request->id)->update(
            [
                'name' => $request->name,
                'en_name' => $request->en_name,
                'avatar' => $avatar,
                'is_processed' => $is_processed
            ]
        )) {
            return response()->json([
                'status' => true,
                'msg' => 'تم معالجه الصور بنجاح'
            ]);
        } else {
            return response()->json([
                'status' => true,
                'msg' => 'خطأ في معالجه الصور '
            ]);
        }
    }
}