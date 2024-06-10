<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RealestateTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $insertions = [
            ['title' =>  'سكني (غير مشغول)'],
            ['title' =>  'سكني (مشغول له بيانات في برنامج كاشف)'],
            ['title' =>  'تجاري سكني'],
            ['title' =>  'صناعي'],
            ['title' =>  'تجاري'],
            ['title' =>  'سكن عمال (مشغول)'],
            ['title' =>  'سكن عمال'],
            ['title' =>  'حديقة عامة'],
            ['title' =>  'حوش'],
            ['title' =>  'زراعة (مزرعة)'],
            ['title' =>  'شرطة'],
            ['title' =>  'دفاع مدني'],
            ['title' =>  'منتزه'],
            ['title' =>  'التسوق'],
            ['title' =>  'فندق'],
            ['title' =>  'مسجد'],
            ['title' =>  'مدرسة'],
            ['title' =>  'كلية أو جامعة'],
            ['title' =>  'محطة وقود'],
            ['title' =>  'ملعب أو نادي'],
            ['title' =>  'موقع أثري أو ثقافي'],
            ['title' =>  'الرعاية الصحية'],
            ['title' =>  'مقبرة'],
            ['title' =>  'غير مصنف أو فارغ'],
            ['title' =>  'تحت الإنشاء']
        ];

        DB::table('realestate_type')->insert($insertions);
    }
}
