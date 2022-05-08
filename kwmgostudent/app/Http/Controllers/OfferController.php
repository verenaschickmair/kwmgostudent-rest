<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OfferController extends Controller
{
    /**
     * Gives back all users
     */
    public function index() : JsonResponse{
        $offers = Offer::all(['id', 'name', 'description']);
        return response()->json($offers, 200);
    }

//    public function findByUsername(string $username) : User {
//        $student = Offer::where('username', $username)
//            ->with(['firstname', 'lastname', 'course_of_studies', 'semester'])
//            ->first();
//        return $student;
//    }

    public function checkOffername (string $code) {
        $student =  Offer::where('username', $code)->first();
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
        $student = Offer::with(['firstname', 'lastname', 'course_of_studies', 'semester'])
            ->where('firstname', 'LIKE', '%' . $searchTerm. '%')
            ->orWhere('lastname' , 'LIKE', '%' . $searchTerm. '%')
            ->orWhere('username' , 'LIKE', '%' . $searchTerm. '%');
        return $student;
    }

    /**
     * create new user
     */

    public function save(Request $request) : JsonResponse {
        DB::beginTransaction();
        try {
            $student = Offer::create($request->all());
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
            $student = Offer::with(['firstname', 'lastname', 'course_of_studies', 'semester'])
                ->where('username', $code)->first();
            if ($student != null) {
                $student->update($request->all());
                $student->save();
            }
            //update authors

            $ids = [];
            if (isset($request['authors']) && is_array($request['authors'])) {
                foreach ($request['authors'] as $auth) {
                    array_push($ids,$auth['id']);
                }
            }
            $student->authors()->sync($ids);

            DB::commit();
            $student1 = Offer::with(['firstname', 'lastname', 'course_of_studies', 'semester'])
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
        $student = Offer::where('personal_code', $code)->first();
        if ($student != null) {
            $student->delete();
        }
        else
            throw new \Exception("student couldn't be deleted - it does not exist");
        return response()->json('student (' . $code . ') successfully deleted', 200);

    }
}
