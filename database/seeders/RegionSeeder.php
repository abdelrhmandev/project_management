<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RegionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $insertions = [
            ['title'=>'منطقة القصيم'],
            ['title'=>'منطقة الباحة'],
            ['title'=>'منطقة الحدود الشمالية'],
            ['title'=>'منطقة الرياض'],
            ['title'=>'منطقة عسير'],
            ['title'=>'منطقة تبوك'],
            ['title'=>'منطقة المدينة المنورة'],
            ['title'=>'منطقة الجوف'],
            ['title'=>'منطقة نجران'],
            ['title'=>'منطقة جازان'],
            ['title'=>'منطقة حائل'],
            ['title'=>'المنطقة الشرقية'],
            ['title'=>'منطقة مكة المكرمة'],
       ];

       DB::table('regions')->insert($insertions);
    }
}
