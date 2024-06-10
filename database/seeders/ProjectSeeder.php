<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $project1 = \App\Models\Project::create([
            'status_id'                     => '1',
            'progress_bar'                  => 8.3,
            'logo'                          => 'uploads/projects/3TE7DYuz2BUgxoG9th61cq3Ea.jpg',
            'type_id'                       => '1',
            'title'                         => 'قرية الخنيقية',
            'potential_approved_date'       => '2023-01-30',
            'start_date'                    => '2023-01-30',
            'end_date'                      => '2023-02-20',
            'cases_count'                   => 50,
            'building_count'                => 25,
            'customer_id'                   => 1,
            'rfp'                           => 'uploads/projects/rfp_1.pdf',
            'additional_questions'          => 'uploads/projects/additional_questions_1.pdf',
            'requirements_specifications'   => 'uploads/projects/requirements_specifications_1.pdf',
            'google_map'                    => 'uploads/projects/google_map_1.pdf',
            'opening'                       => '0',
            'opening_reserve_hall'          => '1',
            'opening_attendance_nature'     => 'leaders',
            'opening_date'                  => '2023-02-13',
            'closing'                       => '0',
            'closing_reserve_hall'          => '1',
            'closing_attendance_nature'     => 'regulars',
            'closing_date'                  => '2023-05-30',
        ]);

        \App\Models\ProjectRegion::create([
            'project_id' => $project1->id,
            'region_id' => '1'
        ]);
        \App\Models\ProjectRegion::create([
            'project_id' => $project1->id,
            'region_id' => '2'
        ]);
        \App\Models\ProjectRegion::create([
            'project_id' => $project1->id,
            'region_id' => '3'
        ]);

        $project2 = \App\Models\Project::create([
            'status_id'                     => '2',
            'progress_bar'                  => 16.6,
            'logo'                          => 'uploads/projects/OAgTvvz03wirhm8oHfU9mJxhP.png',
            'type_id'                       => '3',
            'title'                         => 'قرية حموان',
            'potential_approved_date'       => '2023-01-30',
            'start_date'                    => '2023-03-17',
            'end_date'                      => '2023-05-10',
            'cases_count'                   => 50,
            'building_count'                => 25,
            'customer_id'                   => 2,
            'rfp'                           => 'uploads/projects/rfp_2.pdf',
            'additional_questions'          => 'uploads/projects/additional_questions_2.pdf',
            'requirements_specifications'   => 'uploads/projects/requirements_specifications_2.pdf',
            'google_map'                    => 'uploads/projects/google_map_2.pdf',
            'opening'                       => '1',
            'opening_reserve_hall'          => '0',
            'opening_attendance_nature'     => 'regulars',
            'opening_date'                  => '2023-06-13',
            'closing'                       => '1',
            'closing_reserve_hall'          => '0',
            'closing_attendance_nature'     => 'leaders',
            'closing_date'                  => '2023-08-30',
        ]);

        \App\Models\ProjectRegion::create([
            'project_id' => $project2->id,
            'region_id' => '1'
        ]);
        \App\Models\ProjectRegion::create([
            'project_id' => $project2->id,
            'region_id' => '5'
        ]);
    }
}
