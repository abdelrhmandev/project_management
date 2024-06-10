<?php

namespace App\Exports;
use App\Models\ProjectObserverTeam;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithProperties;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ClientTeamExport implements FromCollection, WithProperties, ShouldAutoSize, WithHeadings
{

    public static $projectId;

    public function __construct($ID){
        self::$projectId = $ID;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return ProjectObserverTeam::selectRaw('name,national_id,trans,occupation,qualifications.title')
        ->join("attracting_team", "attracting_team.id", "=", "project_observer_team.team_user_id")
        ->join("team_rank_types", "attracting_team.type_id", "=", "team_rank_types.id")
        ->leftJoin("qualifications", "attracting_team.qualification_id", "=", "qualifications.id")
            ->where("project_id",self::$projectId)->orderBy("project_observer_team.created_at", "DESC")->get();
    }

    public function properties(): array
  {
    return [
      'creator'        => 'Al-Fares',
      'lastModifiedBy' => 'Al-Fares Project',
      'title'          => 'Project Client Team',
      'description'    => 'File for client team work',
      'subject'        => 'Client Team',
      'keywords'       => 'xlsx,export,spreadsheet,clients',
      'category'       => 'TeamWork',
      'manager'        => 'Al-Fares Manager',
      'company'        => 'Al-Fares for searching & studies',
    ];
  }

  public function headings(): array
  {
    return ["الاسم", "رقم الهوية","الدور","المهنة","المؤهل"];
  }

}
