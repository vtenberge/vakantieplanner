<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('day_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('trip_day_id')->constrained('trip_days')->cascadeOnDelete();
            $table->string('time', 10)->nullable();
            $table->string('title');
            $table->string('kind')->default('place'); // flight | food | transit | place
            $table->foreignId('added_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('day_items');
    }
};
