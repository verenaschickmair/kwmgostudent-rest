<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Gives back all users
     */
    public function index() : JsonResponse{
        $users = User::all(['username', 'password', 'firstname', 'lastname', 'course_of_studies',
            'studies_type', 'semester', 'phone', 'email', 'status']);
        return response()->json($users, 200);
    }

    public function findById(int $id) : User {
        return User::where('id', $id)->first();
    }

    /**
     * create new user
     */

    public function save(Request $request) : JsonResponse {
        DB::beginTransaction();
        try {
            $user = User::create($request->all());
            DB::commit();
            return response()->json($user, 201);
        }
        catch (\Exception $e) {
            DB::rollBack();
            return response()->json("saving user failed:" . $e->getMessage(), 420);
        }
    }

    public function update(Request $request, string $id) : JsonResponse
    {
        DB::beginTransaction();
        try {
            $user = User::where('id', $id)->first();
            if ($user != null) {
                $user->update($request->all());
                $user->save();
            }

            DB::commit();
            $user1 = User::where('id', $id)->first();
            // return a vaild http response
            return response()->json($user1, 201);
        }
        catch (\Exception $e) {
            // rollback all queries
            DB::rollBack();
            return response()->json("updating user failed: " . $e->getMessage(), 420);
        }
    }

    /**
     * returns 200 if book deleted successfully, throws excpetion if not
     */
    public function delete(string $id) : JsonResponse
    {
        $user = User::where('id', $id)->first();
        if ($user != null) {
            $user->delete();
        }
        else
            throw new \Exception("user couldn't be deleted - it does not exist");
        return response()->json('user (' . $id . ') successfully deleted', 200);
    }
}
