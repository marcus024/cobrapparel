<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropUnique(['order_id']); // Remove unique constraint
        });
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->unique('order_id'); // Restore unique constraint on rollback
        });
    }
};

