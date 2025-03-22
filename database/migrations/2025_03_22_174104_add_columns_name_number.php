<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('order_items', function (Blueprint $table) {
            $table->string('custom_name')->nullable(); // Add custom_name
            $table->string('custom_number')->nullable()->after('custom_name'); // Add custom_number
        });
    }

    public function down()
    {
        Schema::table('order_items', function (Blueprint $table) {
            $table->dropColumn(['custom_name', 'custom_number']);
        });
    }
};

