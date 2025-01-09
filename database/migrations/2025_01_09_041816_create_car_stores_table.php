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
        Schema::create('car_stores', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('thumbnail');
            $table->boolean('is_open')->default(false);
            $table->boolean('is_full')->default(false);
            // apabila field = nama model. table 'city' dan gunakan 'id'
            $table->foreignId('city_id')->constrained()->cascadeOnDelete();
            $table->text('address');
            $table->string('phone_number');
            $table->string('cs_name');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('car_stores');
    }
};
