<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class KashifController extends Controller
{
    public function recive()
    {
        $data   = [];
        if (request('token') == 'validchecktoken') {
            $json   = json_decode(request('data'), true);
            if (is_array($json)) {
                foreach ($json as $key => $val) {
                    $data[] = DB::table($key)->insertGetId($val);
                }
            }
        }
        return response()->json($data);
    }

    public function output()
    {
        $data = [];
        if (request('token') == 'validchecktoken') {
            $json   = json_decode(request('data'), true);
            if (is_array($json)) {
                foreach ($json as $key => $val) {
                    $query = DB::table($key);
                    if (isset($val['columns'])) {
                        $query->select($val['columns']);
                    }
                    if (isset($val['where'])) {
                        $query->where($val['where']);
                    }
                    $data[$key] = $query->{$val['type']}();
                }
            }
        }
        return response()->json($data);
    }
}
