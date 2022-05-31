<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\JsonResponse;

class SubjectController extends Controller
{
    public function index() : JsonResponse{
        $subjects = Subject::all(['id', 'lva', 'name', 'description']);
        return response()->json($subjects, 200);
    }

    public function findById(int $id) : Subject {
        $subject = Subject::where('id', $id)->first();
        return $subject;
    }

    /**
     * create new subject
     */

    public function save(Request $request) : JsonResponse {
        DB::beginTransaction();
        try {
            $subject = Offer::create($request->all());
            DB::commit();
            return response()->json($subject, 201);
        }
        catch (\Exception $e) {
            DB::rollBack();
            return response()->json("saving subject failed:" . $e->getMessage(), 420);
        }
    }

    public function update(Request $request, string $id) : JsonResponse
    {
        DB::beginTransaction();
        try {
            $subject = Offer::where('id', $id)->first();
            if ($subject != null) {
                $subject->update($request->all());
                $subject->save();
            }

            DB::commit();
            $subject = Offer::where('id', $id)->first();
            // return a vaild http response
            return response()->json($subject, 201);
        }
        catch (\Exception $e) {
            // rollback all queries
            DB::rollBack();
            return response()->json("updating subject failed: " . $e->getMessage(), 420);
        }
    }

    /**
     * returns 200 if subject deleted successfully, throws excpetion if not
     */
    public function delete(string $id) : JsonResponse
    {
        $subject = Offer::where('id', $id)->first();
        if ($subject != null) {
            $subject->delete();
        }
        else
            throw new \Exception("subject couldn't be deleted - it does not exist");
        return response()->json('subject (' . $id . ') successfully deleted', 200);

    }


}
