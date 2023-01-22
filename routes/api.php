<?php

use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\StudentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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


//Register
Route::post('register',[AuthController::class,'register']);
//Login
Route::post('login',[AuthController::class,'login']);

//User Info
Route::middleware('auth:api')->group(function(){
    //Show All Register User
    Route::get('user-info',[AuthController::class,'userInfo']);
    //Show Name wise search user
    Route::get('/search-user/{name}',[AuthController::class,'searchUser']);

    //Store Student Marks
    Route::post('/student-marks-store',[StudentController::class,'storeStudentMarks']);

    //get english mark 80 up student list
    Route::get('/student-marks-show',[StudentController::class,'getStudentHightMarksInEnglish']);
});
