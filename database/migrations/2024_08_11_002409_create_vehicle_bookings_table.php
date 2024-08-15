<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehicleBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicle_bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade')->name('vehiclebookings_user_id_foreign');
            $table->foreignId('vehicle_id')->constrained('vehicles')->onDelete('cascade')->name('vehiclebookings_vehicle_id_foreign');
            $table->string('unit_name')->nullable();
            $table->string('driver_name')->nullable();
            $table->date('departure_date');
            $table->time('departure_time');
            $table->date('return_date')->nullable();
            $table->time('return_time')->nullable();
            $table->string('destination');
            $table->string('purpose');
            $table->string('status')->default('Menunggu Pengesahan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vehicle_bookings');
    }
}

