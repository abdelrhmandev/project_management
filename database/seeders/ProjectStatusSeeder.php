<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProjectStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $insertions = [
            ['title' => 'DRAFT', 'trans' => 'مسودة', 'history' => 'تم إنشاء المشروع', 'class' => 'secondary'], 
            ['title' => 'BID_ESTIMATE', 'trans' => 'تجهيز العروض', 'history' => 'بانتظار رفع بيانات العرض الفني والمالي من قبل إدارة التشغيل', 'class' => 'info'],
            ['title' => 'APPROVE_PROJECT', 'trans' => 'ترسية المشروع', 'history' => 'تم رفع العرض الفني والمالي', 'class' => 'success'],
            ['title' => 'DUES_ENVIRONMENT', 'trans' => 'تهيئة المواعيد والبيئة', 'history' => 'تم قبول وترسية المشروع من قبل إدارة المشاريع', 'class' => 'dark'],
            ['title' => 'SUPERIOR_TEAM', 'trans' => 'تحديد الفريق الرئيسي', 'history' => 'تم تحديد فترة التهيئة وفترة التنفيذ', 'class' => 'danger'],
            ['title' => 'OBSERVER_TEAM', 'trans' => 'تكوين الفريق الميداني', 'history' => 'تم تعيين فريق العمل الرئيسي', 'class' => 'primary'],
            ['title' => 'TRAIN_TEAM', 'trans' => 'تدريب الفرق', 'history' => 'كلا المراقبين ومراقبي التدقيق قاموا بتكوين فرقهم', 'class' => 'warning'],
            ['title' => 'APPROVE_TEAM', 'trans' => 'إعتماد الفرق', 'history' => 'تم تأهيل وتدريب الفرق البحثية', 'class' => 'info'],
            ['title' => 'CREATE_ACCOUNTS', 'trans' => 'إنشاء الحسابات', 'history' => 'تم إعتماد أفراد الفريق للعمل في المشروع', 'class' => 'success'],
            ['title' => 'FILED_READY', 'trans' => 'الجاهزية للبدء', 'history' => 'تم إنشاء الحسابات في برنامج كاشف', 'class' => 'danger'],
            ['title' => 'START_FILED', 'trans' => 'العمل بدء', 'history' => 'تم البدء في العمل الميداني', 'class' => 'dark'],
            ['title' => 'END_FILED', 'trans' => 'العمل الميداني إنتهى', 'history' => 'تم الإنتهاء من العمل الميداني', 'class' => 'primary'],
            ['title' => 'TRAINING_FNISHED', 'trans' => 'تم تنفيذ التدريب', 'history' => 'بإنتظار تنفيذ التدريب', 'class' => 'success'],
            ['title' => 'CONVENANT_DUES', 'trans' => 'تم تسليم العهد', 'history' => 'بانتظار تسليم العهد', 'class' => 'info'],
            ['title' => 'SURVEY_CREATED', 'trans' => 'إنشئ الإستمارة', 'history' => 'تم إنشاء الإستمارة بنجاح', 'class' => 'danger'],
            ['title' => 'APPROVE_PENDING', 'trans' => 'إنتظار الترسية', 'history' => 'تم إرسال ملفات المشروع للجهة', 'class' => 'danger'],
            ['title' => 'REJECT_PROJECT', 'trans' => 'المشروع ألغي', 'history' => 'تم رفض المشروع وألغي من قبل إدارة المشاريع', 'class' => 'dark'],
            ['title' => 'EQUIPMENTS_RETURNED', 'trans' => 'المشروع إنتهى', 'history' => 'تم إرجاع العهد مرة أخرى إلى إدارة التجهيزات', 'class' => 'dark'],
            ['title' => 'TRAINER_TRAIN', 'trans' => 'الجاهزية للمدرب للتدريب', 'history' => '-', 'class' => 'dark'],
            ['title' => 'FINANCE_FILE', 'trans' => 'رفع العرض المالي', 'history' => 'تم رفع ملف العرض المالي', 'class' => 'dark'],
        ];

        DB::table('project_status')->insert($insertions);
    }
}