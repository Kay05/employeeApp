<?php

use App\Http\Controllers\Api\V1\ApiController;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\EmployeeApiController;
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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });




Route::group([
    'prefix' => 'v1',
    'as' => 'api.',
    'middleware' => ['auth:api']
], function () {
    //lists all users
    Route::get('/users', [ApiController::class, 'allUsers'])->name('all-user');

    // Employees
    // Route::apiResource('employees', EmployeeApiController::class);
});

Route::delete('v1/employees/{id}/skill/{skill_id}', [EmployeeApiController::class, 'deleteEmployeeSkill']);
Route::apiResource('v1/employees', EmployeeApiController::class);


//auth routes
Route::post('v1/user-register', [AuthController::class, 'register']);
Route::post('v1/user-login', [AuthController::class, 'login']);
