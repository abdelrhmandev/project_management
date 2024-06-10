<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TeamRankTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('team_rank_types')->delete();

        $insertions                 = [
            [
                'title'               => 'observer',
                'trans'               => 'مراقب',
                'created_at'          => Carbon::now()->format('Y-m-d H:i:s'),
            ],[
                'title'               => 'observer_audit',
                'trans'               => 'مراقب التدقيق',
                'created_at'          => Carbon::now()->format('Y-m-d H:i:s'),
            ],[
                'title'               => 'auditor',
                'trans'               => 'مدقق',
                'created_at'          => Carbon::now()->format('Y-m-d H:i:s'),
            ],[
                'title'               => 'supervisor',
                'trans'               => 'مشرف',
                'created_at'          => Carbon::now()->format('Y-m-d H:i:s'),
            ],[
                'title'               => 'researcher',
                'trans'               => 'باحث',
                'created_at'          => Carbon::now()->format('Y-m-d H:i:s'),
            ],[
                'title'               => 'inspector',
                'trans'               => 'فاحص',
                'created_at'          => Carbon::now()->format('Y-m-d H:i:s'),
            ],[
                'title'               => 'trainer',
                'trans'               => 'مدرب',
                'created_at'          => Carbon::now()->format('Y-m-d H:i:s'),
            ]
        ];

        DB::table('team_rank_types')->insert($insertions);
    }
}
