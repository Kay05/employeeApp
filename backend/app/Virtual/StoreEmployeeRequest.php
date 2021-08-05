<?php

namespace App\Virtual;

/**
 * @OA\Schema(
 *      title="Store Employee request",
 *      description="Store Employee request body data",
 *      type="object",
 *      required={"name"}
 * )
 */

class StoreEmployeeRequest
{
    /**
     * @OA\Property(
     *     title="ID",
     *     description="Auto generated database ",
     *     format="int64",
     *     example=1
     * )
     *
     * @var integer
     */
    private $id;

    /**
     * @OA\Property(
     *     title="Employee ID",
     *     description="Assigned employee id",
     *     example="TD1234"
     * )
     *
     * @var string
     */
    private $employeeID;

    /**
     * @OA\Property(
     *      title="First Name",
     *      description="FirstName of the employee",
     *      example="Kuda"
     * )
     *
     * @var string
     */
    public $first_name;

    /**
     * @OA\Property(
     *      title="Last Name",
     *      description="LastName of the employee",
     *      example="Dhliwayo"
     * )
     *
     * @var string
     */
    public $last_name;

    /**
     * @OA\Property(
     *      title="Contact Number",
     *      description="Contact number of the employee",
     *      example="0112341234"
     * )
     *
     * @var string
     */
    public $contact_number;

    /**
     * @OA\Property(
     *      title="Email",
     *      description="Email address of the employee",
     *      example="kuda@test.com"
     * )
     *
     * @var string
     */
    public $email;

    /**
     * @OA\Property(
     *     title="Date of birth",
     *     description="Employee's date of birth",
     *     example="1995-01-27",
     *     format="date",
     *     type="string"
     * )
     *
     * @var \Date
     */
    private $dob;
    
    /**
     * @OA\Property(
     *      title="Address",
     *      description="Employee's home address",
     *      example="123 William Nicole Drive"
     * )
     *
     * @var string
     */
    public $address;

    /**
     * @OA\Property(
     *      title="City",
     *      description="Email's city",
     *      example="Johannesburg"
     * )
     *
     * @var string
     */
    public $city;

    /**
     * @OA\Property(
     *      title="Postal Code",
     *      description="Employee's Postal Code",
     *      example="1234"
     * )
     *
     * @var string
     */
    public $postal_code;

    /**
     * @OA\Property(
     *      title="Country",
     *      description="Employee's country",
     *      example="South Africa"
     * )
     *
     * @var string
     */
    public $country;

    /**
     * @OA\Property(
     *     title="Created at",
     *     description="Created at",
     *     example="2021-07-27 17:50:45",
     *     format="datetime",
     *     type="string"
     * )
     *
     * @var \DateTime
     */
    private $created_at;

    /**
     * @OA\Property(
     *     title="Updated at",
     *     description="Updated at",
     *     example="2021-08-27 17:50:45",
     *     format="datetime",
     *     type="string"
     * )
     *
     * @var \DateTime
     */
    private $updated_at;

    /**
     * @OA\Property(
     *     title="Skills",
     *     description="Employee's skills model"
     * )
     *
     * @var \App\Virtual\Models\EmployeeSkills[]
     */
    private $skills;
}