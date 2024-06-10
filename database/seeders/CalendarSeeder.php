<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CalendarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $insertions                 = [
            [
                'title'               => 'مشروع إسناد',
                'description'         => 'شركة الفارس للبحوث والدراسات',
                'className'           => 'fc-event-danger fc-event-solid-warning',
                'start'               => '2023-02-01',
                'end'                 => '2023-02-04',
                'created_at'          => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'          => Carbon::now()->format('Y-m-d H:i:s'),
            ],[
                'title'               => 'مشروع الخنيقية',
                'description'         => 'alfares company for research & studies',
                'className'           => 'fc-event-danger fc-event-solid-warning',
                'start'               => '2023-02-10',
                'end'                 => '2023-02-20',
                'created_at'          => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'          => Carbon::now()->format('Y-m-d H:i:s'),
            ],
        ];

        DB::table('calendars')->insert($insertions);
    }
}
