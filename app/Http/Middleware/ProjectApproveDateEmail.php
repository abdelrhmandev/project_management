<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ProjectApproveDateEmail
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
        $projectEmails = "";
        $users= \App\Models\User::with('roles')->get();
        foreach ($users as $user) :
            if($user->roles[0]->id == 2 && $user->roles[0]->name == 'project') :
                $projectEmails .= $user->email.',';
            endif;
        endforeach;
        
        $emails = substr_replace($projectEmails,"",strripos($projectEmails,','));
      
       $projects = \App\Models\Project::select('id','title','potential_approved_date AS PADate',\DB::raw('CURDATE() AS cDate'))
        ->whereNotNull('potential_approved_date')
        ->get();
       
         foreach($projects as $p) :
            if($p->PADate >= $p->cDate) :
                
                $mailData = [
                    'project_title' => $p->title,
                    'route'         => url('/projects/'.$p->id.'/edit')
                ];
                 
              \Mail::to($emails)->send(new \App\Mail\ProjectApproveDate($mailData));
            endif;
         endforeach;
        
        return $next($request);
    }
}
