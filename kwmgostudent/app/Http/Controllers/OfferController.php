<?php

namespace App\Http\Controllers;

use App\Models\Offer;
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

    public function getAllBySubjectId(int $id) : JsonResponse{
        $offers = Offer::where('subject_id', $id)->get();
        return response()->json($offers, 200);
    }

    public function findById(int $id) : Offer {
        return Offer::where('id', $id)->first();
    }

//    public function findByUsername(string $username) : User {
//        $offer = Offer::where('username', $username)
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
            $offer = Offer::create($request->all());
            DB::commit();
            return response()->json($offer, 201);
        }
        catch (\Exception $e) {
            DB::rollBack();
            return response()->json("saving offer failed:" . $e->getMessage(), 420);
        }
    }

    public function update(Request $request, string $id) : JsonResponse
    {
        DB::beginTransaction();
        try {
            $offer = Offer::with(['appointments'])
                ->where('id', $id)->first();
            if ($offer != null) {
                $offer->update($request->all());
                $offer->save();
            }
            //update appointments
            $ids = [];
            if (isset($request['appointments']) && is_array($request['appointments'])) {
                foreach ($request['appointments'] as $app) {
                    array_push($ids,$app['id']);
                }
            }
            $offer->appointments()->sync($ids);

            DB::commit();
            $offer1 = Offer::with(['appointments'])
                ->where('id', $id)->first();
            // return a vaild http response
            return response()->json($offer1, 201);
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
        $offer = Offer::where('personal_code', $code)->first();
        if ($offer != null) {
            $offer->delete();
        }
        else
            throw new \Exception("student couldn't be deleted - it does not exist");
        return response()->json('student (' . $code . ') successfully deleted', 200);

    }
}
