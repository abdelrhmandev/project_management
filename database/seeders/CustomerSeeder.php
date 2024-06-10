<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('customers')->delete();

        $insertions                 = [
            [
                'title'               => 'الشبكة السعودية للمدفوعات',
                'principal_name'      => 'أحمد محمد سبيع',
                'principal_position'  => 'المدير العام',
                'principal_mobile'    => '0123456781',
                'principal_email'     => 'a@domain.com',
                'created_at'          => Carbon::now()->format('Y-m-d H:i:s'),
            ],[
                'title'               => 'الشبكة السعودية للمدفوعات',
                'principal_name'      => 'سمير سعيد مبارك',
                'principal_position'  => 'المدير الأقليمي',
                'principal_mobile'    => '0123456782',
                'principal_email'    => 'b@domain.com',
                'created_at'          => Carbon::now()->format('Y-m-d H:i:s'),
            ],[
                'title'               => 'شركه القبس السعوديه للمقاولات والاستثمار العقارى',
                'principal_name'      => 'سامي الجابر',
                'principal_position'  => 'مدير فرع جده',
                'principal_mobile'    => '0123456783',
                'principal_email'    => 'c@domain.com',
                'created_at'          => Carbon::now()->format('Y-m-d H:i:s'),
            ], [
                'title'               => 'الشركة الوطنيه السعوديه للسياحة',
                'principal_name'      => 'عبدالله باقي جلال',
                'principal_position'  => 'مهندس أتصالات ',
                'principal_mobile'    => '0123456784',
                'principal_email'    => 'd@domai.com',
                'created_at'          => Carbon::now()->format('Y-m-d H:i:s'),
            ],

        ];
        DB::table('customers')->insert($insertions);
    }
}
