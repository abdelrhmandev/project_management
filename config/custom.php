<?php
return [

    /*
    |--------------------------------------------------------------------------
    | Look & feel customizations
    |--------------------------------------------------------------------------
    |
    | Make it yours.
    |
    */
    // Project name. Shown in the breadcrumbs and a few other places.
    'project_name' => 'ALFARES RESEARCH',
    'ProjectCreationNotification' => 'مشروع جديد',
    'ProjectEditNotification' => 'تحدث مشروع',
    'FieldWorkNotificationStart'=>'بدء',
    'FieldWorkNotificationEnd'=>'إنتهى',

    /*
    |--------------------------------------------------------------------------
    | Routing
    |--------------------------------------------------------------------------
    */
    'default_avatar' => 'https://www.gravatar.com/avatar/205e460b479e2e5b48aec07710c08d50g',
    // The prefix used in all base routes (the 'admin' in admin/dashboard)
    // You can make sure all your URLs use this prefix by using the backpack_url() helper instead of url()

    'prefix' => 'admin/',
    // The guard that protects the Application admin panel.
    // If null, the config.auth.defaults.guard value will be used.
];
