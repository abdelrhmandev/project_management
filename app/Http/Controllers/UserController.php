<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use DataTables;

class UserController extends Controller
{
    protected $model;
    protected $resource;
    protected $trans_file;

    public function __construct(User $model)
    {
        $this->model = $model;
        $this->resource = 'users';
        $this->trans_file = 'user';
    }

    public function index(Request $request)
    {
        $query = $this->model;
        if ($request->ajax()) {
            return Datatables::of($query->latest())
                ->addIndexColumn()
                ->editColumn('title', function ($row) {
                    $route = route($this->resource . '.edit', $row->id);
                    $div = "<div class=\"d-flex align-items-center\">";
                    $div .= "<a href=" . $route . " class=\"symbol symbol-50px\" title='" . $row->name . "'>
                                <div class=\"symbol-label fs-3 bg-light-primary text-primary\">" . ($row->name) . "</div>
                            </a>";
                    $div .= "<div class=\"ms-5\">
                                <a href=" . $route . " class=\"text-gray-800 text-hover-primary fs-5 fw-bold mb-1\" data-kt-recipes-filter=\"item\">" . $row->name . "</a>
                            </div>";
                    $div .= "</div>";
                    return $div;
                })

                ->editColumn('created_at', function ($row) {
                    return $row->created_at->format('d/m/Y');
                })

                ->editColumn('actions', function ($row) {
                    return view('includes.datatables.btns.edit-destroy', ['edit_route' => route($this->resource . '.edit', $row->id), 'destroy_route' => route($this->resource . '.destroy', $row->id), 'id' => $row->id]);
                })

                ->rawColumns(['name', 'guard_name', 'created_at', 'actions'])
                ->make(true);
        }

        $compact                          = [
            'trans_file'                      => $this->trans_file,
            'resource'                        => $this->resource,
            'counter'                         => $query->count(),

        ];
        return view($this->resource . '.index', $compact);
    }

    public function create()
    {
        $roles = Role::pluck('name', 'name')->all();
        echo 'asdas';
    }

    public function store(Request $request)
    {
        // Product::whereId($request -> product_id) -> update($request -> only(['price','special_price','special_price_type','special_price_start','special_price_end']));
    }

    public function edit($id)
    {
    }

    public function update(Request $request, $id)
    {
    }

    public function destroy($id)
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
}
