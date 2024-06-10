<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
        /**
         * Run the database seeds.
         *
         * @return void
         */
        public function run()
        {
                DB::table('users')->delete();
                DB::table('model_has_roles')->delete();

                $user = User::create([
                        'username'         => 'admin',
                        'password'         => '12345678',
                        'email'            => 'admin@al-fares.sa',
                        'name'             => 'الإدارة العامة',
                        'avatar'           => 'uploads/users-avatar/blank.png',
                        'active_status'    => 1,
                        'national_id'      => 123456700,
                        'region_id'        => 1,
                        'mobile'           => 1212545400,
                ]);
                $user->assignRole(1); // role id = 1 المدير العام

                $user = User::create([
                        'username'         => 'project',
                        'password'         => '12345678',
                        'email'            => 'project@al-fares.sa',
                        'name'             => 'مهند النفيسة',
                        'avatar'           => 'uploads/users-avatar/blank.png',
                        'active_status'    => 1,
                        'national_id'      => 123456701,
                        'region_id'        => 1,
                        'mobile'           => 1212545401,
                ]);
                $user->assignRole(2); // role id = 2 ادارة المشاريع

                $user = User::create([
                        'username'         => 'operation',
                        'password'         => '12345678',
                        'email'            => 'operation@al-fares.sa',
                        'name'             => 'وائل الموسى',
                        'avatar'           => 'uploads/users-avatar/blank.png',
                        'active_status'    => 1,
                        'national_id'      => 123456702,
                        'region_id'        => 1,
                        'mobile'           => 1212545402,
                ]);
                $user->assignRole(3); // role id = 3 ادارة التشغيل

                $user = User::create([
                        'username'         => 'it',
                        'password'         => '12345678',
                        'email'            => 'it@al-fares.sa',
                        'name'             => 'قسم التقنية',
                        'avatar'           => 'uploads/users-avatar/blank.png',
                        'active_status'    => 1,
                        'national_id'      => 123456703,
                        'region_id'        => 1,
                        'mobile'           => 1212545403,
                ]);
                $user->assignRole(4); // role id = 4 ادارة التقنيه

                $user = User::create([
                        'username'         => 'fieldwork',
                        'password'         => '12345678',
                        'email'            => 'fieldwork@al-fares.sa',
                        'name'             => 'محمد السالم',
                        'avatar'           => 'uploads/users-avatar/blank.png',
                        'active_status'    => 1,
                        'national_id'      => 123456704,
                        'region_id'        => 1,
                        'mobile'           => 1212545404,
                ]);
                $user->assignRole(5); // role id = 5 ادارة العمل الميداني

                $user = User::create([
                        'username'         => 'observer',
                        'password'         => '12345678',
                        'email'            => 'observer@al-fares.sa',
                        'name'             => 'أشرف كريم',
                        'avatar'           => 'uploads/users-avatar/blank.png',
                        'active_status'    => 1,
                        'national_id'      => 123456705,
                        'region_id'        => 1,
                        'mobile'           => 1212545405,
                ]);
                $user->assignRole(6); // role id = إدارة المراقب 7

                $user = User::create([
                        'username'         => 'auditor',
                        'password'         => '12345678',
                        'email'            => 'auditor@al-fares.sa',
                        'name'             => 'ناجي سيف',
                        'avatar'           => 'uploads/users-avatar/blank.png',
                        'active_status'    => 1,
                        'national_id'      => 123456706,
                        'region_id'        => 1,
                        'mobile'           => 1212545406,
                ]);
                $user->assignRole(7); // role id = مراقب التدقيق 8

                $user = User::create([
                        'username'         => 'training',
                        'password'         => '12345678',
                        'email'            => 'training@al-fares.sa',
                        'name'             => 'مشعل البصيري',
                        'avatar'           => 'uploads/users-avatar/blank.png',
                        'active_status'    => 1,
                        'national_id'      => 123456707,
                        'region_id'        => 1,
                        'mobile'           => 1212545407,
                ]);
                $user->assignRole(8); // role id = إدارة التدريب 9

                $user = User::create([
                        'username'         => 'equipment',
                        'password'         => '12345678',
                        'email'            => 'equipment@al-fares.sa',
                        'name'             => 'عبدالعزيز الهاشم',
                        'avatar'           => 'uploads/users-avatar/blank.png',
                        'active_status'    => 1,
                        'national_id'      => 123456708,
                        'region_id'        => 1,
                        'mobile'           => 1212545408,
                ]);
                $user->assignRole(9); // role id = إدارة التجهيزات 6

                $user = User::create([
                        'username'         => 'observer2',
                        'password'         => '12345678',
                        'email'            => 'observer2@al-fares.sa',
                        'name'             => '2أشرف كريم',
                        'avatar'           => 'uploads/users-avatar/blank.png',
                        'active_status'    => 1,
                        'national_id'      => 123456709,
                        'region_id'        => 1,
                        'mobile'           => 1212545409,
                ]);
                $user->assignRole(6); // role id = إدارة المراقب 7

                $user = User::create([
                        'username'         => 'observer3',
                        'password'         => '12345678',
                        'email'            => 'observer3@al-fares.sa',
                        'name'             => '3أشرف كريم',
                        'avatar'           => 'uploads/users-avatar/blank.png',
                        'active_status'    => 1,
                        'national_id'      => 123456710,
                        'region_id'        => 1,
                        'mobile'           => 1212545410,
                ]);
                $user->assignRole(6); // role id = إدارة المراقب 7

                $user = User::create([
                        'username'         => 'observer4',
                        'password'         => '12345678',
                        'email'            => 'observer4@al-fares.sa',
                        'name'             => '4أشرف كريم',
                        'avatar'           => 'uploads/users-avatar/blank.png',
                        'active_status'    => 1,
                        'national_id'      => 123456711,
                        'region_id'        => 1,
                        'mobile'           => 1212545411,
                ]);
                $user->assignRole(6); // role id = إدارة المراقب 7

                $user = User::create([
                        'username'         => 'observer5',
                        'password'         => '12345678',
                        'email'            => 'observer5@al-fares.sa',
                        'name'             => '5أشرف كريم',
                        'avatar'           => 'uploads/users-avatar/blank.png',
                        'active_status'    => 1,
                        'national_id'      => 123456712,
                        'region_id'        => 1,
                        'mobile'           => 1212545412,
                ]);
                $user->assignRole(6); // role id = إدارة المراقب 7

                $user = User::create([
                        'username'         => 'observer6',
                        'password'         => '12345678',
                        'email'            => 'observer6@al-fares.sa',
                        'name'             => '6أشرف كريم',
                        'avatar'           => 'uploads/users-avatar/blank.png',
                        'active_status'    => 1,
                        'national_id'      => 123456713,
                        'region_id'        => 1,
                        'mobile'           => 1212545413,
                ]);
                $user->assignRole(6); // role id = إدارة المراقب 7

                $user = User::create([
                        'username'         => 'observer7',
                        'password'         => '12345678',
                        'email'            => 'observer7@al-fares.sa',
                        'name'             => '7أشرف كريم',
                        'avatar'           => 'uploads/users-avatar/blank.png',
                        'active_status'    => 1,
                        'national_id'      => 123456714,
                        'region_id'        => 1,
                        'mobile'           => 1212545414,
                ]);
                $user->assignRole(6); // role id = إدارة المراقب 7

                $user = User::create([
                        'username'         => 'auditor2',
                        'password'         => '12345678',
                        'email'            => 'auditor2@al-fares.sa',
                        'name'             => '2ناجي سيف',
                        'avatar'           => 'uploads/users-avatar/blank.png',
                        'active_status'    => 1,
                        'national_id'      => 123456715,
                        'region_id'        => 1,
                        'mobile'           => 1212545415,
                ]);
                $user->assignRole(7); // role id = مراقب التدقيق 8

                $user = User::create([
                        'username'         => 'auditor3',
                        'password'         => '12345678',
                        'email'            => 'auditor3@al-fares.sa',
                        'name'             => '3ناجي سيف',
                        'avatar'           => 'uploads/users-avatar/blank.png',
                        'active_status'    => 1,
                        'national_id'      => 123456716,
                        'region_id'        => 1,
                        'mobile'           => 1212545416,
                ]);
                $user->assignRole(7); // role id = مراقب التدقيق 8

                $user = User::create([
                        'username'         => 'auditor4',
                        'password'         => '12345678',
                        'email'            => 'auditor4@al-fares.sa',
                        'name'             => '4ناجي سيف',
                        'avatar'           => 'uploads/users-avatar/blank.png',
                        'active_status'    => 1,
                        'national_id'      => 123456717,
                        'region_id'        => 1,
                        'mobile'           => 1212545417,
                ]);
                $user->assignRole(7); // role id = مراقب التدقيق 8

                $user = User::create([
                        'username'         => 'auditor5',
                        'password'         => '12345678',
                        'email'            => 'auditor5@al-fares.sa',
                        'name'             => '5ناجي سيف',
                        'avatar'           => 'uploads/users-avatar/blank.png',
                        'active_status'    => 1,
                        'national_id'      => 123456718,
                        'region_id'        => 1,
                        'mobile'           => 1212545418,
                ]);
                $user->assignRole(7); // role id = مراقب التدقيق 8

                $user = User::create([
                        'username'         => 'auditor6',
                        'password'         => '12345678',
                        'email'            => 'auditor6@al-fares.sa',
                        'name'             => '6ناجي سيف',
                        'avatar'           => 'uploads/users-avatar/blank.png',
                        'active_status'    => 1,
                        'national_id'      => 123456719,
                        'region_id'        => 1,
                        'mobile'           => 1212545419,
                ]);
                $user->assignRole(7); // role id = مراقب التدقيق 8

                $user = User::create([
                        'username'         => 'auditor7',
                        'password'         => '12345678',
                        'email'            => 'auditor7@al-fares.sa',
                        'name'             => '7ناجي سيف',
                        'avatar'           => 'uploads/users-avatar/blank.png',
                        'active_status'    => 1,
                        'national_id'      => 123456720,
                        'region_id'        => 1,
                        'mobile'           => 1212545420,
                ]);
                $user->assignRole(7); // role id = مراقب التدقيق 8

                $user = User::create([
                        'username'         => 'auditor8',
                        'password'         => '12345678',
                        'email'            => 'auditor8@al-fares.sa',
                        'name'             => '8ناجي سيف',
                        'avatar'           => 'uploads/users-avatar/blank.png',
                        'active_status'    => 1,
                        'national_id'      => 123456721,
                        'region_id'        => 1,
                        'mobile'           => 1212545421,
                ]);
                $user->assignRole(7);

                $user = User::create([
                        'username'         => 'survey creator',
                        'password'         => '12345678',
                        'email'            => 'creator@al-fares.sa',
                        'name'             => 'منشئ الإستمارات',
                        'avatar'           => 'uploads/users-avatar/blank.png',
                        'active_status'    => 1,
                        'national_id'      => 1234536721,
                        'region_id'        => 1,
                        'mobile'           => 12125745421,
                ]);
                $user->assignRole(10);

                $user = User::create([
                        'username'         => 'Inspection Visit',
                        'password'         => '12345678',
                        'email'            => 'inspector@al-fares.sa',
                        'name'             => 'فاحص',
                        'avatar'           => 'uploads/users-avatar/blank.png',
                        'active_status'    => 1,
                        'national_id'      => 1224536723,
                        'region_id'        => 1,
                        'mobile'           => 1212574561,
                ]);
                $user->assignRole(11);


                $user = User::create([
                        'username'         => 'Inspection Visit 2',
                        'password'         => '12345674',
                        'email'            => 'inspector2@al-fares.sa',
                        'name'             => 'فاحص 2',
                        'avatar'           => 'uploads/users-avatar/blank.png',
                        'active_status'    => 1,
                        'national_id'      => 1224536721,
                        'region_id'        => 1,
                        'mobile'           => 1212574563,
                ]);
                $user->assignRole(11);


                $user = User::create([
                        'username'         => 'Trainer Assistant',
                        'password'         => '12345678',
                        'email'            => 'trainerassisst@al-fares.sa',
                        'name'             => 'مساعد مدرب',
                        'avatar'           => 'uploads/users-avatar/blank.png',
                        'active_status'    => 1,
                        'national_id'      => 1294536721,
                        'region_id'        => 1,
                        'mobile'           => 1219574561,
                ]);
                $user->assignRole(12);

                $user = User::create([
                        'username'         => 'Design Dept.',
                        'password'         => '12345678',
                        'email'            => 'design@al-fares.sa',
                        'name'             => 'التصميم',
                        'avatar'           => 'uploads/users-avatar/blank.png',
                        'active_status'    => 1,
                        'national_id'      => 1224536726,
                        'region_id'        => 1,
                        'mobile'           => 1212574581,
                ]);
                $user->assignRole(13);

                $user = User::create([
                        'username'         => 'Client Dept.',
                        'password'         => '12345678',
                        'email'            => 'client@al-fares.sa',
                        'name'             => 'العملاء',
                        'avatar'           => 'uploads/users-avatar/blank.png',
                        'active_status'    => 1,
                        'national_id'      => 1224536720,
                        'region_id'        => 1,
                        'mobile'           => 1212574580,
                ]);
                $user->assignRole(14);

                $user = User::create([
                        'username'         => 'Finance Dept.',
                        'password'         => '12345678',
                        'email'            => 'finance@al-fares.sa',
                        'name'             => 'الماليه',
                        'avatar'           => 'uploads/users-avatar/blank.png',
                        'active_status'    => 1,
                        'national_id'      => 1224536744,
                        'region_id'        => 1,
                        'mobile'           => 1212574585,
                ]);
                $user->assignRole(15);
        }
}
