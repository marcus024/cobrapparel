<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('order_items', function (Blueprint $table) {
            // Drop foreign key constraint first
            $table->dropForeign(['order_id']); 
            
            // Now drop the column
            $table->dropColumn('order_id'); 
        });
    }

    public function down()
    {
        Schema::table('order_items', function (Blueprint $table) {
            // Re-add the column (if rolling back)
            $table->unsignedBigInteger('order_id')->nullable();

            // Re-add the foreign key constraint
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
        });
    }
};
