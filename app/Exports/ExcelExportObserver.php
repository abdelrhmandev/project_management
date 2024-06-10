<?php

namespace App\Exports;

use App\Models\ProjectObserverTeam;
use App\Models\ProjectAuditorTeam;
use App\Models\AttractingTeam;
use App\Models\ProjectFieldworkTeam;
use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithProperties;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExcelExportObserver implements FromCollection, WithProperties, ShouldAutoSize, WithHeadings
{
  public static $projectID;

  public function __construct($pID)
  {
    self::$projectID = $pID;
  }

  /**
   * @return \Illuminate\Support\Collection
   */
  public function collection()
  {
    $IDs = [];
    $fielworkIds = [];
    $observers = ProjectObserverTeam::select("team_user_id")->where("project_id", self::$projectID)->get();
    $auditors = ProjectAuditorTeam::select("team_user_id")->where("project_id", self::$projectID)->get();
    $fielwork = ProjectFieldworkTeam::select("user_id")->where("project_id", self::$projectID)->get();

    foreach ($auditors as $ad) :
      $IDs[] = $ad->team_user_id;
    endforeach;

    foreach ($observers as $ob) :
      $IDs[] = $ob->team_user_id;
    endforeach;

    foreach ($fielwork as $field) :
      $fielworkIds[] = $field->team_user_id;
    endforeach;

    /*
    ORIGINAL CODE
     $attracting_team = AttractingTeam::select('name', 'national_id')->whereIn('id', $IDs);
     return User::select('name', 'national_id')->whereIn('id', $fielworkIds)->union($attracting_team)->get();
    */

    $attracting_team = AttractingTeam::select('name', 'national_id', 'team_rank_types.trans', 'email', 'mobile', 'regions.title', 'cities.title AS CT')
      ->join("team_rank_types", "attracting_team.type_id", "=", "team_rank_types.id")
      ->join("regions", "attracting_team.region_id", "=", "regions.id")
      ->join("cities", "attracting_team.city_id", "=", "cities.id")

      ->whereIn('attracting_team.id', $IDs);
    return $attracting_team->get();


  }

  public function properties() : array
  {
    return [
      'creator' => 'Al-Fares',
      'lastModifiedBy' => 'Al-Fares Project',
      'title' => 'Prject Accounts',
      'description' => 'File for project accounts team',
      'subject' => 'Accounts Team',
      'keywords' => 'xlsx,export,spreadsheet,accounts',
      'category' => 'Accounts',
      'manager' => 'Al-Fares Manager',
      'company' => 'Al-Fares for searching & studies',
    ];
  }

  public function headings() : array
  {
    return ["الاسم", "رقم الهوية", 'الرتبه', 'البريد الإلكتروني', 'الجوال', 'المنطقه', 'المدينه'];
  }
}