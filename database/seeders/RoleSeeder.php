<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->delete();

        $insertions                 = [
            [
                'name'                => 'admin',
                'ar_name'             => 'الإدارة',
                'guard_name'          => 'web',
                'created_at'          => Carbon::now()->format('Y-m-d H:i:s'),
            ],[
                'name'                => 'project',
                'ar_name'             => 'إدارة المشاريع',
                'guard_name'          => 'web',
                'created_at'          => Carbon::now()->format('Y-m-d H:i:s'),
            ],[
                'name'                => 'operation',
                'ar_name'             => 'إدارة التشغيل',
                'guard_name'          => 'web',
                'created_at'          => Carbon::now()->format('Y-m-d H:i:s'),
            ],[
                'name'                => 'it',
                'ar_name'             => 'إدارة التقنية',
                'guard_name'          => 'web',
                'created_at'          => Carbon::now()->format('Y-m-d H:i:s'),
            ],[
                'name'                => 'fieldwork',
                'ar_name'             => 'إدارة العمل الميداني',
                'guard_name'          => 'web',
                'created_at'          => Carbon::now()->format('Y-m-d H:i:s'),
            ],[
                'name'                => 'observer',
                'ar_name'             => 'المراقب',
                'guard_name'          => 'web',
                'created_at'          => Carbon::now()->format('Y-m-d H:i:s'),
            ],[
                'name'                => 'auditor',
                'ar_name'             => 'مراقب التدقيق',
                'guard_name'          => 'web',
                'created_at'          => Carbon::now()->format('Y-m-d H:i:s'),
            ],[
                'name'                => 'trainer',
                'ar_name'             => 'إدارة التدريب',
                'guard_name'          => 'web',
                'created_at'          => Carbon::now()->format('Y-m-d H:i:s'),
            ],[
                'name'                => 'equipment',
                'ar_name'             => 'إدارة التجهيزات',
                'guard_name'          => 'web',
                'created_at'          => Carbon::now()->format('Y-m-d H:i:s'),
            ],[
                'name'                => 'creator',
                'ar_name'             => 'منشئ الإستمارات',
                'guard_name'          => 'web',
                'created_at'          => Carbon::now()->format('Y-m-d H:i:s'),
            ],[
                'name'                => 'inspector',
                'ar_name'             => 'فاحص',
                'guard_name'          => 'web',
                'created_at'          => Carbon::now()->format('Y-m-d H:i:s'),
            ],[
                'name'                => 'trainer-assisstant',
                'ar_name'             => 'مساعد مدرب',
                'guard_name'          => 'web',
                'created_at'          => Carbon::now()->format('Y-m-d H:i:s'),
            ],[
                'name'                => 'design',
                'ar_name'             => 'التصميم',
                'guard_name'          => 'web',
                'created_at'          => Carbon::now()->format('Y-m-d H:i:s'),
            ],[
                'name'                => 'client',
                'ar_name'             => 'العملاء',
                'guard_name'          => 'web',
                'created_at'          => Carbon::now()->format('Y-m-d H:i:s'),
            ],[
                'name'                => 'finance',
                'ar_name'             => 'الماليه',
                'guard_name'          => 'web',
                'created_at'          => Carbon::now()->format('Y-m-d H:i:s'),
            ],

        ];

        DB::table('roles')->insert($insertions);
    }
}
