<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return redirect('/login');
});

/*Contract Process */
Route::group(['prefix' => 'contract'], function () {
    Route::get('/{projectId}/{teamuserId}', [App\Http\Controllers\Backoffice\ObserverController::class, 'teamMemberContract'])->name('team-member-contract');
    Route::put('/{projectId}/{teamuserId}/{typeTd}', [App\Http\Controllers\Backoffice\ObserverController::class, 'generateTeamMemberContract'])->name('team-member-generate-contract');
});

Auth::routes();
Route::get('/auth/password/reset', [App\Http\Controllers\Auth\ForgotPasswordController::class, '_index'])->name('user.password.reset');
Route::post('/auth/password/send', [App\Http\Controllers\Auth\ForgotPasswordController::class, '_resetPassword'])->name('password.send');
Route::get('/auth/password/{ID}/{email}/{token}', [App\Http\Controllers\Auth\ForgotPasswordController::class, '_setNewPassword'])->where(['token' => '[0-9a-zA-Z]{40}'])->name('password.new');
Route::patch('/auth/password/change', [App\Http\Controllers\Auth\ForgotPasswordController::class, '_changePassword'])->name('password.change');

Route::group(['namespace' => 'App\Http\Controllers', 'middleware' => ['auth']], function () {
    # GROUP ROLE ADMIN WITH PREFIX
    Route::group(['prefix' => 'admin', 'middleware' => ['role:admin']], function () {
        Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);
        Route::get('/projects', [App\Http\Controllers\Backoffice\ProjectController::class, 'index']);
        Route::get('/sender-credential', [App\Http\Controllers\CredentialController::class, 'index']);
        Route::put('/save-sender-credential', [App\Http\Controllers\CredentialController::class, 'update']);
        Route::get('/ImportcsvFileattractingTeamForm', [App\Http\Controllers\Backoffice\AdminController::class, 'ImportcsvFileattractingTeamForm'])->name('');
        Route::post('/saveCsvFileattractingTeamForm', [App\Http\Controllers\Backoffice\AdminController::class, 'saveCsvFileattractingTeamForm']);
    });

    /** Admin ROLE ACCOUNT */
    Route::group(['prefix' => 'admin'], function () {
        Route::get('/RedFlags', 'App\Http\Controllers\Backoffice\AdminController@Redflags')->name('admin.Redflags.index');
        Route::get('/RedFlags/AddReply/{id}', 'App\Http\Controllers\Backoffice\AdminController@AddRedflagsReply')->name('admin.AddRedflagsReply');
        Route::post('/reply/redflag', 'App\Http\Controllers\Backoffice\AdminController@replyRedflag')->name('admin.reply.Redflag');

        Route::group(['prefix' => 'equipments'], function () {
            Route::get('/', 'App\Http\Controllers\Backoffice\AdminController@equipments')->name('admin.equipments.index');
            Route::get('/create', 'App\Http\Controllers\Backoffice\AdminController@create_equipment')->name('admin.equipments.create');
            Route::get('/edit/{id}', 'App\Http\Controllers\Backoffice\AdminController@edit_equipment')->name('admin.equipments.edit');
            Route::post('/store', 'App\Http\Controllers\Backoffice\AdminController@store_equipment')->name('admin.equipments.store');
            Route::put('/update/{id}', 'App\Http\Controllers\Backoffice\AdminController@update_equipment')->name('admin.equipments.update');
            Route::delete('destroy/{id}', 'App\Http\Controllers\Backoffice\AdminController@destroy_equipment')->name('admin.equipments.destroy');
            Route::delete('destroy/all', 'App\Http\Controllers\Backoffice\AdminController@destroyMultipleEquipment')->name('admin.equipments.destroyMultipleEquipment');
            Route::post('/mark-as-read', 'App\Http\Controllers\Backoffice\AdminController@markNotification')->name('admin.markNotification');
        });

        Route::group(['prefix' => 'users'], function () {
            Route::get('/', 'App\Http\Controllers\Backoffice\AdminController@users')->name('admin.users.index');
            Route::get('/create', 'App\Http\Controllers\Backoffice\AdminController@create_user')->name('admin.users.create');
            Route::get('/edit/{id}', 'App\Http\Controllers\Backoffice\AdminController@edit_user')->name('admin.users.edit');
            Route::post('/store', 'App\Http\Controllers\Backoffice\AdminController@store_user')->name('admin.users.store');
            Route::put('/update/{id}', 'App\Http\Controllers\Backoffice\AdminController@update_user')->name('admin.users.update');
            Route::delete('destroy/{id}', 'App\Http\Controllers\Backoffice\AdminController@destroy_user')->name('admin.users.destroy');
            Route::delete('destroy/all', 'App\Http\Controllers\Backoffice\AdminController@destroyMultipleUser')->name('admin.users.destroyMultipleUser');
        });

        Route::group(['prefix' => 'equipment-type'], function () {
            Route::get('/', 'App\Http\Controllers\Backoffice\AdminController@equipment_types')->name('admin.equipment_types.index');
            Route::get('/create', 'App\Http\Controllers\Backoffice\AdminController@create_equipment_type')->name('admin.equipment_type.create');
            Route::get('/edit/{id}', 'App\Http\Controllers\Backoffice\AdminController@edit_equipment_type')->name('admin.equipment_type.edit');
            Route::post('/store', 'App\Http\Controllers\Backoffice\AdminController@store_equipment_type')->name('admin.equipment_type.store');
            Route::put('/update/{id}', 'App\Http\Controllers\Backoffice\AdminController@update_equipment_type')->name('admin.equipment_type.update');
            Route::delete('destroy/{id}', 'App\Http\Controllers\Backoffice\AdminController@destroy_equipment_type')->name('admin.equipment_type.destroy');
            Route::delete('destroy/all', 'App\Http\Controllers\Backoffice\AdminController@destroyMultipleEquipmentType')->name('admin.equipments.destroyMultipleEquipmentType');
        });

        Route::group(['prefix' => 'customers'], function () {
            Route::get('/', 'App\Http\Controllers\Backoffice\AdminController@customers')->name('admin.customers.index');
            Route::get('/create', 'App\Http\Controllers\Backoffice\AdminController@create_customer')->name('admin.customers.create');
            Route::get('/edit/{id}', 'App\Http\Controllers\Backoffice\AdminController@edit_customer')->name('admin.customers.edit');
            Route::post('/store', 'App\Http\Controllers\Backoffice\AdminController@store_customer')->name('admin.customers.store');
            Route::put('/update/{id}', 'App\Http\Controllers\Backoffice\AdminController@update_customer')->name('admin.customers.update');
            Route::delete('destroy/{id}', 'App\Http\Controllers\Backoffice\AdminController@destroy_customer')->name('admin.customers.destroy');
            Route::delete('destroy/all', 'App\Http\Controllers\Backoffice\AdminController@destroyMultipleCustomer')->name('admin.customers.destroyMultipleCustomer');
        });
    });

    /** PROJECT ROLE ACCOUNT */
    Route::group(['prefix' => 'project'], function () {
        
        Route::get('/getCustomerInfo', [App\Http\Controllers\Backoffice\ProjectController::class, 'getCustomerInfo'])->name('getCustomerInfo');
        Route::get('/RejectedProjectsPlanning', [App\Http\Controllers\Backoffice\ProjectController::class, 'RejectedProjectsPlanning'])->name('RejectedProjectsPlanning');
        Route::get('/RejectedProjectsPlanning/{projectID}', [App\Http\Controllers\Backoffice\ProjectController::class, 'RejectedProjectsPlanningUploadExFile'])->name('RejectedProjectsPlanningUploadExFile');
        Route::put('/RejectedProjectsPlanningSubmit/{projectID}', [App\Http\Controllers\Backoffice\ProjectController::class, 'RejectedProjectsPlanningSubmitUploadExFile'])->name('RejectedProjectsPlanningSubmitUploadExFile');
        Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);
        Route::get('/projects', [App\Http\Controllers\Backoffice\ProjectController::class, 'index']);
        Route::get('/projects/editModal', 'App\Http\Controllers\Backoffice\ProjectController@editModal')->name('projects.editModal');
        Route::post('/projects/updateModal', 'App\Http\Controllers\Backoffice\ProjectController@updateModal')->name('projects.updateModal');
        Route::get('/ajax/{projectStatus?}', [App\Http\Controllers\Backoffice\ProjectController::class, 'index']);
        Route::get('/followup/{projectId}', [App\Http\Controllers\Backoffice\FollowupController::class, 'followup']);
        Route::get('/team-item-list/{projectId}/{typeId}', [App\Http\Controllers\Backoffice\ProjectController::class, 'getTeamItemList']);
        Route::post('/google-maps', [App\Http\Controllers\Backoffice\ProjectController::class, '_getGooMaps'])->name("P.GoMap");
    });

    Route::resource('projects', App\Http\Controllers\Backoffice\ProjectController::class)->except('show');
    Route::get('projects/{project}/edit/{status?}', [App\Http\Controllers\Backoffice\ProjectController::class, 'edit']);

    /** OPERATION ROLE ACCOUNT */
    Route::get('/operation', [App\Http\Controllers\HomeController::class, 'index']);
    Route::get('/operation/estimate-quote', [App\Http\Controllers\Backoffice\OperationController::class, 'index']);
    Route::post('/operation/request-exploration-tour', [App\Http\Controllers\Backoffice\OperationController::class, 'requestExplorationTour']);
    Route::get('/operation/projects', [App\Http\Controllers\Backoffice\OperationController::class, 'projects']);
    Route::get('/operation/team-item-list/{projectId}/{typeId}', [App\Http\Controllers\Backoffice\OperationController::class, 'getTeamItemList']);
    Route::get('/operation/followup/{projectId}', [App\Http\Controllers\Backoffice\FollowupController::class, 'followup']);
    Route::get('/operation/followup/field-team-details/{projectId}/{userId}', [App\Http\Controllers\Backoffice\FollowupController::class, 'fieldTeamDetails']);
    Route::post('/operation/end-field', [App\Http\Controllers\Backoffice\OperationController::class, 'endField']);
    Route::post('operation/create', [App\Http\Controllers\Backoffice\OperationController::class, 'create'])->middleware('role:project|operation');
    Route::post('operation/create/{projectId}', [App\Http\Controllers\Backoffice\OperationController::class, 'createById'])->middleware('role:project|operation');
    Route::post('operation/create-team-quote', [App\Http\Controllers\Backoffice\OperationController::class, 'createTeamQuote'])->middleware('role:project|operation');
    Route::post('operation/create-contract-research-items', [App\Http\Controllers\Backoffice\OperationController::class, 'createContractResearchItem'])->middleware('role:operation');
    Route::post('operation/financial-bid-estimates', [App\Http\Controllers\Backoffice\OperationController::class, 'financialBidEstimates'])->middleware('role:project|operation');
    Route::post('operation/dept-timing', [App\Http\Controllers\Backoffice\OperationController::class, 'deptTiming'])->middleware('role:project|operation');
    Route::post('operation/delete-team-item/{isRealEstate}/{itemId}', [App\Http\Controllers\Backoffice\OperationController::class, 'destroy'])->middleware('role:operation');
    Route::post('operation/delete-team-realestate/{isRealEstate}/{itemId}', [App\Http\Controllers\Backoffice\OperationController::class, 'destroy'])->middleware('role:operation');
    Route::resource('operations', App\Http\Controllers\Backoffice\OperationController::class)->except('index')->middleware('role:project|operation');
    Route::delete('/operation/remove-team-rank-item', [App\Http\Controllers\Backoffice\OperationController::class, 'removeTeamRankItem'])->middleware('role:project|operation');
    Route::post('operation/SaveCreatedKashef', [App\Http\Controllers\Backoffice\FollowupController::class, 'SaveCreatedKashef'])->middleware('role:operation|equipment');
    Route::get('operations/{operation}/edit/{status?}', [App\Http\Controllers\Backoffice\OperationController::class, 'edit']);

    /** IT ROLE ACCOUNT */
    Route::get('/it', [App\Http\Controllers\HomeController::class, 'index']);
    Route::get('/it/projects', [App\Http\Controllers\Backoffice\ItController::class, 'index']);
    Route::post('it/create-kashef-account', [App\Http\Controllers\Backoffice\ItController::class, 'createKashefAccount'])->middleware('role:it');
    Route::post('it/hand-offer-task', [App\Http\Controllers\Backoffice\ItController::class, 'handOverTask'])->middleware('role:it');
    Route::resource('its', App\Http\Controllers\Backoffice\ItController::class)->except('index')->middleware('role:it');
    Route::get('its/{it}/edit/{status?}', [App\Http\Controllers\Backoffice\ItController::class, 'edit']);

    /** FIELDWORK ROLE ACCOUNT */
    Route::get('/fieldwork', [App\Http\Controllers\HomeController::class, 'index']);
    Route::get('/fieldwork/projects/{taskType?}', [App\Http\Controllers\Backoffice\FieldworkController::class, 'index']);
    Route::post('/fieldwork/create-team-observer', [App\Http\Controllers\Backoffice\FieldworkController::class, 'createFieldworkTeam'])->middleware('role:fieldwork');
    Route::post('/fieldwork/create-team-audit-observer', [App\Http\Controllers\Backoffice\FieldworkController::class, 'createFieldworkTeam'])->middleware('role:fieldwork');
    Route::post('/fieldwork/hand-offer-task', [App\Http\Controllers\Backoffice\FieldworkController::class, 'handOverTask'])->middleware('role:fieldwork');
    Route::post('/fieldwork/delete-team-member/{projectId}/{teamMemeberId}/{is_tour?}', [App\Http\Controllers\Backoffice\FieldworkController::class, 'destroy'])->middleware('role:fieldwork');
    Route::post('/fieldwork/start-field', [App\Http\Controllers\Backoffice\FieldworkController::class, 'startField']);
    Route::post('/fieldwork/upload-explore-survey', [App\Http\Controllers\Backoffice\FieldworkController::class, 'uploadExploreSurvey']);
    Route::post('/fieldwork/remove-explore-survey', [App\Http\Controllers\Backoffice\FieldworkController::class, 'removeExploreSurvey']);
    Route::post('/fieldwork/is-training-needed/{project_id}/{is_needed}', [App\Http\Controllers\Backoffice\FieldworkController::class, 'updateIsEspecialTrainingNeeded']);
    Route::resource('fieldworks', App\Http\Controllers\Backoffice\FieldworkController::class)->except('index')->middleware('role:fieldwork');
    Route::get('fieldworks/{fieldwork}/edit/{status?}', [App\Http\Controllers\Backoffice\FieldworkController::class, 'edit']);
    Route::get('/fieldwork/contract-projects', [App\Http\Controllers\Backoffice\FieldworkController::class, 'contractProjects']);
    Route::get('/fieldwork/contract-projects/details/{project_id}', [App\Http\Controllers\Backoffice\FieldworkController::class, 'contractProjectsDetails']);

    /** OBSERVERS ROLE ACCOUNT */
    Route::group(['prefix' => 'observer'], function () {
        Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);
        Route::get('/handover/projects', [App\Http\Controllers\Backoffice\ObserverController::class, '_handoverProjects'])->name('observer.handoverProjects');
        Route::get('/handover/{projectID}', [App\Http\Controllers\Backoffice\ObserverController::class, '_handover'])->name('observer.handover');
        Route::put('/return/equipment', [App\Http\Controllers\Backoffice\ObserverController::class, '_eqReturn'])->name('eq.return');
        Route::put('/div/shipment', [App\Http\Controllers\Backoffice\ObserverController::class, '_eqDivShipFiles'])->name('obs.shipment');
        Route::patch('/finish-and-handover-task', [App\Http\Controllers\Backoffice\ObserverController::class, '_endHTask'])->name('obs.endTask');
        Route::patch('/del-shipment-files', [App\Http\Controllers\Backoffice\ObserverController::class, '_delShipFiles'])->name('obs.delShp');
        Route::patch('/set-good-or-not-good', [App\Http\Controllers\Backoffice\ObserverController::class, '_goodOrNot'])->name('obs.GON');
        Route::any('/handover/endtask', [App\Http\Controllers\Backoffice\ObserverController::class, '_handoverTask'])->name('observer.handoverTask');
        Route::get('/projects/{taskType?}', [App\Http\Controllers\Backoffice\ObserverController::class, 'index']);
        Route::get('/correct-project', [App\Http\Controllers\Backoffice\ObserverController::class, 'indexCorrection']);
        Route::get('/division/equipments/{projectID}', [App\Http\Controllers\Backoffice\ObserverController::class, '_projectDivEQ']);
        Route::get('/division/eq/details', [App\Http\Controllers\Backoffice\ObserverController::class, '_projectDivEQInfo'])->name('divEQ.info');
        Route::patch('/division/agreeOrReject', [App\Http\Controllers\Backoffice\ObserverController::class, '_divEqAgreeOrReject'])->name('divEQ.agreeornot');
        Route::get('/tour/{projectId}', [App\Http\Controllers\Backoffice\ObserverController::class, 'getTour']);
        Route::get('/correction/{projectId}', [App\Http\Controllers\Backoffice\ObserverController::class, 'getCorrection']);
        Route::get('/get-researchers/{projectId}', [App\Http\Controllers\Backoffice\ObserverController::class, 'getResearchers']);
        Route::get('/ajaxFilter/{projectId}', [App\Http\Controllers\Backoffice\ObserverController::class, 'ajaxFilter']);
        Route::get('/ajaxFilter/{supervisorId}/{projectId}/{isCorrection}', [App\Http\Controllers\Backoffice\ObserverController::class, 'ajaxFilter']);
        Route::get('/get-correction-researchers/{projectId}', [App\Http\Controllers\Backoffice\ObserverController::class, 'getCorrectionResearchers']);
        Route::get('/ajax/{supervisorId}/{projectId}/{isCorrection}', [App\Http\Controllers\Backoffice\ObserverController::class, 'ajax']);
        Route::post('/save-researcher-list', [App\Http\Controllers\Backoffice\ObserverController::class, 'saveResearcherList']);
        Route::get('/get-team-members/{projectId}/{taskType?}', [App\Http\Controllers\Backoffice\ObserverController::class, 'getTeamMembersForApproval']);
        Route::post('/approve-team-members', [App\Http\Controllers\Backoffice\ObserverController::class, 'approveTeamMembers']);
        Route::post('/create-team-supervisor', [App\Http\Controllers\Backoffice\ObserverController::class, 'createSupervisorTeam']);
        Route::post('/update-team-qty', [App\Http\Controllers\Backoffice\ObserverController::class, 'updateTeamQty']);
        Route::post('/create-team-trainer', [App\Http\Controllers\Backoffice\ObserverController::class, 'createTrainerTeam']);
        Route::post('/hand-offer-task', [App\Http\Controllers\Backoffice\ObserverController::class, 'handOverTask']);
        Route::post('/import-researchers', [App\Http\Controllers\Backoffice\ObserverController::class, 'importResearcheres'])->name('import.researcheres');
        Route::post('/hand-offer-tour', [App\Http\Controllers\Backoffice\ObserverController::class, 'handOverTour'])->name('edit_product');
        Route::post('/hand-offer-correction', [App\Http\Controllers\Backoffice\ObserverController::class, 'handOverCorrection']);
        Route::post('/upload-tour-files', [App\Http\Controllers\Backoffice\ObserverController::class, 'uploadTourFiles']);
        Route::post('/upload-training-file', [App\Http\Controllers\Backoffice\ObserverController::class, 'uploadTrainingFiles']);
        Route::post('/is-trainers-needed/{project_id}/{is_needed}', [App\Http\Controllers\Backoffice\ObserverController::class, 'updateIsTrainersNeeded']);
        Route::delete('/remove-tour-file', [App\Http\Controllers\Backoffice\ObserverController::class, 'removeTourFile']);
        Route::get('/followup/{projectId}', [App\Http\Controllers\Backoffice\FollowupController::class, 'followup']);

        // no need for below
        Route::get('/contract-projects/{taskType?}', [App\Http\Controllers\Backoffice\ObserverController::class, 'contractProjects']);
        Route::get('/contract-projects/details/{project_id}', [App\Http\Controllers\Backoffice\ObserverController::class, 'contractProjectsDetails']);
        //Route::put('/save-contract', 'ContractController@store')->name('save.contract');
    });
    Route::resource('observers', App\Http\Controllers\Backoffice\ObserverController::class)->except('index')->middleware('role:observer');
    Route::get('observers/{observer}/edit/{status?}', [App\Http\Controllers\Backoffice\ObserverController::class, 'edit']);
    Route::get('observer/get_rejection_reason', [App\Http\Controllers\Backoffice\ObserverController::class, 'get_rejection_reason'])->name('contract.get_rejection_reason');

    /** AUDIT OBSERVERS ROLE ACCOUNT */
    Route::group(['prefix' => 'auditor'], function () {
        Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);
        Route::get('/projects', [App\Http\Controllers\Backoffice\AuditorController::class, 'index']);
        Route::post('/create-team-auditors', [App\Http\Controllers\Backoffice\AuditorController::class, 'createAuditorTeam']);
        Route::get('/get-team-members/{projectId}', [App\Http\Controllers\Backoffice\AuditorController::class, 'getTeamMembersForApproval']);
        Route::post('/approve-team-members', [App\Http\Controllers\Backoffice\AuditorController::class, 'approveTeamMembers']);
        Route::post('/hand-offer-task', [App\Http\Controllers\Backoffice\AuditorController::class, 'handOverTask']);
        Route::get('/contract-projects', [App\Http\Controllers\Backoffice\AuditorController::class, 'contractProjects']);
        Route::get('/contract-projects/details/{project_id}', [App\Http\Controllers\Backoffice\AuditorController::class, 'contractProjectsDetails']);
        Route::get('/evaluations/projects', [App\Http\Controllers\Backoffice\AuditorController::class, '_evalProjects'])->name('evals');
        Route::get('/evaluations/projects/{ID}', [App\Http\Controllers\Backoffice\AuditorController::class, '_evalProjectInfo'])->name('evalsInfo');
        Route::post('/evaluations/researcher', [App\Http\Controllers\Backoffice\AuditorController::class, '_evalResearcher'])->name('evalsResearcher');
    });
    Route::resource('auditors', App\Http\Controllers\Backoffice\AuditorController::class)->except('index')->middleware('role:auditor');
    Route::get('auditors/{auditor}/edit/{status?}', [App\Http\Controllers\Backoffice\AuditorController::class, 'edit']);

    /** TRAINER ROLE ACCOUNT */
    Route::get('/trainer', [App\Http\Controllers\HomeController::class, 'index']);
    Route::PUT('/trainer/trainer-and-handover-task', [App\Http\Controllers\Backoffice\TrainerController::class, '_endTask'])->name('trainers.endtask');
    Route::get('/trainer/projects/{taskType?}', [App\Http\Controllers\Backoffice\TrainerController::class, 'index']);
    Route::PUT('/trainer/create-team-trainer', [App\Http\Controllers\Backoffice\TrainerController::class, 'createTrainerTeam'])->name('trainers.create-team-trainer');
    Route::post('/trainer/training-url/{taskType?}', [App\Http\Controllers\Backoffice\TrainerController::class, 'saveTrainingUrl']);
    Route::get('/trainer/correction/{projectId}', [App\Http\Controllers\Backoffice\TrainerController::class, 'getCorrection']);
    Route::post('/trainer/remove-training-files', [App\Http\Controllers\Backoffice\TrainerController::class, 'removeFilesByType'])->name('removeFilesByType');
    Route::post('/trainer/upload-training-files', [App\Http\Controllers\Backoffice\TrainerController::class, 'uploadFilesByType']);
    Route::post('/trainer/save-received-train', [App\Http\Controllers\Backoffice\TrainerController::class, 'saveReceivedTrain'])->middleware('role:trainer');
    Route::post('/trainer/hand-offer-task', [App\Http\Controllers\Backoffice\TrainerController::class, 'handOverTask'])->middleware('role:trainer');
    Route::post('/trainer/hand-offer-correction', [App\Http\Controllers\Backoffice\TrainerController::class, 'handOverCorrection'])->middleware('role:trainer');
    Route::post('/trainer/customTrainingDeletion/{taskType}/{urlId?}/{projectId?}/{teamMemeberId?}', [App\Http\Controllers\Backoffice\TrainerController::class, 'destroy'])->middleware('role:trainer');
    Route::resource('trainers', App\Http\Controllers\Backoffice\TrainerController::class)->except('index')->middleware('role:trainer');
    Route::get('trainers/{trainer}/edit/{status?}', [App\Http\Controllers\Backoffice\TrainerController::class, 'edit']);

    # GROUP ROLE EQUIPMENT WITH PREFIX
    Route::group(['prefix' => 'equipment'], function () {
        Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);
        Route::get('/projects', [App\Http\Controllers\Backoffice\EquipmentController::class, 'index']);
        Route::get('/elohades/{projectID}', [App\Http\Controllers\Backoffice\EquipmentController::class, '_eqElohade'])->name('eq.elohade');
        Route::match(['PATCH', 'POST'], '/save-ship-receipt/{type?}', [App\Http\Controllers\Backoffice\EquipmentController::class, 'saveShipReceipt']);
        Route::any('/hand-offer-task', [App\Http\Controllers\Backoffice\EquipmentController::class, 'handOverTask']);
        Route::get('/show-accounts/{project_id}', [App\Http\Controllers\Backoffice\EquipmentController::class, 'showAccounts']);
        Route::post('/accounts-created', [App\Http\Controllers\Backoffice\EquipmentController::class, 'accountsCreated']);
        Route::get('/followup/field-team-details/{projectId}/{userId}', [App\Http\Controllers\Backoffice\FollowupController::class, 'fieldTeamDetails']);
        Route::post('/upload-project-equipment-file', [App\Http\Controllers\Backoffice\EquipmentController::class, 'UploadProjectEquipmentFile'])->name('UploadProjectEquipmentFile');
        Route::delete('/remove-project-equipment-file', [App\Http\Controllers\Backoffice\EquipmentController::class, 'RemoveProjectEquipmentFile'])->name('RemoveProjectEquipmentFile');
        Route::get('/export/{projectId}/{userId?}', [App\Http\Controllers\Backoffice\EquipmentController::class, '_exportExcel'])->name('ExportEx');
        Route::get('/deactivate/projects', [App\Http\Controllers\Backoffice\EquipmentController::class, '_deactivateProjects'])->name('d.projects');
        Route::get('/show-deactivate-accounts/{project_id}', [App\Http\Controllers\Backoffice\EquipmentController::class, '_showDeactivateAccounts']);
        Route::post('/division', [App\Http\Controllers\Backoffice\EquipmentController::class, '_eqDiv'])->name('e.Div');
        Route::post('/division/files', [App\Http\Controllers\Backoffice\EquipmentController::class, '_eqDivFiles'])->name('e.DivFile');
        Route::get('/division/getfiles', [App\Http\Controllers\Backoffice\EquipmentController::class, '_eqDivGetFiles'])->name('e.DivGetFile');
    });
    Route::resource('equipments', App\Http\Controllers\Backoffice\EquipmentController::class)->except('show');
    Route::get('equipments/{equipment}/edit/{status?}', [App\Http\Controllers\Backoffice\EquipmentController::class, 'edit']);

    # GROUP ROLE DESIGN WITH PREFIX
    Route::group(['prefix' => 'design'], function () {
        Route::get('/', [App\Http\Controllers\Backoffice\DesignController::class, 'index']);
        Route::get('/processed', [App\Http\Controllers\Backoffice\DesignController::class, 'processed'])->name('processed');
        Route::get('/unprocessed', [App\Http\Controllers\Backoffice\DesignController::class, 'unprocessed'])->name('unprocessed');
        Route::get('/design/attractingTeam/details', [App\Http\Controllers\Backoffice\DesignController::class, 'attractingTeamEdit'])->name('design.attractingTeamEdit');
        Route::post('/design/attractingTeam/details', [App\Http\Controllers\Backoffice\DesignController::class, 'attractingTeamPost'])->name('design.attractingTeamPost');
    });

    # GROUP ROLE CLIENT WITH PREFIX
    Route::group(['prefix' => 'client'], function () {
        Route::get('/', [App\Http\Controllers\Backoffice\ClientController::class, 'index']);

        Route::get('/projects', [App\Http\Controllers\Backoffice\ClientController::class, 'projects']);
        Route::get('/projects/{projectID}', [App\Http\Controllers\Backoffice\ClientController::class, 'followup']);
        Route::get('/redirect-kashef', [App\Http\Controllers\Backoffice\ClientController::class, 'redirectToKashef']);
        Route::post('/project/files', [App\Http\Controllers\Backoffice\ClientController::class, '_addClientFiles']);
        Route::delete('/project/delete/file', [App\Http\Controllers\Backoffice\ClientController::class, '_deleteClientFiles']);
        Route::get('/excel/{projectID}', [App\Http\Controllers\Backoffice\ClientController::class, '_clientExcel'])->name('Client.Excel');
        Route::get('/team/filter', [App\Http\Controllers\Backoffice\ClientController::class, '_clientFilter'])->name('Client.Filter');
        Route::delete('/del/file', [App\Http\Controllers\Backoffice\ClientController::class, '_delFile'])->name('del.file');
        Route::post('/new/requirements', [App\Http\Controllers\Backoffice\ClientController::class, '_addNewRequirement'])->name('add.Req');
        Route::delete('/delete/requirements', [App\Http\Controllers\Backoffice\ClientController::class, '_delRequirement'])->name('del.Req');
        Route::post('/edit/requirements', [App\Http\Controllers\Backoffice\ClientController::class, '_editRequirement'])->name('edit.Req');
        Route::get('/view/notes/requirements', [App\Http\Controllers\Backoffice\ClientController::class, '_viewNRequirement'])->name('view.Req');
        Route::patch('/outcome/accept-or-reject', [App\Http\Controllers\Backoffice\ClientController::class, '_acceptOrReject'])->name('outcome.AOR');
        Route::post('/outcome/client-add', [App\Http\Controllers\Backoffice\ClientController::class, '_addNOutcome'])->name('outcome.CADD');
        Route::put('/outcome/template/accept-or-reject', [App\Http\Controllers\Backoffice\ClientController::class, '_templateAcceptOrReject'])->name('outcome.TEMPLATE');
        Route::post('/ApproveProject', [App\Http\Controllers\Backoffice\ClientController::class, '_approveProject'])->name('approve.project');
        Route::put('/NotApproveProject', [App\Http\Controllers\Backoffice\ClientController::class, '_notApproveProject'])->name('not.approve.project');

        // redflag routes
        Route::post('/new/redflag', [App\Http\Controllers\Backoffice\ClientController::class, '_storeRedflag'])->name('store.Redflag');
        Route::post('/reply/redflag', [App\Http\Controllers\Backoffice\ProjectController::class, '_replyRedflag'])->name('reply.Redflag');
        Route::post('/reply/PMReplyAdmin', [App\Http\Controllers\Backoffice\ProjectController::class, '_replyRedflagPMAdmin'])->name('pm.reply.admin.Redflag');
        Route::post('/outcomes/UploadFile', [App\Http\Controllers\Backoffice\FollowupController::class, '_OutcomeUploadFile'])->name('outcome.uploadfile');
        Route::post('/outcomes/ClientRejectionNote', [App\Http\Controllers\Backoffice\FollowupController::class, '_OutClientRejectionNote'])->name('outcome.ClientRejectionNote');
    });

    # GROUP ROLE FINANCE WITH PREFIX
    Route::group(['prefix' => 'finance'], function () {
        Route::get('/', [App\Http\Controllers\Backoffice\FinanceController::class, 'index']);
        Route::get('/projects', [App\Http\Controllers\Backoffice\FinanceController::class, 'projects']);
        Route::get('/projects/{projectID}', [App\Http\Controllers\Backoffice\FinanceController::class, 'followup']);
        Route::post('/upload-finance-file', [App\Http\Controllers\Backoffice\FinanceController::class, 'uploadFinanceFile']);
        Route::post('/remove-finance-file', [App\Http\Controllers\Backoffice\FinanceController::class, 'removeFinanceFile']);
        Route::post('/hand-offer-task', [App\Http\Controllers\Backoffice\FinanceController::class, 'handOverTask']);
    });

    /** AUDIT CREATOR ROLE ACCOUNT */
    Route::group(['prefix' => 'creator'], function () {
        Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);
        Route::get('/projects', [App\Http\Controllers\Backoffice\CreatorController::class, 'index']);
        Route::post('create-survey-account', [App\Http\Controllers\Backoffice\CreatorController::class, 'createSurveyAccount']);
        Route::post('hand-offer-task', [App\Http\Controllers\Backoffice\CreatorController::class, 'handOverTask']);
    });
    Route::resource('creators', App\Http\Controllers\Backoffice\CreatorController::class)->except('index')->middleware('role:creator');
    Route::get('creators/{creator}/edit/{status?}', [App\Http\Controllers\Backoffice\CreatorController::class, 'edit']);

    # GROUP ROLE INSPECTOR WITH PREFIX
    Route::group(['prefix' => 'inspector'], function () {
        Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);
        Route::get('/projects', [App\Http\Controllers\Backoffice\InspectorController::class, 'index']);
        Route::post('hand-offer-task', [App\Http\Controllers\Backoffice\InspectorController::class, 'handOverTask']);
        Route::any('/handover/endtask', [App\Http\Controllers\Backoffice\ObserverController::class, '_handoverTask'])->name('inspector.handoverTask');
        Route::get('/handover/projects', [App\Http\Controllers\Backoffice\InspectorController::class, '_handoverProjects']);
        Route::get('/handover/{projectID}', [App\Http\Controllers\Backoffice\InspectorController::class, '_handover'])->name('inspector.handover');
    });
    Route::resource('inspectors', App\Http\Controllers\Backoffice\InspectorController::class)->except('show');
    Route::get('inspectors/{inspector}/edit/{status?}', [App\Http\Controllers\Backoffice\InspectorController::class, 'edit']);

    /** ALL RESOURCES ROUTES*/
    Route::resource('users', App\Http\Controllers\UserController::class)->except('show');
    Route::resource('calendar', App\Http\Controllers\CalendarController::class)->except('show');

    /** ALL THE UNCATEGORIZED ROUTES*/
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->middleware('area');
    Route::get('/notify', [App\Http\Controllers\HomeController::class, 'notify']);
    Route::post('calendar-crud-ajax', [App\Http\Controllers\CalendarController::class, 'Calendar']);
    Route::group(['prefix' => 'profile'], function () {
        Route::get('/', [App\Http\Controllers\ProfileController::class, 'index'])->name('profile');
        Route::put('update', [App\Http\Controllers\ProfileController::class, 'update'])->name('update.profile');
    });
});

/*
ajax routes for kader price and qty
*/
Route::post('/operation/kader/qty', [App\Http\Controllers\Backoffice\OperationController::class, '_changeKaderQty'])->name('kader.qty');
Route::post('/operation/kader/price', [App\Http\Controllers\Backoffice\OperationController::class, '_changeKaderPrice'])->name('kader.price');
Route::post('/upload/files', [App\Http\Controllers\Backoffice\FollowupController::class, '_changeProjectFiles'])->name('up.files');
Route::post('/overview/project/edit', [App\Http\Controllers\Backoffice\FollowupController::class, '_changeProjectDetails'])->name('project.details');
Route::patch('/form/project/edit', [App\Http\Controllers\Backoffice\FollowupController::class, '_changeProjectForm'])->name('project.form');
Route::patch('/equipment/project/edit', [App\Http\Controllers\Backoffice\FollowupController::class, '_changeProjectEquipment'])->name('project.equipment');
Route::put('/finance/project/edit', [App\Http\Controllers\Backoffice\FollowupController::class, '_changeProjectFinance'])->name('project.finance');
Route::delete('/delete/rejected/outcome', [App\Http\Controllers\Backoffice\FollowupController::class, '_delRejOutcome'])->name('DEL.REJOUT');
Route::patch('/edit/rejected/outcome', [App\Http\Controllers\Backoffice\FollowupController::class, '_editRejOutcome'])->name('edit.REJOUT');
Route::patch('/upload/new-outcome-file', [App\Http\Controllers\Backoffice\FollowupController::class, '_changeOutcomeFile'])->name('edit.outcomeFile');

Route::post('/kashifinsert', [App\Http\Controllers\KashifController::class, 'recive']);
Route::post('/kashifselect', [App\Http\Controllers\KashifController::class, 'output']);

Route::post('/calender/project/info', [App\Http\Controllers\CalendarController::class, '_getProjectData'])->name('calender.projectInfo');
Route::get('/obstacle/projects', [App\Http\Controllers\HomeController::class, '_obstaclesProjects'])->name('obstacle.projects');
Route::get('/obstacle/projects/{ID}', [App\Http\Controllers\HomeController::class, '_obstaclesProjectInfo'])->name('obstacle.projectInfo');
Route::post('/obstacle/messages', [App\Http\Controllers\HomeController::class, '_getObstaclesMsg'])->name('obstacle.getMsg');
Route::post('/obstacle/chats', [App\Http\Controllers\HomeController::class, '_sendObstaclesMsg'])->name('obstacle.sendMsg');
Route::post('/obstacle/closeObsticale', [App\Http\Controllers\HomeController::class, 'closeObsticale'])->name('obstacle.closeObsticale');
Route::post('/saveObstacle/projects', [App\Http\Controllers\Backoffice\FollowupController::class, 'saveObstacle']);
Route::patch('/add-file/requirement', [App\Http\Controllers\Backoffice\FollowupController::class, '_addReqFile'])->name('req.file');