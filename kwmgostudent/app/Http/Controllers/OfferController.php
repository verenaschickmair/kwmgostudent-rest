<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
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
        $offers = Offer::with(['appointments', 'comments'])->get();
        return response()->json($offers, 200);
    }

    public function findAllBySubjectId(int $id) : JsonResponse{
        $offers = Offer::where('subject_id', $id)
            ->with(['appointments', 'comments'])
            ->get();
        return response()->json($offers, 200);
    }

    public function findById(int $id) : Offer {
        return Offer::where('id', $id)
            ->with(['appointments', 'comments'])
            ->first();
    }

    public function findAllByUserId(int $user_id) : JsonResponse{
        $offers = Offer::with(['appointments', 'comments'])
            ->where('user_id', $user_id)
            ->get();
        return response()->json($offers, 200);
    }

    /**
     * create new offer
     */

    public function save(Request $request) : JsonResponse {
        DB::beginTransaction();
        try {
            $offer = Offer::create($request->all());
            DB::commit();

            //save appointments
            if (isset($request['appointments']) && is_array($request['appointments'])) {
                foreach ($request['appointments'] as $app) {
                    $date = $this->parseDate($app['date']);
                    $timeArr = $this->parseTime($app['time_from'], $app['time_to']);
                    $appointment = Appointment::firstOrNew(
                        [
                            'date'=>$date,'time_from'=>$timeArr[0],
                            'time_to'=>$timeArr[1]
                        ]);
                    $offer->appointments()->save($appointment);
                }
            }
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
            $offer = Offer::with(['appointments', 'user', 'subject'])
                ->where('id', $id)->first();

            if ($offer != null) {
                //delete all old appointments
                $offer->appointments()->delete();
                // save appointments
                if (isset($request['appointments']) && is_array($request['appointments'])) {
                    foreach ($request['appointments'] as $app) {
                        $date = $this->parseDate($app['date']);
                        $timeArr = $this->parseTime($app['time_from'], $app['time_to']);
                        $appointment = Appointment::firstOrNew(
                            [
                                'date'=>$date,'time_from'=>$timeArr[0],
                                'time_to'=>$timeArr[1]
                            ]);
                        $offer->appointments()->save($appointment);
                    }
                }
                $offer->update($request->all());
                $offer->save();
            }

            DB::commit();
            $offer = Offer::with(['appointments', 'subject', 'user'])
                ->where('id', $id)->first();
            // return a vaild http response
            return response()->json($offer, 201);
        }
        catch (\Exception $e) {
            // rollback all queries
            DB::rollBack();
            return response()->json("updating offer failed: " . $e->getMessage(), 420);
        }
    }

    /**
     * returns 200 if offer deleted successfully, throws excpetion if not
     */
    public function delete(string $id) : JsonResponse
    {
        $offer = Offer::where('id', $id)->first();
        if ($offer != null) {
            $offer->delete();
        }
        else
            throw new \Exception("student couldn't be deleted - it does not exist");
        return response()->json('offer (' . $id . ') successfully deleted', 200);

    }

    private function parseDate(string $date) : \DateTime {
        return new \DateTime($date);
    }

    private function parseTime(string $time_from, string $time_to) : array {
        $time_from = new \DateTime($time_from);
        $time_to = new \DateTime($time_to);
        return [$time_from->format("H:i"), $time_to->format("H:i")];
    }
}
