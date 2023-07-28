<?php

use App\Http\Controllers\AgreementListController;
use App\Http\Controllers\AttachmentController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('download-format', [AgreementListController::class, 'downloadFormat']);
Route::get('download-attachment', [AttachmentController::class, 'downloadAttachment']);
Route::get('view-attachment', [AttachmentController::class, 'viewAttachement']);
Route::get('/export/{unit_id}/{supplier}/{part_number}', [AgreementListController::class, 'exportMonitoringList']);
