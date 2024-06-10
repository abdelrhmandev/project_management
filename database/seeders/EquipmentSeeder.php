<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class EquipmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('equipments')->delete();

        $insertions                 = [
            [
                'title'               => 'تجهيز رقم واحد',
                'type_id'             => 1,
                'created_at'          => Carbon::now()->format('Y-m-d H:i:s'),
            ],[
                'title'               => 'تجهيز رقم اثنين',
                'type_id'             => 1,
                'created_at'          => Carbon::now()->format('Y-m-d H:i:s'),
            ],[
                'title'               => 'تجهيز رقم ثلاثة',
                'type_id'             => 2,
                'created_at'          => Carbon::now()->format('Y-m-d H:i:s'),
            ],[
                'title'               => 'تجهيز رقم أربعة',
                'type_id'             => 2,
                'created_at'          => Carbon::now()->format('Y-m-d H:i:s'),
            ],[
                'title'               => 'تجهيز رقم خمسة',
                'type_id'             => 3,
                'created_at'          => Carbon::now()->format('Y-m-d H:i:s'),
            ],[
                'title'               => 'تجهيز رقم ستة',
                'type_id'             => 3,
                'created_at'          => Carbon::now()->format('Y-m-d H:i:s'),
            ],[
                'title'               => 'تجهيز رقم سبعة',
                'type_id'             => 4,
                'created_at'          => Carbon::now()->format('Y-m-d H:i:s'),
            ],[
                'title'               => 'تجهيز رقم ثمانية',
                'type_id'             => 4,
                'created_at'          => Carbon::now()->format('Y-m-d H:i:s'),
            ],[
                'title'               => 'تجهيز رقم تسعة',
                'type_id'             => 1,
                'created_at'          => Carbon::now()->format('Y-m-d H:i:s'),
            ],[
                'title'               => 'تجهيز رقم عشرة',
                'type_id'             => 2,
                'created_at'          => Carbon::now()->format('Y-m-d H:i:s'),
            ],[
                'title'               => 'تجهيز رقم احدى عشر',
                'type_id'             => 4,
                'created_at'          => Carbon::now()->format('Y-m-d H:i:s'),
            ],[
                'title'               => 'تجهيز رقم اثنا عشر',
                'type_id'             => 4,
                'created_at'          => Carbon::now()->format('Y-m-d H:i:s'),
            ],
        ];

        DB::table('equipments')->insert($insertions);
    }
}
