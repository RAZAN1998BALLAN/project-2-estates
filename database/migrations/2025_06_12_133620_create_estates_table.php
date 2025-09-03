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
        Schema::create('estates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('title');
            $table->string('image');
            $table->string('description',512);
            $table->unsignedInteger('price');
            $table->string('address');
            $table->json('location');
            $table->double('area');
            $table->enum('listing_type',['sale','rent']);
            $table->enum('estate_type',['villa','land','flat','house','other']);
            $table->unsignedInteger('rate')->default(0);
            $table->unsignedInteger('rate_count')->default(0);
            $table->enum('status',['pending','rejected','accepted'])->default('pending');

            // TODO
            $table->unsignedInteger('views')->default(0);

            $table->json('other_data');

            $table->timestamp('closed_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estates');
    }
};
