<?php

namespace App\Http\Controllers\Backoffice;

use App\Traits\UploadAble;
use App\Traits\Functions;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\User;
use App\Models\Equipment;
use App\Models\ProjectRedFlag;
use App\Models\ProjectRedFlagReply;
use App\Models\ProjectRedFlagReplyAttachment;
use App\Models\EquipmentType;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Models\AttractingTeam;
use Illuminate\Support\Facades\Storage;
use Shuchkin\SimpleXLSX;
use DataTables;

class AdminController extends Controller
{
    protected $model;
    protected $resource;
    protected $trans_file;
    protected $blade_path;
    use UploadAble, Functions;

    public function AddRedflagsReply($id)
    {
        $compact = [
            'id' => $id,
        ];
        return view('backoffice.admin.redflags.addReply', $compact);
    }

    public function replyRedflag(Request $request)
    {
        if ($request['type'] == 'rejected') {
            if (! (empty($request['redflagReply']))) {
                if ($red_flag_reply_id = ProjectRedFlagReply::insert([
                    'reply' => strip_tags(trim($request['redflagReply'])) ?? NULL,
                    'redflag_id' => $request['redflag_id'],
                    'reply_user_id' => \Auth::user()->id,
                    'created_at' => \DB::raw('NOW()')
                ])) {
                    ProjectRedFlag::where(['id' => $request['redflag_id']])->update(['type' => 'rejected']);
                    if (! (empty($request->file('RedFlag_file')))) {
                        foreach ($request->file('RedFlag_file') as $key => $file) {
                            $target = storage_path() . '/app/public/uploads/projects/client';
                            $source = $file->getClientOriginalName();
                            $file->move($target, $source);
                            $ext = $file->getClientOriginalExtension();
                            $out = storage_path() . "/app/public/uploads/projects/client/" . uniqid(date('t-M')) . "." . $ext;
                            rename(storage_path() . "/app/public/uploads/projects/client/" . $source, $out);
                            $RedFlag_file = stristr($out, "/uploads/");
                            ProjectRedFlagReplyAttachment::insert([
                                "red_flag_reply_id" => $red_flag_reply_id,
                                "file" => $RedFlag_file,
                            ]);
                        }
                    }
                    return response()->json(['icon' => 'success', 'msg' => 'تم إرسال الرد علي البلاغ بنجاح', 'status' => true, 'code' => 200]);
                }
            } else {
                return response()->json(['icon' => 'error', 'msg' => 'برجاء كتابه سبب رفض البلاغ', 'status' => false, 'code' => 401]);
            }
        } else {
            ProjectRedFlag::where([
                'id' => $request['redflag_id'],
                'project_id' => $request['project_id'],
            ])->update(['status' => 'done', 'type' => 'approved']);
            return response()->json(['icon' => 'success', 'msg' => 'تم إرسال الرد علي البلاغ بنجاح', 'status' => true, 'code' => 200]);
        }
    }

    public function redflags(Request $request)
    {
        $query = ProjectRedFlag::has('replies')->with(['files', 'client', 'replies', 'project']);
        if ($request->ajax()) {
            return Datatables::of($query->latest())
                ->addIndexColumn()
                ->editColumn('reply', function ($row) {
                    return $row->title . '<p>' .
                        \Carbon\Carbon::parse($row->created_at)->format('Y/m/d') . ' | ' . \Carbon\Carbon::parse($row->created_at)->diffForHumans()
                        . '</p>';
                })
                ->editColumn('client', function ($row) {
                    return $row->client->name;
                })
                ->editColumn('project', function ($row) {
                    $url = '/project/followup/' . $row->project->id;
                    return "<a href=" . $url . ">" . $row->project->title . "</a>";
                })
                ->editColumn('PM_reply', function ($row) {
                    $r = '';
                    $da = '';
                    foreach ($row->replies as $re) {
                        if ($re->reply_user_id == 2) {
                            $da .= \Carbon\Carbon::parse($re->created_at)->format('Y/m/d') . ' | ' . \Carbon\Carbon::parse($re->created_at)->diffForHumans() . '</p>';
                            $r .= $re->reply . '<p>' . $da . '</p>';
                        }
                    }
                    return $r;
                })
                ->editColumn('actions', function ($row) {
                    $Ar = '';
                    foreach ($row->replies as $re) {
                        if ($re->reply_user_id == 1) {
                            $Ar .= $re->reply . '<p>' . \Carbon\Carbon::parse($re->created_at)->format('Y/m/d') . ' | ' . \Carbon\Carbon::parse($re->created_at)->diffForHumans() . '</p>' . '</p>';
                        }
                    }
                    $url = route('admin.AddRedflagsReply', $row->id);
                    $link = "<a href=" . $url . ">أترد ردك</a>";
                    if (! empty($Ar)) {
                        $link = $Ar;
                    }
                    return $link;
                })
                ->rawColumns(['client', 'project', 'PM_reply', 'reply', 'created_at', 'actions'])
                ->make(true);
        }
        $compact = [
            'trans_file' => 'user',
            'resource' => 'admin.users.',
            'counter' => $query->count(),
        ];
        return view('backoffice.admin.redflags.index', $compact);
    }

    public function markNotification(Request $request)
    {
        auth()->user()->unreadNotifications->markAsRead();
    }

    public function create_equipment()
    {
        $compact = [
            'trans_file' => 'equipment',
            'resource' => 'admin.equipments.',
            'types' => EquipmentType::get(),
        ];

        return view('backoffice.admin.equipments.create', $compact);
    }

    public function equipments(Request $request)
    {
        $this->model = Equipment::select('id', 'type_id', 'title', 'created_at')->with('type');
        $query = $this->model;
        if ($request->ajax()) {
            return Datatables::of($query->latest())
                ->addIndexColumn()
                ->editColumn('type_id', function ($row) {
                    $route = route('admin.equipments.edit', $row->id);
                    return $row->type->title;
                })
                ->editColumn('created_at', function ($row) {
                    return $row->created_at->format('d/m/Y');
                })
                ->editColumn('actions', function ($row) {
                    return view('includes.datatables.btns.edit-destroy', ['edit_route' => route('admin.equipments.edit', $row->id), 'destroy_route' => route('admin.equipments.destroy', $row->id), 'id' => $row->id]);
                })
                ->rawColumns(['type_id', 'created_at', 'actions'])
                ->make(true);
        }
        $compact = [
            'trans_file' => 'equipment',
            'resource' => 'admin.equipments.',
            'counter' => $query->count(),
        ];

        return view('backoffice.admin.equipments.index', $compact);
    }

    public function edit_equipment($id)
    {
        $compact = [
            'row' => Equipment::with('type')->find($id),
            'trans_file' => 'equipment',
            'resource' => 'admin.equipments.',
            'types' => EquipmentType::get(),
        ];

        return view('backoffice.admin.equipments.edit', $compact);
    }

    public function store_equipment(Request $request)
    {
        if (Equipment::create(['type_id' => $request->type_id, 'title' => $request->title])) {
            return back()->with('success', trans('site.storeMessageSuccess'));
        } else {
            return back()->with('success', trans('site.storeMessageError'));
        }
    }

    public function destroy_equipment($id)
    {
        if (Equipment::find($id)->delete()) {
            return response()->json(['status' => 'success', 'msg' => __('site.deleteMessageSuccess')]);
        } else {
            return response()->json(['status' => 'error', 'msg' => __('admin.deleteMessageError')]); // Bad Request
        }
    }

    public function destroyMultipleEquipment(Request $request)
    {
        $ids = $request->ids;
        if (Equipment::whereIn('id', explode(',', $ids))->delete()) {
            return response()->json(['status' => 'success', 'msg' => __('site.deleteMessageSuccess')]);
        } else {
            return response()->json(['status' => 'error', 'msg' => __('admin.deleteMessageError')]); // Bad Request
        }
    }

    public function update_equipment(Request $request, $id)
    {
        if (Equipment::find($id)->update(['type_id' => $request->type_id, 'title' => $request->title])) {
            return back()->with('success', trans('site.updateMessageSuccess'));
        } else {
            return back()->with('success', trans('site.updateMessageError'));
        }
    }

    //////////////////////////////////////Equipment Types//////////////////////////////////////
    public function create_equipment_type()
    {
        $compact = [
            'trans_file' => 'equipment',
            'resource' => 'admin.equipments.',
        ];

        return view('backoffice.admin.equipment_types.create', $compact);
    }

    public function equipment_types(Request $request)
    {
        $this->model = EquipmentType::select('id', 'title');
        $query = $this->model;
        if ($request->ajax()) {
            return Datatables::of($query->get())
                ->addIndexColumn()

                ->editColumn('actions', function ($row) {
                    return view('includes.datatables.btns.edit-destroy', ['edit_route' => route('admin.equipment_type.edit', $row->id), 'destroy_route' => route('admin.equipment_type.destroy', $row->id), 'id' => $row->id]);
                })
                ->rawColumns(['actions'])
                ->make(true);
        }
        $compact = [
            'trans_file' => 'equipment',
            'resource' => 'admin.equipments_type.',
            'counter' => $query->count(),
        ];
        return view('backoffice.admin.equipment_types.index', $compact);
    }

    public function edit_equipment_type($id)
    {
        $compact = [
            'row' => EquipmentType::find($id),
            'trans_file' => 'equipment',
            'resource' => 'admin.equipment_type.',
        ];
        return view('backoffice.admin.equipment_types.edit', $compact);
    }

    public function store_equipment_type(Request $request)
    {
        if (EquipmentType::create(['title' => $request->title])) {
            return back()->with('success', trans('site.storeMessageSuccess'));
        } else {
            return back()->with('success', trans('site.storeMessageError'));
        }
    }

    public function destroy_equipment_type($id)
    {
        if (EquipmentType::find($id)->delete()) {
            return response()->json(['status' => 'success', 'msg' => __('site.deleteMessageSuccess')]);
        } else {
            return response()->json(['status' => 'error', 'msg' => __('admin.deleteMessageError')]); // Bad Request
        }
    }

    public function destroyMultipleEquipmentType(Request $request)
    {
        $ids = $request->ids;
        if (EquipmentType::whereIn('id', explode(',', $ids))->delete()) {
            return response()->json(['status' => 'success', 'msg' => __('site.deleteMessageSuccess')]);
        } else {
            return response()->json(['status' => 'error', 'msg' => __('admin.deleteMessageError')]); // Bad Request
        }
    }

    public function update_equipment_type(Request $request, $id)
    {
        if (EquipmentType::find($id)->update(['title' => $request->title])) {
            return back()->with('success', trans('site.updateMessageSuccess'));
        } else {
            return back()->with('success', trans('site.updateMessageError'));
        }
    }

    ////////////////////////////////////Customers /////////////////////////////////////////////////////
    public function create_customer()
    {
        $compact = [
            'trans_file' => 'customer',
            'resource' => 'admin.customers',
            'users' => User::whereHas(
                'roles', function ($q) {
                    $q->where('id', 14);
                }
            )->get()
        ];

        return view('backoffice.admin.customers.create', $compact);
    }

    public function customers(Request $request)
    {
        $query = Customer::select('id', 'title', 'principal_name', 'principal_position', 'principal_mobile', 'principal_email', 'user_id', 'created_at');
        if ($request->ajax()) {
            return Datatables::of($query->latest())
                ->addIndexColumn()
                ->editColumn('created_at', function ($row) {
                    return $row->created_at->format('d/m/Y');
                })

                ->editColumn('title', function ($row) {
                    $div = '';
                    if ($row->user_id) {
                        $div = '<span class="svg-icon svg-icon-1 svg-icon-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24">
                            <path d="M10.0813 3.7242C10.8849 2.16438 13.1151 2.16438 13.9187 3.7242V3.7242C14.4016 4.66147 15.4909 5.1127 16.4951 4.79139V4.79139C18.1663 4.25668 19.7433 5.83365 19.2086 7.50485V7.50485C18.8873 8.50905 19.3385 9.59842 20.2758 10.0813V10.0813C21.8356 10.8849 21.8356 13.1151 20.2758 13.9187V13.9187C19.3385 14.4016 18.8873 15.491 19.2086 16.4951V16.4951C19.7433 18.1663 18.1663 19.7433 16.4951 19.2086V19.2086C15.491 18.8873 14.4016 19.3385 13.9187 20.2758V20.2758C13.1151 21.8356 10.8849 21.8356 10.0813 20.2758V20.2758C9.59842 19.3385 8.50905 18.8873 7.50485 19.2086V19.2086C5.83365 19.7433 4.25668 18.1663 4.79139 16.4951V16.4951C5.1127 15.491 4.66147 14.4016 3.7242 13.9187V13.9187C2.16438 13.1151 2.16438 10.8849 3.7242 10.0813V10.0813C4.66147 9.59842 5.1127 8.50905 4.79139 7.50485V7.50485C4.25668 5.83365 5.83365 4.25668 7.50485 4.79139V4.79139C8.50905 5.1127 9.59842 4.66147 10.0813 3.7242V3.7242Z" fill="currentColor"></path>
                            <path d="M14.8563 9.1903C15.0606 8.94984 15.3771 8.9385 15.6175 9.14289C15.858 9.34728 15.8229 9.66433 15.6185 9.9048L11.863 14.6558C11.6554 14.9001 11.2876 14.9258 11.048 14.7128L8.47656 12.4271C8.24068 12.2174 8.21944 11.8563 8.42911 11.6204C8.63877 11.3845 8.99996 11.3633 9.23583 11.5729L11.3706 13.4705L14.8563 9.1903Z" fill="white"></path>
                        </svg>
                    </span>(عميل)';
                    }
                    return $row->title . ' ' . $div;
                })


                ->editColumn('actions', function ($row) {
                    return view('includes.datatables.btns.edit-destroy', ['edit_route' => route('admin.customers.edit', $row->id), 'destroy_route' => route('admin.customers.destroy', $row->id), 'id' => $row->id]);
                })
                ->rawColumns(['title', 'created_at', 'actions'])
                ->make(true);
        }

        $compact = [
            'trans_file' => 'customer',
            'resource' => 'admin.customers',
            'counter' => $query->count(),
        ];

        return view('backoffice.admin.customers.index', $compact);
    }

    public function edit_customer($id)
    {
        $compact = [
            'row' => Customer::find($id),
            'trans_file' => 'customer',
            'resource' => 'admin.customers.',
        ];
        return view('backoffice.admin.customers.edit', $compact);
    }

    public function store_customer(Request $request)
    {
        $insertion = [
            'title' => $request['customer-name'],
            'principal_name' => $request['principal-name'],
            'principal_position' => $request['principal-position'],
            'principal_mobile' => $request['principal-mobile'],
            'principal_email' => $request['principal-email'],
            'user_id' => $request['user_id'] ?? NULL,

        ];

        if (Customer::create($insertion)) {
            return back()->with('success', trans('site.storeMessageSuccess'));
        } else {
            return back()->with('success', trans('site.storeMessageError'));
        }
    }

    public function destroy_customer($id)
    {
        if (Customer::find($id)->delete()) {
            return response()->json(['status' => 'success', 'msg' => __('site.deleteMessageSuccess')]);
        } else {
            return response()->json(['status' => 'error', 'msg' => __('admin.deleteMessageError')]); // Bad Request
        }
    }

    public function destroyMultipleCustomer(Request $request)
    {
        $ids = $request->ids;
        if (Customer::whereIn('id', explode(',', $ids))->delete()) {
            return response()->json(['status' => 'success', 'msg' => __('site.deleteMessageSuccess')]);
        } else {
            return response()->json(['status' => 'error', 'msg' => __('admin.deleteMessageError')]); // Bad Request
        }
    }

    public function update_customer(Request $request, $id)
    {
        $update_arr = [
            'title' => $request['customer-name'],
            'principal_name' => $request['principal-name'],
            'principal_position' => $request['principal-position'],
            'principal_mobile' => $request['principal-mobile'],
            'principal_email' => $request['principal-email'],
        ];

        if (Customer::find($id)->update($update_arr)) {
            return back()->with('success', trans('site.updateMessageSuccess'));
        } else {
            return back()->with('success', trans('site.updateMessageError'));
        }
    }

    public function create_user()
    {
        $compact = [
            'trans_file' => 'user',
            'resource' => 'admin.users.',
            'roles' => Role::get(),
        ];

        return view('backoffice.admin.users.create', $compact);
    }

    public function store_user(Request $request)
    {
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'roles' => ['required'],
            'avatar' => ['required', 'mimes:jpeg,jpg,png,gif|max:100000'],
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        $validatedData['region_id'] = 1;
        $validatedData['active_status'] = $request->active_status;
        // Uploaded Files
        $validatedData['avatar'] = ! empty($request->avatar) ? $this->uploadOne($request->avatar, 'users-avatar') : null;
        $user = User::create($validatedData);
        $user->assignRole($request->input('roles'));

        if ($user) {
            return redirect('/admin/users')->with("success", trans('site.storeMessageSuccess'));
        } else {
            return back()->with('success', trans('site.storeMessageError'));
        }
    }

    public function users(Request $request)
    {
        $query = User::with('roles');
        if ($request->ajax()) {
            return Datatables::of($query->latest())
                ->addIndexColumn()
                ->editColumn('role', function ($row) {
                    $role = '';
                    if (! empty($row->getRoleNames())) {
                        foreach ($row->getRoleNames() as $v) {
                            if (! empty($v)) {
                                $role .= $v;
                            }
                        }
                    }
                    return $role;
                })
                ->editColumn('created_at', function ($row) {
                    return $row->created_at->format('d/m/Y');
                })
                ->editColumn('actions', function ($row) {
                    return view('includes.datatables.btns.edit-destroy', ['edit_route' => route('admin.users.edit', $row->id), 'destroy_route' => route('admin.users.destroy', $row->id), 'id' => $row->id]);
                })
                ->editColumn('name', function ($row) {
                    $route = route('admin.users.edit', $row->id);
                    $div = "<div class=\"d-flex align-items-center\">";
                    if ($row->avatar) {
                        $div .=
                            '<a href=' .
                            $route .
                            " title='" .
                            $row->name .
                            "' class=\"symbol symbol-50px\">
                               <span class=\"symbol-label\" style=\"background-image:url(" .
                            asset('storage/' . $row->avatar) .
                            ")\" />
                               </span>
                           </a>";
                    } else {
                        $div .=
                            '<a href=' .
                            $route .
                            " class=\"symbol symbol-50px\" title='" .
                            $row->name .
                            "'>
                                   <div class=\"symbol-label fs-3 bg-light-primary text-primary\">" .
                            $this->str_split($row->name, 1) .
                            "</div>
                          </a>";
                    }

                    $div .=
                        "<div class=\"ms-5\">
                           <a href=" .
                        $route .
                        " class=\"text-gray-800 text-hover-primary\" data-kt-recipes-filter=\"item\">" .
                        $row->name .
                        "</a>
                       </div>";

                    $div .= '</div>';
                    return $div;
                })

                ->editColumn('active_status', function ($row) {
                    if ($row->active_status == 1) {
                        $active_status = "<div class=\"badge py-3 px-4 fs-7 badge-light-success\">" . __('site.activeted') . '</div>';
                    } elseif ($row->active_status == 0) {
                        $active_status = "<div class=\"badge py-3 px-4 fs-7 badge-light-danger\">" . __('site.deactiveted') . '</div>';
                    }
                    return $active_status;
                })

                ->rawColumns(['name', 'active_status', 'created_at', 'actions'])
                ->make(true);
        }
        $compact = [
            'trans_file' => 'user',
            'resource' => 'admin.users.',
            'counter' => $query->count(),
        ];

        return view('backoffice.admin.users.index', $compact);
    }

    public function edit_user($id)
    {
        $compact = [
            'row' => User::with('roles')->find($id),
            'trans_file' => 'user',
            'resource' => 'admin.users.',
            'roles' => Role::get(),
        ];

        return view('backoffice.admin.users.edit', $compact);
    }

    public function destroy_user($id)
    {
        $object = User::where('id', $id)->first();
        if (Storage::disk('public')->exists($object->avatar)) {
            Storage::disk('public')->delete($object->avatar);
        }

        if (User::where('id', $id)->delete()) {
            return response()->json(['status' => 'success', 'msg' => __('site.deleteMessageSuccess')]);
        } else {
            return response()->json(['status' => 'error', 'msg' => __('admin.deleteMessageError')]); // Bad Request
        }
    }

    public function destroyMultipleuser(Request $request)
    {
        $ids = $request->ids;
        $objects = User::whereIn('id', explode(',', $ids))->get();
        foreach ($objects as $object) {
            if (Storage::disk('public')->exists($object->avatar)) {
                Storage::disk('public')->delete($object->avatar);
            }
        }

        if (User::whereIn('id', explode(',', $ids))->delete()) {
            return response()->json(['status' => 'success', 'msg' => __('site.deleteMessageSuccess')]);
        } else {
            return response()->json(['status' => 'error', 'msg' => __('admin.deleteMessageError')]); // Bad Request
        }
    }

    public function update_user(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'username' => 'required|min:8|unique:users,username,' . $id,
            'email' => 'required|email|unique:users,email,' . $id,
        ]);

        $validatedData['active_status'] = $request->active_status;
        $user = User::where('id', $id)->first();
        $validatedData['avatar'] = $user->avatar;

        if (! empty($request->avatar)) {
            if (Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }
            $validatedData['avatar'] = $this->uploadOne($request->avatar, 'users-avatar');
        }

        if (User::where('id', $id)->update($validatedData)) {
            return redirect('/admin/users')->with("success", trans('site.updateMessageSuccess'));
        } else {
            return back()->with('success', trans('site.updateMessageError'));
        }
    }

    public function ImportcsvFileattractingTeamForm()
    {
        return view('backoffice.admin.attracting_team.importForm');
    }

    public function saveCsvFileattractingTeamForm(Request $request)
    {
        $file = $request->imported_users;
        $filename = $file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension(); //Get extension of uploaded file
        $tempPath = $file->getRealPath();
        $fileSize = $file->getSize(); //Get size of uploaded file in bytes//Check for file extension and size
        $location = 'uploads'; //Created an "uploads" folder for that
        $file->move($location, $filename);
        $filepath = public_path($location . '/' . $filename);
        if ($xlsx = SimpleXLSX::parse($filepath)) {
            $header_values = $rows = [];
            foreach ($xlsx->rows() as $k => $r) {
                if ($k === 0) {
                    $header_values = $r;
                    continue;
                }
                $rows[] = array_combine($header_values, $r);
            }
            if (AttractingTeam::insert($rows)) {
                return redirect('/admin/ImportcsvFileattractingTeamForm')->with("success", trans('site.mission_completed'));
            } else {
                return back()->with('success', trans('site.updateMessageError'));
            }
        }
    }
}