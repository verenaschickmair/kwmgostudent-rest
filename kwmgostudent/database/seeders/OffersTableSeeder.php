<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\Comment;
use App\Models\Offer;
use App\Models\Subject;
use App\Models\User;
use DateTime;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use phpDocumentor\Reflection\Types\Nullable;

class OffersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        {
            $offer = new Offer;
            $offer->name="Angebot für Mathematik";
            $offer->description=Str::random(10);
            $user = User::all()->first();
            $offer->user()->associate($user);
            $subject = Subject::all()->first();
            $offer->subject()->associate($subject);
            $offer->save();

            // add appointments to offer
            $appointment1 = new Appointment;
            $appointment1->date=DateTime::createFromFormat('d/m/Y', '23/05/2013');
            $appointment1->time_from=date('H:i',strtotime('17:00'));
            $appointment1->time_to=date('H:i',strtotime('20:00'));
            $appointment1->user_id=null;

            $appointment2 = new Appointment;
            $appointment2->date=DateTime::createFromFormat('d/m/Y', '24/05/2013');
            $appointment2->time_from=date('H:i',strtotime('19:00'));
            $appointment2->time_to=date('H:i',strtotime('20:00'));
            $appointment2->user_id=null;

            $offer->appointments()->saveMany([$appointment1,$appointment2]);

            $offer->save();
        }
        {
            $offer = new Offer;
            $offer->name="Angebot für Informatik";
            $offer->description=Str::random(10);
            $user = User::find(2);
            $offer->user()->associate($user);
            $subject = Subject::all()->first();
            $offer->subject()->associate($subject);
            $offer->save();

            // add appointments to offer
            $appointment1 = new Appointment;
            $appointment1->date=DateTime::createFromFormat('d/m/Y', '21/05/2013');
            $appointment1->time_from=date('H:i',strtotime('11:00'));
            $appointment1->time_to=date('H:i',strtotime('14:00'));
            $appointment1->user_id=NULL;

            $appointment2 = new Appointment;
            $appointment2->date=DateTime::createFromFormat('d/m/Y', '22/05/2013');
            $appointment2->time_from=date('H:i',strtotime('15:00'));
            $appointment2->time_to=date('H:i',strtotime('18:00'));
            $appointment2->user_id=NULL;
            $offer->appointments()->saveMany([$appointment1,$appointment2]);

            // add comments to offer
            $comment1 = new Comment;
            $comment1->description=Str::random(100);
            $comment1->user_id=2;

            $comment2 = new Comment;
            $comment2->description=Str::random(100);
            $comment2->user_id=1;
            $offer->comments()->saveMany([$comment1,$comment2]);

            $offer->save();
        }
    }
}
