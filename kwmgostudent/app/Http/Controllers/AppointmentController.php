<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class AppointmentController extends Controller
{
    public function index() : JsonResponse{
        $offers = Appointment::all(['id', 'date', 'time_from', 'time_to']);
        return response()->json($offers, 200);
    }

    public function findAllByUserId(int $id) : JsonResponse{
        $offers = Appointment::where('user_id', $id)->get();
        return response()->json($offers, 200);
    }

    public function findAllByOfferId(int $id) : JsonResponse{
        $offers = Appointment::where('offer_id', $id)->get();
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

    public function cancel(Request $request){
        DB::beginTransaction();
        try {
            $appointment = Appointment::where('id', $request->id)->first();
            if($appointment != null) {
                $appointment->update(['user_id' => null]);
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
            return response()->json("canceling appointment failed: " . $e->getMessage(), 420);
        }
    }

    /**
     * create new appointment
     */

    public function save(Request $request) : JsonResponse {
        DB::beginTransaction();
        try {
            $offer = Appointment::create($request->all());
            DB::commit();
            return response()->json($offer, 201);
        }
        catch (\Exception $e) {
            DB::rollBack();
            return response()->json("saving appointment failed:" . $e->getMessage(), 420);
        }
    }

    public function update(Request $request, string $id) : JsonResponse
    {
        DB::beginTransaction();
        try {
            $appointment = Appointment::where('id', $id)->first();
                $appointment->update($request->all());
                $appointment->save();
            DB::commit();
            $appointment = Appointment::where('id', $id)->first();
            // return a vaild http response
            return response()->json($appointment, 201);
        }
        catch (\Exception $e) {
            // rollback all queries
            DB::rollBack();
            return response()->json("updating offer failed: " . $e->getMessage(), 420);
        }
    }

    /**
     * returns 200 if appointment deleted successfully, throws excpetion if not
     */
    public function delete(string $id) : JsonResponse
    {
        $appointment = Appointment::where('id', $id)->first();
        if ($appointment != null) {
            $appointment->delete();
        }
        else
            throw new \Exception("appointment couldn't be deleted - it does not exist");
        return response()->json('appointment (' . $id . ') successfully deleted', 200);

    }
}
