<?php

namespace Database\Seeders;

use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Seeder;


class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User;

        //get the first user
        $student = Student::all()->first();
        $user->student()->associate($student);

        $user->status=0;
        $user->name="testuser";
        $user->email="test@mail.com";
        $user->password=bcrypt('secret');
        $user->save();
    }
}
