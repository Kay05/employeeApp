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
            "Excel",
            "Word", 
            "Powerpoint", 
            "Management", "Dancing", 
            "Singing", "Plumbing", "Public Speaking"
        ];
        foreach ($skills as $skill) {
            Skill::create([
                'name' => $skill,
                'slug' => strtolower($skill)
            ]);
        }
    }
}
