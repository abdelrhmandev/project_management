<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProjectTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $insertions = [
            ['title' => 'تنمية أسرية', 'icon' => 'family-development'],
            ['title' => 'تنمية محلية', 'icon' => 'local-development'],
            ['title' => 'إعادة توطين', 'icon' => 'rehabilitate'],
            ['title' => 'دراسة أثر', 'icon' => 'effect-stuides'],
            ['title' => 'خطة أثر', 'icon' => 'effect-plan'],
            ['title' => 'مراجعة دراسة أثر', 'icon' => 'review-effect-studies'],
            ['title' => 'مراجعة خطة أثر', 'icon' => 'review-effect-plan'],
            ['title' => 'مراجعة التقرير السنوي', 'icon' => 'review-annual-report'],
            ['title' => 'تمكين الجمعيات', 'icon' => 'empower_charities'],
            ['title' => 'زيارة تفتيشية', 'icon' => 'inspection-visit'],
            ['title' => 'إستشارية (خبراء)', 'icon' => 'consultation'],
            ['title' => 'جمع البيانات', 'icon' => 'collect-data'],
            //['title' => 'تدريب للتعدين', 'icon' => 'mining-training'],
            ['title' => 'تدريب تعاوني', 'icon' => 'collaborative-training'],
        ];

        DB::table('project_types')->insert($insertions);
    }
}