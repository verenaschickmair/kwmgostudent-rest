<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use App\Models\Subject;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function index() : JsonResponse{
        $subjects = Subject::all(['id', 'lva', 'name', 'description']);
        return response()->json($subjects, 200);
    }

}
