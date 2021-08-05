<?php

namespace Database\Seeders;

use App\Models\Skill;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $skills = [
            "excel",
            "word", 
            "powerpoint", 
            "management", "dancing", 
            "singing", "plumbing", "public speaking"
        ];
        foreach ($skills as $skill) {
            Skill::create([
                'name' => $skill
            ]);
        }
    }
}
