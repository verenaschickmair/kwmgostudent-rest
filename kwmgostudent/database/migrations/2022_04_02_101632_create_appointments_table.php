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
            $table->date('date');
            $table->time('time');

            $table->foreignId('provider_id')
                ->constrained('students')
                ->onDelete('cascade');

            $table->foreignId('seeker_id')
                ->constrained('students')
                ->onDelete('cascade');

            $table->foreignId('subject_id')
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
