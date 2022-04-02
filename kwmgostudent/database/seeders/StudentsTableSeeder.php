<?php

namespace Database\Seeders;

use App\Models\Student;
use DateTime;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class StudentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $student = new Student();
        $student->personal_code = "S".Str::random(10);
        $student->firstname = Str::random(5);
        $student->lastname = Str::random(10);
        $student->course_of_studies = Str::random(10);
        $student->studies_type = "KWM";
        $student->semester = 1;
        $student->phone = 123456;
        $student->email = Str::random(10);
        $student->save();
    }
}
