<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EquipmentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $insertions = [
            ['title' =>  'التجهيزات العامه'],
            ['title' =>  'تجهيزات قسم التدريب'],
            ['title' =>  'تجهيزات افتتاح المشروع'],
            ['title' =>  'تجهيزات التدقيق'],
        ];

        DB::table('equipment_types')->insert($insertions);
    }
}
