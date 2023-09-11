<?php

use App\Http\Controllers\AgreementListCodeController;
use App\Http\Controllers\AgreementListController;
use App\Http\Controllers\GenerateAgreementCodeController;
use App\Http\Controllers\InspectionDataController;
use App\Http\Controllers\AttachmentController;
use App\Http\Controllers\DesignerSectionController;
use App\Http\Controllers\EmployeeNotification;
use App\Http\Controllers\UnitController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Models\Attachement;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::apiResource('/user', UserController::class);
Route::apiResource('/unit', UnitController::class);
Route::apiResource('/agreement-list', AgreementListController::class);
Route::apiResource('/agreement-list-code', AgreementListCodeController::class);
Route::apiResource('/generate-agreement-code', GenerateAgreementCodeController::class);
Route::apiResource('/inspection-data', InspectionDataController::class);
Route::apiResource('/attachment', AttachmentController::class);
Route::apiResource('designer-section-answer', DesignerSectionController::class);
Route::apiResource('employee-notification', EmployeeNotification::class);

Route::get('/load-with-code-request', [AgreementListController::class, 'loadWithCodeRequest']);
Route::get('/load-email-list', [UserController::class, 'loadEmailList']);
Route::get('/load-qci-email-list', [UserController::class, 'loadQCIEmailList']);
Route::get('/load-pe-email-list', [UserController::class, 'loadPEEmailList']);
Route::get('/load-task-to-do', [AgreementListController::class, 'loadTaskToDo']);
Route::get('/load-activity-logs', [UserController::class, 'loadActivityLogs']);
Route::get('/load-with-code-inspection', [AgreementListController::class, 'loadCodeWithInspectionData']);
Route::get('/load-with-code-designer-section', [AgreementListController::class, 'loadCodeWithDesignerSection']);
Route::get('/load-with-no-code-request', [AgreementListController::class, 'loadWithNoCodeRequest']);
Route::get('/load-part-number-with-code', [AgreementListController::class, 'loadPartNumberWithCode']);
Route::get('/count-request', [AgreementListController::class, 'countRequest']);
Route::post('/upload-multiple-agreement-request', [AgreementListController::class, 'multipleStore']);
Route::get('/load-part-number-with-critical', [AgreementListController::class, 'loadPartNumberWithCritical']);
Route::get('/load-part-number-with-attachment', [AgreementListController::class, 'loadPartNumberAttachment']);
Route::get('/load-with-code-attachment', [AgreementListController::class, 'loadWithCodeAttachment']);
Route::delete('/delete-unit/{id}/{emp_id}', [UnitController::class, 'deleteUnit']);
Route::delete('/delete-agreement-list/{id}/{emp_id}', [AgreementListController::class, 'deleteAgreement']);
Route::delete('/delete-monitoring/{id}/{emp_id}', [AgreementListController::class, 'deleteMonitoring']);
Route::delete('/delete-user/{id}/{emp_id}', [UserController::class, 'deleteUser']);
Route::post('/insert-designer-answer', [DesignerSectionController::class, 'storeSingleDesignerAnswer']);
Route::get('/show-monitoring-list/{part_number}', [AgreementListController::class, 'showMonitoring']);
Route::get('/show-monitoring-list-edit/{unit_id}/{supplier}/{part_number}', [AgreementListController::class, 'showMonitoringList']);
Route::get('/show-monitoring-list-attachment/{unit_id}/{supplier}/{part_number}', [AgreementListController::class, 'showAttachment']);
Route::get('/load-count-result', [AgreementListController::class, 'loadCountResult']);
Route::get('/load-monitoring-list', [AgreementListController::class, 'loadMonitoringList']);
Route::get('/export-monitoring-list/{unit_id}/{supplier}/{part_number}', [AgreementListController::class, 'exportMonitoringList']);

Route::post('download-attachment', [AttachmentController::class, 'downloadAttachment']);
