<?php

use Carbon\Carbon;
use App\Models\ProjectContracts;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/
Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('command:clearappcaching', function () {
    Artisan::call('cache:clear'); // Clear application cache:
    Artisan::call('route:cache'); //Clear route cache:
    Artisan::call('config:cache'); //Clear config cache:
    Artisan::call('view:clear');  // Clear view cache:
})->describe('clear application cache, route cache, config cache & view cache');

Artisan::command('command:contractshandler', function () {
    $CheckExistContractExp = ProjectContracts::where('send_date', '<', Carbon::now()->subDay(1))->where('approved', '0')->whereNull('rejection_reason');
    if ($CheckExistContractExp->exists()) {
        $ids = [];
        foreach ($CheckExistContractExp->get() as $value) {
            $ids[] = $value->team_user_id;
        }

        DB::table('project_contracts')->whereIn('team_user_id', $ids)->delete();
        DB::table('project_observer_team')->whereIn('team_user_id', $ids)->delete();
        DB::table('project_auditor_team')->whereIn('team_user_id', $ids)->delete();
    }
})->describe('delete users who have contracts exipred');

Artisan::command('command:emailsent', function () {
    $this->comment(\App\Http\Controllers\Backoffice\FollowupController::_sentEmailReminder());
})->describe('Send email reminder after an hour if user not seen the project');

Artisan::command('command:projectemail', function () {
    $this->comment(\App\Http\Controllers\Backoffice\ProjectController::_sendProjectApproveDateEmail());
})->describe('Send email to every project role if project approve date >= current date');

Artisan::command('warning:email', function () {
    $this->comment(\App\Http\Controllers\Backoffice\ProjectController::_sendProjectWarningEmail());
})->describe('Send email if project has no preparation days or ...');
