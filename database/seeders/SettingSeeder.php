<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingSeeder extends Seeder
{
        /**
         * Run the database seeds.
         *
         * @return void
         */
        public function run()
        {
                DB::table('settings')->delete();
                Setting::create([
                        'label'        => 'البريد الاكتروني المرسل منه أشعار بانشاء مشروع جديد',
                        'type'         => 'text',
                        'key'          => 'create_project_send_mail',
                        'value'        => '',
                ]);
        }
}
