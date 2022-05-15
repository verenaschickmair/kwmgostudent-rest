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

}
