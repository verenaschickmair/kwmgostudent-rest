<?php

namespace Database\Seeders;

use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;


class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        {
            $user = new User;
            $user->username = "student";
            $user->password = bcrypt('secret');
            $user->firstname = "Max";
            $user->lastname = "Mustermann";
            $user->course_of_studies = "SE";
            $user->studies_type = "Bachelor";
            $user->semester = 6;
            $user->phone = 123456;
            $user->email = "searcher@gmail.com";
            $user->status = 0;
            $user->save();
        }
        {
            $user = new User;
            $user->username = "teacher";
            $user->password = bcrypt('secret');
            $user->firstname = 'Maxime';
            $user->lastname = 'Musterfrau';
            $user->course_of_studies = 'KWM';
            $user->studies_type = "Bachelor";
            $user->semester = 4;
            $user->phone = 123456;
            $user->email = "teacher@gmail.com";
            $user->status = 1;
            $user->save();
        }
    }
}
