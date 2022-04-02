<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppointmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->time('time');

            $table->foreignId('subject')
                ->constrained()
                ->onDelete('cascade');

            //fk user constraint -> neue Laravel 8 Schreibweise
            $table->foreignId('student_provider')
                ->constrained()
                ->onDelete('cascade');

            $table->foreignId('student_seeker')
                ->constrained()
                ->onDelete('cascade');

            $table->timestamps();
            $table->primary(['provider_id', 'seeker_id', 'date', 'time']);
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('appointments');
    }
}
