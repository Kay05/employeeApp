<?php
/**
 * @OA\Schema(
 *     title="EmployeeSkills",
 *     description="EmployeeSkills model",
 *     @OA\Xml(
 *         name="EmployeeSkills"
 *     )
 * )
 */
class EmployeeSkills
{

    /**
     * @OA\Property(
     *     title="ID",
     *     description="ID",
     *     format="int64",
     *     example=1
     * )
     *
     * @var integer
     */
    private $id;

    /**
     * @OA\Property(
     *      title="Name",
     *      description="Name of the skill",
     *      example="Dancing"
     * )
     *
     * @var string
     */
    public $name;

    /**
     * @OA\Property(
     *      title="Experience",
     *      description="The number of years of experience for a skill",
     *      example="2"
     * )
     *
     * @var string
     */
    public $experience;

    /**
     * @OA\Property(
     *      title="Seniority Rating",
     *      description="How the use of the skill is rated",
     *      example="4"
     * )
     *
     * @var string
     */
    public $rating;

    /**
     * @OA\Property(
     *     title="Created at",
     *     description="Created at",
     *     example="2020-01-27 17:50:45",
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
     *     example="2020-01-27 17:50:45",
     *     format="datetime",
     *     type="string"
     * )
     *
     * @var \DateTime
     */
    private $updated_at;
}