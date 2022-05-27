<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class AppointmentController extends Controller
{
    public function index() : JsonResponse{
        $offers = Appointment::all(['id', 'date', 'time_from', 'time_to']);
        return response()->json($offers, 200);
    }

//    public function getAllByOfferId(int $id) : JsonResponse{
//        $offers = Appointment::where('offer_id', $id)->get();
//        return response()->json($offers, 200);
//    }

    public function getAllByUserId(int $id) : JsonResponse{
        $offers = Appointment::where('user_id', $id)->get();
        return response()->json($offers, 200);
    }


    public function book(Request $request){
        DB::beginTransaction();
        try {
            $appointment = Appointment::where('id', $request->id)->first();
            if($appointment != null) {
                $appointment->update(['user_id' => $request->user_id]);
                $appointment->save();
            }
            DB::commit();
            // return a vaild http response
            $appointment = Appointment::where('id', $request->id)->get();
            return response()->json($appointment, 201);
        }
        catch (\Exception $e) {
            // rollback all queries
            DB::rollBack();
            return response()->json("booking appointment failed: " . $e->getMessage(), 420);
        }

    }
}
