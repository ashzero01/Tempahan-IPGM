<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehiclesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Vehicle name or model
            $table->string('registration_number')->unique(); // Vehicle registration number
            $table->string('type'); // Type of vehicle (e.g., car, van, bus)
            $table->string('image')->nullable(); // Add image attribute to store the vehicle image
            $table->string('status')->default('Available'); // Vehicle status (e.g., Available, In Use, Maintenance)
            $table->text('description')->nullable(); // Description of the vehicle
            $table->timestamps(); // Timestamps for created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vehicles');
    }
}
