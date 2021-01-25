<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccountController;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ContactsController;

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

Route::middleware('auth:api')->group( function() {
    Route::get('/user', [AccountController::class, 'show']);
    Route::post('/user/edit-image', [AccountController::class, 'editImage']);
    Route::post('/sms/send', [PostController::class, 'create']);
    Route::post('/user/sms/edit/{id}', [PostController::class, 'edit']);
    Route::post('/user/edit/phone', [AccountController::class, 'editPhoneNumber']);
    Route::post('/user/edit/password', [AccountController::class, 'editPassword']);
    Route::get('/sms/all', [PostController::class, 'show']);
    Route::get('/user/sms', [AccountController::class, 'posts']);
    Route::put('/user/subscribed-user/save', [AccountController::class, 'subCompany']);
    Route::delete('/user/delete/subscribed-user/{company_save}', [AccountController::class, 'undoSubCompany']);
    Route::get('/user/subscribed-users', [AccountController::class, 'getAllSubscribedUsers']);
    Route::put('/user/saved-user/save', [AccountController::class, 'saveCompanyToUser']);
    Route::delete('/user/delete/saved-user/{company_save}', [AccountController::class, 'undoSaveCompanyToUser']);
    Route::get('/user/saved-users', [AccountController::class, 'getAllSavedCompanies']);
    Route::get('/user/contacts', [ContactsController::class, 'index']);
    Route::post('/user/contacts/create', [ContactsController::class, 'create']);
    Route::get('/user/posts/sms', [AccountController::class, 'sms']);
    Route::get('/user/notifications', [AccountController::class, 'notifications']);
    Route::get('/companies', [PostController::class, 'companies']);
    Route::delete('/user/post/{id}', [PostController::class, 'destroy']);
});



 Route::prefix('account')
         ->group(function () {
             Route::post('/create', [AccountController::class, 'create']);
         });


Route::post('/sanctum/token', [AccountController::class, 'logUserIn']);
