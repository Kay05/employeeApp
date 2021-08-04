<?php

use App\Http\Controllers\Api\V1\ApiController;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\ProjectsApiController;
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
    // Route::get('/all-user', 'Api\V1\ApiController@allUsers')->name('all-user');

    // Projects
    Route::apiResource('projects', ProjectsApiController::class);
});

//auth routes
Route::post('user-register', [AuthController::class, 'register']);
Route::post('v1/user-login', [AuthController::class, 'login']);

//lists all active tests
// Route::get('v1/test', 'API\V1\ApiController@getActiveTest');

//lists payment detail of an individual
// Route::get('v1/paymentdetail/{id}', 'API\V1\API@paymentDetail');

//lists test user details
// Route::get('v1/testuser', 'API\V1\ApiController@testUsers');

//lists all active packages
// Route::get('v1/package', 'API\V1\ApiController@getPackages');

//lists every tests within the package
// Route::get('v1/packagedetail/{id}', 'API\V1\ApiController@getPackageDetails');

//lists all test details(test sections, questions, options)
// Route::post('v1/testdetail/{id}', 'API\V1\ApiController@testDetails');
