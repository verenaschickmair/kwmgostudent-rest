<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    public function index() : JsonResponse{
        $students = Student::with(['firstname', 'lastname', 'course_of_studies', 'semester'])->get();
        return response()->json($students, 200);    }


    public function findByPersonalCode(string $code) : Student {

        $student = Student::where('personal_code', $code)
            ->with(['firstname', 'lastname', 'course_of_studies', 'semester'])
            ->first();

        return $student;

    }

    public function checkPersonalCode (string $code) {
        $student =  Student::where('personal_code', $code)->first();
        return $student != null ?
            response()->json(true, 200) :
            response()->json(false, 200);
    }

    /**
     * find book by search term
     * SQL injection is prevented by default, because Eloquent
     * uses PDO parameter binding
     */
    public function findBySearchTerm(string $searchTerm) {
        $student = Student::with(['firstname', 'lastname', 'course_of_studies', 'semester'])
            ->where('firstname', 'LIKE', '%' . $searchTerm. '%')
            ->orWhere('lastname' , 'LIKE', '%' . $searchTerm. '%')
            ->orWhere('personal_code' , 'LIKE', '%' . $searchTerm. '%');
        return $student;
    }

    /**
     * create new book
     */

    public function save(Request $request) : JsonResponse {
        DB::beginTransaction();
        try {
            $student = Student::create($request->all());
            DB::commit();
            return response()->json($student, 201);
        }
        catch (\Exception $e) {
            DB::rollBack();
            return response()->json("saving student failed:" . $e->getMessage(), 420);
        }
    }

    public function update(Request $request, string $code) : JsonResponse
    {
        DB::beginTransaction();
        try {
            $student = Student::with(['firstname', 'lastname', 'course_of_studies', 'semester'])
                ->where('personal_code', $code)->first();
            if ($student != null) {
                $student->update($request->all());
                $student->save();
            }
            DB::commit();
            $student1 = Student::with(['firstname', 'lastname', 'course_of_studies', 'semester'])
                ->where('personal_code', $code)->first();
            // return a vaild http response
            return response()->json($student1, 201);
        }
        catch (\Exception $e) {
            // rollback all queries
            DB::rollBack();
            return response()->json("updating student failed: " . $e->getMessage(), 420);
        }
    }

    /**
     * returns 200 if book deleted successfully, throws excpetion if not
     */
    public function delete(string $code) : JsonResponse
    {
        $student = Student::where('personal_code', $code)->first();
        if ($student != null) {
            $student->delete();
        }
        else
            throw new \Exception("student couldn't be deleted - it does not exist");
        return response()->json('student (' . $code . ') successfully deleted', 200);

    }
}
