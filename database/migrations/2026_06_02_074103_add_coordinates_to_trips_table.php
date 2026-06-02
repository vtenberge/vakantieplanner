<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('trips', function (Blueprint $table) {
            $table->decimal('map_lat', 10, 7)->nullable()->after('cover');
            $table->decimal('map_lng', 10, 7)->nullable()->after('map_lat');
            $table->unsignedTinyInteger('map_zoom')->default(13)->after('map_lng');
        });
    }

    public function down(): void
    {
        Schema::table('trips', function (Blueprint $table) {
            $table->dropColumn(['map_lat', 'map_lng', 'map_zoom']);
        });
    }
};
