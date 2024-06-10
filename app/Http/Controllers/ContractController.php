<?php

namespace App\Http\Controllers;

use App\Traits\Functions;
use Illuminate\Http\Request;
use App\Models\AttractingTeam;
use App\Models\ProjectTeamRankItem;

class ContractController extends Controller
{
    protected $resource;
    protected $blade_path;
    protected $trans_file;
    use Functions;

    public function __construct()
    {
        $this->resource = 'project_contracts';
        $this->blade_path = 'pages.contracts';
        $this->trans_file = 'site';
    }

    public function index()
    {
        $attracting = AttractingTeam::findOrFail(1);
        $items = ProjectTeamRankItem::get();
        $jobX = 'research';
        if ($jobX == 'audit') {
            $contract_head_title = 'عقد مدقق';
            $project_title = 'sdsad';
            $job = 'dsdsadasd';
        } elseif ($jobX == 'field_supervisor') {
            $contract_head_title = 'عقد المشرف الميداني';
            $project_title = 'المسح الميداني الإجتماعي';
            $job = 'مشرف ميداني';
        } elseif ($jobX == 'observer') {
            $contract_head_title = 'عقد مراقب';
            $project_title = 'sdasdas';
            $job = 'dsadsd';
        } elseif ($jobX == 'research') {
            $contract_head_title = 'عقد باحث';
            $project_title = 'الديسة';
            $job = 'باحث إجتماعي';
        }

        $out_put = $this->getTitle($contract_head_title, $attracting);
        $out_put .= $this->preface($project_title, $job);
        $out_put .= $this->contarctArticlethree($jobX, $items, $attracting);

        $this->generateContract($job, $out_put, $items, $attracting);
    }

    public function store(Request $request)
    {
    }
}
