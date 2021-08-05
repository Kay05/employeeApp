<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Http\Resources\EmployeeCollection;
use App\Http\Resources\EmployeeResource;
use App\Models\Employee;
use App\Models\Skill;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EmployeeApiController extends Controller
{
    /**
     * @OA\Get(
     *      path="/employees",
     *      operationId="getEmployeesList",
     *      tags={"Employees"},
     *      summary="Get list of employees",
     *      description="Returns list of employees",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/EmployeeResource")
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     *     )
     */
    public function index()
    {
        /**
         * Todo
         * use collection resourse with pagination
         */
        // return  new EmployeeCollection(Employee::paginate());
        return  new EmployeeCollection(Employee::all());
    }


    /**
     * @OA\Post(
     *      path="/employees",
     *      operationId="storeEmployee",
     *      tags={"Employees"},
     *      summary="Store new employee",
     *      description="Returns employee data",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/StoreEmployeeRequest")
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/Employee")
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     */
    public function store(StoreEmployeeRequest $request)
    {
        $employee = Employee::create($request->all());

        $this->addSkills($request, $employee);

        return (new EmployeeResource($employee))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * @OA\Get(
     *      path="/employees/{id}",
     *      operationId="showEmployee",
     *      tags={"Employees"},
     *      summary="Get existing Employee",
     *      description="Returns employee data",
     *      @OA\Parameter(
     *          name="id",
     *          description="Employee id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=202,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/Employee")
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Resource Not Found"
     *      )
     * )
     */
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $employee)
    {
        return (new EmployeeResource($employee))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    /**
     * @OA\Put(
     *      path="/employees/{id}",
     *      operationId="updateEmployee",
     *      tags={"Employees"},
     *      summary="Update existing Employee",
     *      description="Returns updated employee data",
     *      @OA\Parameter(
     *          name="id",
     *          description="Employee id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/StoreEmployeeRequest")
     *      ),
     *      @OA\Response(
     *          response=202,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/Employee")
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Resource Not Found"
     *      )
     * )
     */
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateEmployeeRequest $request, Employee $employee)
    {
        $employee->update($request->all());

        // update employee skills
        $this->updateSkills($request, $employee);

        return (new EmployeeResource($employee))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    /**
     * @OA\Delete(
     *      path="/employees/{id}",
     *      operationId="deleteEmployee",
     *      tags={"Employees"},
     *      summary="Delete existing employee",
     *      description="Deletes a record and returns no content",
     *      @OA\Parameter(
     *          name="id",
     *          description="Emoployee id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=204,
     *          description="Successful operation",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Resource Not Found"
     *      )
     * )
     */
    /**
     * Delete the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $employee)
    {
        $employee->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * @OA\Delete(
     *      path="/employees/{id}/skill/{skill_id}",
     *      operationId="deleteEmployeeSkill",
     *      tags={"EmployeeSkill"},
     *      summary="Delete employee skill",
     *      description="Deletes an employee skill",
     *      @OA\Parameter(
     *          name="id",
     *          description="Emoployee id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="skill_id",
     *          description="Skill id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Response(
     *          response=204,
     *          description="Successful operation",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Resource Not Found"
     *      )
     * )
     */
    /**
     * Delete the specified resource.
     *
     * @param  String  $id
     * @param  String $skill_id
     * @return \Illuminate\Http\Response
     */
    public function deleteEmployeeSkill(String $id, String $skill_id)
    {
        // find employee
        $employee = Employee::find($id);

        // removing skill
        $employee->skills()->detach($skill_id);

        return (new EmployeeResource($employee))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    /**
     * Add employee skills function
     *
     * @param Request $request
     * @param Employee $employee
     * @return void
     */
    private function addSkills(Request $request, Employee $employee)
    {
        foreach ($request['skills'] as $skillArray) {
            // check if skill name already exists using unique slug
            $skill = \App\Models\Skill::where('slug', strtolower($skillArray['name']))->first();
            if (!$skill) {
                // create skill
                $skill = new \App\Models\Skill();
                $skill->slug = strtolower($skillArray['name']);
                $skill->name = $skillArray['name'];
                $skill->save();
            }

            $employee->skills()->attach($skill->id, ['experience' => $skillArray['experience'], 'rating' => $skillArray['rating']]);
        }
    }

    /**
     * Update employee skills function
     *
     * @param Request $request
     * @param Employee $employee
     * @return void
     */
    private function updateSkills(Request $request, Employee $employee)
    {
        foreach ($request['skills'] as $skillArray) {
            // check if skill name already exists using unique slug
            $skill = \App\Models\Skill::where('slug', strtolower($skillArray['name']))->first();
            if (!$skill) {
                // create skill
                $skill = new \App\Models\Skill();
                $skill->slug = strtolower($skillArray['name']);
                $skill->name = $skillArray['name'];
                $skill->save();
            }

            // check of employee already has this skill
            $employeeSkill = \App\Models\EmployeeSkill::where('employee_id', $employee->id)->where('skill_id', $skill->id)->first();
            if ($employeeSkill) {
                // update all the other attributes
                $employeeSkill->experience = $skillArray['experience'];
                $employeeSkill->rating = $skillArray['rating'];
                $employeeSkill->save();
            } else {
                // employee does not have skill
                $employee->skills()->attach($skill->id, ['experience' => $skillArray['experience'], 'rating' => $skillArray['rating']]);
            }
        }
    }
}
