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
        Schema::create('alerts', function (Blueprint $table) {
           $table->id();
           $table->integer('alertId');
           $table->integer('analisId');
           $table->string('alertStatus');
           $table->string('detectionDate');
           $table->string('observation');
           $table->string('region');
           $table->string('province');
           $table->string('auditorStatus')->nullable();
           $table->longText('auditorReason')->nullable();
           $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alerts');
    }
};
