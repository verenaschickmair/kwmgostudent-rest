<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index() : JsonResponse{
        $offers = Comment::all(['id', 'date', 'time_from', 'time_to']);
        return response()->json($offers, 200);
    }

    public function getAllByOfferId(int $id) : JsonResponse{
        $offers = Comment::where('offer_id', $id)->get();
        return response()->json($offers, 200);
    }
}
