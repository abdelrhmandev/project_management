<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Role;

class ProjectView
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $roles = Role::select('name')
            ->where('id', '<>', '1')
            ->where('name', '<>', 'admin')
            ->get();
        foreach ($roles as $r) :
            if ($request->path() == $r->name . 's/' . $request[$r->name] . '/edit/' . $request['status']) :
                $exist = DB::table('project_views')
                    ->where('user_id', Auth::user()->id)
                    ->where('project_id', $request[$r->name])
                    ->where('status_id', $request['status'])
                    ->exists();
                if ($exist) :
                    DB::table('project_views')
                        ->where('user_id', Auth::user()->id)
                        ->where('project_id', $request[$r->name])
                        ->where('status_id', $request['status'])
                        ->update([
                            'is_seen' => '1'
                        ]);
                endif;
            endif;
        endforeach;

        return $next($request);
    }
}
