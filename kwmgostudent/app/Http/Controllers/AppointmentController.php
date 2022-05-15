<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function index() : JsonResponse{
        $offers = Appointment::all(['id', 'date', 'time_from', 'time_to']);
        return response()->json($offers, 200);
    }

    public function getAllByOfferId(int $id) : JsonResponse{
        $offers = Appointment::where('offer_id', $id)->get();
        return response()->json($offers, 200);
    }
}
