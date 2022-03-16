<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PassportAuthController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\ExcelCSVController;

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

// register
Route::post('register', [PassportAuthController::class, 'register']);

// login
Route::post('login', [PassportAuthController::class, 'login']);

// after authenticate
Route::middleware('auth:api')->group(function () {
    // view user(self) detail
    Route::get('/user', function(Request $request){
        return $request->user();
    });


    Route::apiResource('/users', AccountController::class);

    // import csv file to create users
    Route::post('import-excel-csv-file', [ExcelCSVController::class, 'importExcelCSV']);
    Route::post('create-excel-csv-file', [ExcelCSVController::class, 'CreateUser']);
    // import csv file to edit users
    Route::post('edit-excel-csv-file', [ExcelCSVController::class, 'editUser']);
    // import csv file to delete users
    Route::post('delete-excel-csv-file', [ExcelCSVController::class, 'deleteUser']);


});
