<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
// Controllers
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\LabelController;
use App\Http\Controllers\TicketController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


//  AUTH
Route::post('register',[AuthController::class,'register']);
Route::post('register/admin',[AuthController::class,'registerAdmin']);
Route::post('login', [AuthController::class, 'login']);

// JWT PROTECTED middleware
Route::group(['middleware' => ['jwt.verify']], function () {
    Route::post('logout', [AuthController::class, 'logout']);


    // CATEGORY
    Route::middleware(['role:admin,agent,user'])->group(function () {
        // SHOW ALL CATEGORY
        Route::get('category', [CategoryController::class, 'show']);
        // FIND CATEGORY
        Route::get('category/{id}', [CategoryController::class, 'find']);
    });
    // only admin and agent cant create,update,delete category
    Route::middleware(['role:admin,agent'])->group(function () {
        // CREATE CATEGORY
        Route::post('category', [CategoryController::class, 'create']);
        // UPDATE CATEGORY
        Route::put('category/{id}', [CategoryController::class, 'update']);
        // DELETE CATEGORY
        Route::delete('category/{id}', [CategoryController::class, 'delete']);
    });


    // LABEL
    Route::middleware(['role:admin,agent,user'])->group(function () {
        // SHOW ALL LABEL
        Route::get('label', [LabelController::class, 'show']);
        // FIND LABEL
        Route::get('label/{id}', [LabelController::class, 'find']);
    });
    // only admin and agent cant create,update,delete label
    Route::middleware(['role:admin,agent'])->group(function () {
        // CREATE LABEL
        Route::post('label', [LabelController::class, 'create']);
        // UPDATE LABEL
        Route::put('label/{id}', [LabelController::class, 'update']);
        // DELETE LABEL
        Route::delete('label/{id}', [LabelController::class, 'delete']);
    });
    

    // TICKET
    Route::middleware(['role:admin,user,agent'])->group(function () {
        // CREATE TICKETS
        Route::post('ticket', [TicketController::class, 'create']);
        // SHOW ALL TICKETS
        Route::get('ticket', [TicketController::class, 'show']);
        // FIND TICKETS
        Route::get('ticket/{id}', [TicketController::class, 'find']);
    });
    Route::middleware(['role:admin,agent'])->group(function () {
        // UPDATE TICKETS
        Route::put('ticket/{id}', [TicketController::class, 'update']);
        // DELETE TICKETS
        Route::delete('ticket/{id}', [TicketController::class, 'delete']);
    });


    
    // ADMIN 
    Route::middleware(['role:admin'])->group(function () {
        // CREATE AGENT
        Route::post('register/agent',[AuthController::class,'registerAgent']);

    });
    // USER
    Route::middleware(['role:user'])->group(function () {
        //Route::get('/user-profile', 'UserProfileController@index');
    });
    // AGENT
    Route::middleware(['role:agent'])->group(function () {
        //Route::get('/agent-profile', 'UserProfileController@index');
    });

});

