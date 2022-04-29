<?php

namespace Database\Seeders;

use App\Models\Subject;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SubjectsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        {
            $subject = new Subject;
            $subject->lva = 'lva' . rand(100, 999);
            $subject->name = 'Mathematik';
            $subject->description = Str::random(100);
            $subject->save();
        }
        {
            $subject = new Subject;
            $subject->lva = 'lva'.rand(100, 999);
            $subject->name = 'Informatik';
            $subject->description = Str::random(100);
            $subject->save();
        }
        {
            $subject = new Subject;
            $subject->lva = 'lva'.rand(100, 999);
            $subject->name = 'Deutsch';
            $subject->description = Str::random(100);
            $subject->save();
        }
    }

}
