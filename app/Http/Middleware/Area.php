<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Auth;
use Closure;

class Area
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle()
    {
        $currentUser = Auth::user();
        if ($currentUser->hasrole('admin')) {
            return redirect(url('/admin'));
        } else if ($currentUser->hasrole('project')) {
            return redirect(url('/project'));
        } else if ($currentUser->hasrole('operation')) {
            return redirect(url('/operation'));
        } else if ($currentUser->hasrole('it')) {
            return redirect(url('/it'));
        } else if ($currentUser->hasrole('fieldwork')) {
            return redirect(url('/fieldwork'));
        } else if ($currentUser->hasrole('observer')) {
            return redirect(url('/observer'));
        }  else if ($currentUser->hasrole('auditor')) {
            return redirect(url('/auditor'));
        } else if ($currentUser->hasrole('trainer')) {
            return redirect(url('/trainer'));
        } else if ($currentUser->hasrole('equipment')) {
            return redirect(url('/equipment'));
        } else if ($currentUser->hasrole('creator')) {
            return redirect(url('/creator'));
        } else if ($currentUser->hasrole('inspector')) {
            return redirect(url('/inspector'));
        } else if ($currentUser->hasrole('design')) {
            return redirect(url('/design'));
        } else if ($currentUser->hasrole('client')) {
            return redirect(url('/client'));
        }else if ($currentUser->hasrole('finance')) {
            return redirect(url('/finance'));
        }
    }
}
