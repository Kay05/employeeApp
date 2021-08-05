<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Package;
use App\Payment;
use App\Test;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Resources\ActiveTest as ActiveTestResource;
use App\Http\Resources\Test as TestResource;
use App\Http\Resources\Payment as PaymentResource;
use App\Http\Resources\PackageDetail as PackageDetailResource;
use App\Http\Resources\Package as PackageResource;
use App\Http\Resources\UserResource;
use App\Http\Resources\UserTest as UserTestResource;

class ApiController extends Controller
{


    /**
     * @OA\Get(
     *      path="/users",
     *      operationId="getUserList",
     *      tags={"Users"},
     * security={
     *  {"passport": {}},
     *   },
     *      summary="Get list of users",
     *      description="Returns list of users",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     * @OA\Response(
     *      response=400,
     *      description="Bad Request"
     *   ),
     * @OA\Response(
     *      response=404,
     *      description="not found"
     *   ),
     *  )
     */
    public function allUsers()
    {
        $users = User::all();
        return response()->json([
            'status' => 'success',
            'status_code' => Response::HTTP_OK,
            'data' => [
                'users' => UserResource::collection($users)
            ],

            'message' => 'All users pulled out successfully'

        ]);
    }
}