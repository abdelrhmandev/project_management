<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProjectTrainingTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $insertions = [
            [
                'project_id'                  => 1,
                'training_count'              => 2,
                'training_on'                 => 'كاشف',
                'training_type'               => 'حضوري',
                'participant_type'            => 'طلاب',
                'duration'                    => '5',
                'training_date'               => '2023-02-20',
                'is_hall_required'            => '0',
                'training_agenda'             => 'uploads/projects/rfp_1.pdf',
                'trainee_list'                => 'uploads/projects/rfp_2.pdf',
            ], [
                'project_id'                  => 2,
                'training_count'              => 2,
                'training_on'                 => 'ثاني تدريب',
                'training_type'               => 'حضوري',
                'participant_type'            => 'طلاب',
                'duration'                    => '5',
                'training_date'               => '2023-02-20',
                'is_hall_required'            => '0',
                'training_agenda'             => 'uploads/projects/rfp_2.pdf',
                'trainee_list'                => 'uploads/projects/rfp_2.pdf',
            ]
        ];

        DB::table('project_training_type')->insert($insertions);
    }
}
