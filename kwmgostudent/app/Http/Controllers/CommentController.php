<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CommentController extends Controller
{
    public function index() : JsonResponse{
        $offers = Comment::all();
        return response()->json($offers, 200);
    }

    public function findAllByOfferId(int $id) : JsonResponse{
        $offers = Comment::where('offer_id', $id)->get();
        return response()->json($offers, 200);
    }

    public function findById(int $id) : Comment {
        return Comment::where('id', $id)->first();
    }

    public function save(Request $request) : JsonResponse {
        DB::beginTransaction();
        try {
            $comment = Comment::create($request->all());
            DB::commit();
            return response()->json($comment, 201);
        }
        catch (\Exception $e) {
            DB::rollBack();
            return response()->json("saving comment failed:" . $e->getMessage(), 420);
        }
    }

    public function update(Request $request, string $id) : JsonResponse
    {
        DB::beginTransaction();
        try {
            $comment = Comment::where('id', $id)->first();
            $comment->update($request->all());
            $comment->save();
            DB::commit();
            $comment = Comment::where('id', $id)->first();
            // return a vaild http response
            return response()->json($comment, 201);
        }
        catch (\Exception $e) {
            // rollback all queries
            DB::rollBack();
            return response()->json("updating comment failed: " . $e->getMessage(), 420);
        }
    }

    public function delete(string $id) : JsonResponse
    {
        $comment = Comment::where('id', $id)->first();
        if ($comment != null) {
            $comment->delete();
        }
        else
            throw new \Exception("comment couldn't be deleted - it does not exist");
        return response()->json('comment (' . $id . ') successfully deleted', 200);

    }

}
