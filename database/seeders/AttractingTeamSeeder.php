<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AttractingTeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $insertions = [[
                'avatar'                        => 'uploads/users-avatar/blank.png',
                'name'                          => 'اسم المشرف الأول',
                'national_id'                   => '1234567891',
                'mobile'                        => '0500000001',
                'region_id'                     => 1,
                'city_id'                       => 1,
                'email'                         => 'supervisor01@al-fares.sa',
                'type_id'                       => 4,
                'enrolled_date'                 => '2023-02-01',
                'accomplished_projects'         => 4,
                'performance_percentage'        => 100
        ],[
                'avatar'                        => 'uploads/users-avatar/blank.png',
                'name'                          => 'اسم المشرف الثاني',
                'national_id'                   => '1234567892',
                'mobile'                        => '0500000002',
                'region_id'                     => 1,
                'city_id'                       => 1,
                'email'                         => 'supervisor02@al-fares.sa',
                'type_id'                       => 4,
                'enrolled_date'                 => '2023-02-01',
                'accomplished_projects'         => 4,
                'performance_percentage'        => 99
        ],[
                'avatar'                        => 'uploads/users-avatar/blank.png',
                'name'                          => 'اسم المشرف الثالث',
                'national_id'                   => '1234567893',
                'mobile'                        => '0500000003',
                'region_id'                     => 1,
                'city_id'                       => 1,
                'email'                         => 'supervisor03@al-fares.sa',
                'type_id'                       => 4,
                'enrolled_date'                 => '2023-02-01',
                'accomplished_projects'         => 4,
                'performance_percentage'        => 95
        ],[
                'avatar'                        => 'uploads/users-avatar/blank.png',
                'name'                          => 'اسم المشرف الرابع',
                'national_id'                   => '1234567894',
                'mobile'                        => '0500000004',
                'region_id'                     => 1,
                'city_id'                       => 1,
                'email'                         => 'supervisor04@al-fares.sa',
                'type_id'                       => 4,
                'enrolled_date'                 => '2023-02-01',
                'accomplished_projects'         => 4,
                'performance_percentage'        => 90
        ],[
                'avatar'                        => 'uploads/users-avatar/blank.png',
                'name'                          => 'اسم المشرف الخامس',
                'national_id'                   => '1234567895',
                'mobile'                        => '0500000005',
                'region_id'                     => 1,
                'city_id'                       => 1,
                'email'                         => 'supervisor05@al-fares.sa',
                'type_id'                       => 4,
                'enrolled_date'                 => '2023-02-01',
                'accomplished_projects'         => 4,
                'performance_percentage'        => 85
        ],[
                'avatar'                        => 'uploads/users-avatar/blank.png',
                'name'                          => 'اسم الباحث الأول للمشرف الأول',
                'national_id'                   => '1234567896',
                'mobile'                        => '0500000006',
                'region_id'                     => 1,
                'city_id'                       => 1,
                'email'                         => 'researcher01@al-fares.sa',
                'type_id'                       => 5,
                'enrolled_date'                 => '2023-02-01',
                'accomplished_projects'         => 4,
                'performance_percentage'        => 85
        ],[
                'avatar'                        => 'uploads/users-avatar/blank.png',
                'name'                          => 'اسم الباحث الثاني للمشرف الأول',
                'national_id'                   => '1234567897',
                'mobile'                        => '0500000007',
                'region_id'                     => 1,
                'city_id'                       => 1,
                'email'                         => 'researcher02@al-fares.sa',
                'type_id'                       => 5,
                'enrolled_date'                 => '2023-02-01',
                'accomplished_projects'         => 4,
                'performance_percentage'        => 85
        ],[
                'avatar'                        => 'uploads/users-avatar/blank.png',
                'name'                          => 'اسم الباحث الثالث للمشرف الأول',
                'national_id'                   => '1234567898',
                'mobile'                        => '0500000008',
                'region_id'                     => 1,
                'city_id'                       => 1,
                'email'                         => 'researcher03@al-fares.sa',
                'type_id'                       => 5,
                'enrolled_date'                 => '2023-02-01',
                'accomplished_projects'         => 4,
                'performance_percentage'        => 85
        ],[
                'avatar'                        => 'uploads/users-avatar/blank.png',
                'name'                          => 'اسم الباحث الرابع للمشرف الثاني',
                'national_id'                   => '1234567899',
                'mobile'                        => '0500000009',
                'region_id'                     => 1,
                'city_id'                       => 1,
                'email'                         => 'researcher04@al-fares.sa',
                'type_id'                       => 5,
                'enrolled_date'                 => '2023-02-01',
                'accomplished_projects'         => 4,
                'performance_percentage'        => 85
        ],[
                'avatar'                        => 'uploads/users-avatar/blank.png',
                'name'                          => 'اسم الباحث الخامس للمشرف الثاني',
                'national_id'                   => '1234567810',
                'mobile'                        => '0500000010',
                'region_id'                     => 1,
                'city_id'                       => 1,
                'email'                         => 'researcher05@al-fares.sa',
                'type_id'                       => 5,
                'enrolled_date'                 => '2023-02-01',
                'accomplished_projects'         => 4,
                'performance_percentage'        => 85
        ],[
                'avatar'                        => 'uploads/users-avatar/blank.png',
                'name'                          => 'اسم الباحث السادس للمشرف الثاني',
                'national_id'                   => '1234567811',
                'mobile'                        => '0500000011',
                'region_id'                     => 1,
                'city_id'                       => 1,
                'email'                         => 'researcher06@al-fares.sa',
                'type_id'                       => 5,
                'enrolled_date'                 => '2023-02-01',
                'accomplished_projects'         => 4,
                'performance_percentage'        => 85
        ],[
                'avatar'                        => 'uploads/users-avatar/blank.png',
                'name'                          => 'اسم الباحث السابع للمشرف الثاني',
                'national_id'                   => '1234567812',
                'mobile'                        => '0500000012',
                'region_id'                     => 1,
                'city_id'                       => 1,
                'email'                         => 'researcher07@al-fares.sa',
                'type_id'                       => 5,
                'enrolled_date'                 => '2023-02-01',
                'accomplished_projects'         => 4,
                'performance_percentage'        => 85
        ],[
                'avatar'                        => 'uploads/users-avatar/blank.png',
                'name'                          => 'اسم الباحث الثامن للمشرف الثالث',
                'national_id'                   => '12345678134',
                'mobile'                        => '0500000013',
                'region_id'                     => 1,
                'city_id'                       => 1,
                'email'                         => 'researcher08@al-fares.sa',
                'type_id'                       => 5,
                'enrolled_date'                 => '2023-02-01',
                'accomplished_projects'         => 4,
                'performance_percentage'        => 85
        ],[
                'avatar'                        => 'uploads/users-avatar/blank.png',
                'name'                          => 'اسم المدقق الأول',
                'national_id'                   => '1234567813',
                'mobile'                        => '0500000013',
                'region_id'                     => 1,
                'city_id'                       => 1,
                'email'                         => 'audit01@al-fares.sa',
                'type_id'                       => 3,
                'enrolled_date'                 => '2023-02-01',
                'accomplished_projects'         => 4,
                'performance_percentage'        => 85
        ],[
                'avatar'                        => 'uploads/users-avatar/blank.png',
                'name'                          => 'اسم المدقق الثاني',
                'national_id'                   => '12345678131',
                'mobile'                        => '0500000013',
                'region_id'                     => 1,
                'city_id'                       => 1,
                'email'                         => 'audit02@al-fares.sa',
                'type_id'                       => 3,
                'enrolled_date'                 => '2023-02-01',
                'accomplished_projects'         => 4,
                'performance_percentage'        => 85
        ],[
                'avatar'                        => 'uploads/users-avatar/blank.png',
                'name'                          => 'اسم المدقق الثالث',
                'national_id'                   => '12345678133',
                'mobile'                        => '0500000013',
                'region_id'                     => 1,
                'city_id'                       => 1,
                'email'                         => 'audit03@al-fares.sa',
                'type_id'                       => 3,
                'enrolled_date'                 => '2023-02-01',
                'accomplished_projects'         => 4,
                'performance_percentage'        => 85
        ],[
                'avatar'                        => 'uploads/users-avatar/blank.png',
                'name'                          => 'اسم المدقق الرابع',
                'national_id'                   => '123456781352',
                'mobile'                        => '0500000013',
                'region_id'                     => 1,
                'city_id'                       => 1,
                'email'                         => 'audit04@al-fares.sa',
                'type_id'                       => 3,
                'enrolled_date'                 => '2023-02-01',
                'accomplished_projects'         => 4,
                'performance_percentage'        => 85
        ],[
                'avatar'                        => 'uploads/users-avatar/blank.png',
                'name'                          => 'اسم المدقق الخامس',
                'national_id'                   => '12345678135',
                'mobile'                        => '0500000013',
                'region_id'                     => 1,
                'city_id'                       => 1,
                'email'                         => 'audit05@al-fares.sa',
                'type_id'                       => 3,
                'enrolled_date'                 => '2023-02-01',
                'accomplished_projects'         => 4,
                'performance_percentage'        => 85
        ]];

       DB::table('attracting_team')->insert($insertions);
    }
}
