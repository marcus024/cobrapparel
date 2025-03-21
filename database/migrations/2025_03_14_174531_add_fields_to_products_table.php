<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->json('images')->nullable(); // Store multiple images as JSON
            $table->string('size_chart')->nullable();
            $table->string('custom_number')->nullable(); // Custom number field
            $table->string('custom_name')->nullable(); // Custom name field
        });
    }

    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['images', 'size_chart', 'custom_number', 'custom_name']);
        });
    }
};
