<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeResource extends JsonResource
{
    public function toArray($request)
    {

        $result = parent::toArray($request);
        $result['skills'] = count($this->skills) > 0 ? $this->skills: [];

        return $result;
        
    }
}