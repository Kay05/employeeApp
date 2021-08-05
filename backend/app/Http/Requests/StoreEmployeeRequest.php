<?php

namespace App\Http\Requests;

use App\Models\Employee;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class StoreEmployeeRequest extends FormRequest
{
    public function authorize() 
    {
        // abort_if(Gate::denies('project_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'first_name' => 'required|string|max:20',
            'last_name' => 'required|string|max:20',
            'email' => 'required|email|string|unique:employees',
            'contact_number' => 'required|string|max:10',
            'dob' => 'required|date_format:Y-m-d|before:today',
            'address' => 'required|string|max:255',
            'postal_code' => 'required|string|max:5',
            'city' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'skills' => "required|array|min:1",
            'skill.*.name' => 'required|string',
            'skill.*.experience' => 'required|string',
            'skill.*.rating' => 'required|string',
        ];
    }
}