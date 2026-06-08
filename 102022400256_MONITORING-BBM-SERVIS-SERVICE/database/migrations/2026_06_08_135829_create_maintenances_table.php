<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
       Schema::create('maintenances', function (Blueprint $table) {
        $table->id();

        $table->string('vehicle_id');
        $table->decimal('fuel_limit', 12, 2);
        $table->date('last_service_date');
        $table->string('operational_coupon')->nullable();
        $table->text('notes')->nullable();

        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maintenances');
    }
};
