<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TransactionHistorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $insertions = [
            ['title' => 'تم إنشاء مشروع جديد', 'previous' => 'start', 'class'=>'secondary','icons' => 'vuesax-linear-note-favorite'], 
            ['title' => 'تم رفع المشروع', 'previous' => 'بانتظار رفع المشروع للبدء في العمل', 'class'=>'success' ,'icons' => 'vuesax-linear-export'],
            ['title' => 'تم رفع العرض الفني', 'previous' => 'بانتظار رفع بيانات العرض الفني من قبل إدارة التشغيل', 'class'=>'dark' ,'icons' => 'vuesax-linear-flag'],
            ['title' => 'تم قبول وترسية المشروع من قبل إدارة المشاريع', 'previous' => 'بانتظار قبول وترسية المشروع من قبل إدارة المشاريع', 'class'=>'danger' ,'icons' => 'vuesax-linear-tick-square'],
            ['title' => 'تم تحديد فترة التهيئة وفترة التنفيذ', 'previous' => 'بانتظار تحديد فترة التهيئة وفترة التنفيذ', 'class'=>'primary' ,'icons' => 'vuesax-linear-calendar-1'],
            ['title' => 'تم تهيئة برنامج كاشف وتم توفير الحسابات الرئيسية لها', 'previous' => 'بانتظار تهيئة برنامج كاشف وتوفير الحسابات الرئيسية له', 'class'=>'warning' ,'icons' => 'vuesax-linear-edit'],
            ['title' => 'تم تعيين المراقبين ومراقبي التدقيق', 'previous' => 'بانتظار تعيين المراقبين ومراقبي التدقيق', 'class'=>'secondary' ,'icons' => 'vuesax-linear-verify'],
            ['title' => 'تم توفير التجهيزات الخاصة بالمشروع', 'previous' => 'بانتظار توفير التجهيزات الخاصة بالمشروع', 'class'=>'info' ,'icons' => 'vuesax-linear-task-square'],
            ['title' => 'المراقب قام بتكوين فريق البحث', 'previous' => 'بانتظار المراقب لتعيين فريق البحث', 'class'=>'success' ,'icons' => 'vuesax-linear-profile-tick'],
            ['title' => 'مراقب التدقيق قام يتكون فريق التدقيق', 'previous' => 'بانتظار مراقب التدقيق لتعيين المدققين', 'class'=>'dark' ,'icons' => 'vuesax-linear-verify'],
            ['title' => 'تم إنشاء وإرسال رابط التدريب للباحثين', 'previous' => 'بانتظار إرسال رابط التدريب للباحثين','class'=>'danger' ,'icons' => 'vuesax-linear-send'],
            ['title' => 'تم إنشاء وإرسال رابط التدريب للمدققين', 'previous' => 'بانتظار إرسال رابط التدريب للمدققين','class'=>'primary' ,'icons' => 'vuesax-linear-send'],
            ['title' => 'تم تحديد قائمة الباحثين المتلقين للتدريب', 'previous' => 'بانتظار تحديد قائمة الباحثين المتلقين للتدريب','class'=>'warning' ,'icons' => 'vuesax-linear-note-2'],
            ['title' => 'تم تحديد قائمة المدققين المتلقين للتدريب', 'previous' => 'بانتظار تحديد قائمة المدققين المتلقين للتدريب','class'=>'warning' ,'icons' => 'vuesax-linear-note-2'],
            ['title' => 'تم إعتماد الباحثين من قبل المراقب', 'previous' => 'بانتظار إعتماد الباحثين من قبل المراقب','class'=>'info' ,'icons' => 'vuesax-linear-profile-tick'],
            ['title' => 'تم إعتماد المدقيين من قبل مراقب التدقيق', 'previous' => 'بانتظار إعتماد المدقيين من قبل مراقب التدقيق','class'=>'success' ,'icons' => 'vuesax-linear-verify'],
            ['title' => 'تم إنشاء حسابات الفرق البحثية في برنامج كاشف', 'previous' => 'بانتظار إنشاء حسابات الفرق البحثية في برنامج كاشف','class'=>'dark' ,'icons' => 'vuesax-linear-edit'],
            ['title' => 'تم البدء في العمل الميداني', 'previous' => 'بانتظار البدء في العمل الميداني','class'=>'danger' ,'icons' => 'vuesax-linear-tree'],
            ['title' => 'تم الإنتهاء من العمل الميداني', 'previous' => 'بانتظار إنهاء العمل الميداني','class'=>'secondary' ,'icons' => 'vuesax-linear-close-square'],
            ['title' => 'تم تسليم العهد إلى إدارة التجهيزات', 'previous' => 'بانتظار تسليم العهد المسلمة لإدارة التجهيزات','class'=>'success' ,'icons' => 'vuesax-linear-task'],
            ['title' => 'المراقب قام بتكوين فريق التدريب', 'previous' => 'بانتظار المراقب لتعيين فريق التدريب', 'class'=>'success' ,'icons' => 'vuesax-linear-profile-tick'],
            ['title' => 'المراقب قام بإنهاء التدريب', 'previous' => 'بانتظار المراقب لإنهاء التدريب', 'class'=>'secondary' ,'icons' => 'vuesax-linear-verify'],
            ['title' => 'تم  إنشاء الإستمارة وتوفير معلومات الدخول إلى النظام', 'previous' => 'بانتظار إنشاء إستمارة البحث الخاصة مع معلومات الدخول إلى النظام', 'class'=>'warning' ,'icons' => 'document-text'],
            ['title' => 'تم تعيين الفاحص', 'previous' => 'بانتظار تعيين الفاحص', 'class'=>'warning' ,'icons' => 'vuesax-linear-profile-tick'],
            ['title' => 'تم تنفيذ الزيارة التفتيشية', 'previous' => 'بانتظار الفاحص لإنهاء الزيارة', 'class'=>'warning' ,'icons' => 'vuesax-linear-tick-square'],
            ['title' => 'تم تعيين مدرب ورفع تقرير التدريب', 'previous' => 'بانتظار تعيين المدرب ورفع تقرير التدريب', 'class'=>'warning' ,'icons' => 'vuesax-linear-task-square'],
            ['title' => 'تم رفع العرض المالي', 'previous' => 'بانتظار رفع ملف العرض المالي', 'class'=>'dark' ,'icons' => 'vuesax-linear-flag'],
        ];

        DB::table('transaction_history')->insert($insertions);
    }
}
