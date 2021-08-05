<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EmployeeTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_EmployeeGetList()
    {
        $this->get('/api/v1/employees')
        ->assertStatus(200)
        ->assertJsonStructure([
            '*' => [
                ['id', 'first_name', 'email']
            ]
        ]);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_EmployeeGet()
    {
        $this->get('/api/v1/employees/1')
        ->assertStatus(202)
        ->assertJsonStructure([
            '*' => [
                'id', 'first_name', 'email'
            ]
        ]);
    }

    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function test_Post()
    {
        $employee = [
            'first_name' => 'Sally',
            'last_name' => 'Test',
            'contact_number' => '0115237281',
            'email' => 'sally@jsense.com',
            'dob' => '1990-09-09',
            'address' => 'Address Street',
            'city' => 'Jozi',
            'postal_code' => '1237',
            'country' => 'ZA',
            'skills' => [
                ['name' => 'Test skill', 'experience' => '2', 'rating' => 'Beginner']
            ]
        ];
        $this->json('POST', '/api/v1/employees', $employee)
        ->assertStatus(201)
        ->assertJsonStructure([
            '*' => [
                'id', 'first_name', 'email'
            ]
        ]);
    }

    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function test_Put()
    {
        $employee = [
            'first_name' => 'Sally',
            'last_name' => 'Test',
            'contact_number' => '0115237281',
            'email' => 'sally@pepe.com',
            'dob' => '1990-09-09',
            'address' => 'Address Street',
            'city' => 'Jozi',
            'postal_code' => '1237',
            'country' => 'ZA',
            'skills' => [
                ['name' => 'Test skill', 'experience' => '2', 'rating' => 'Beginner']
            ]
        ];
        $this->json('PUT', '/api/v1/employees/1', $employee)
        ->assertStatus(202)
        ->assertJsonStructure([
            '*' => [
                'id', 'first_name', 'email'
            ]
        ]);
    }
}
