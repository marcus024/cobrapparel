<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('shops', function (Blueprint $table) {
            $table->string('contact_name')->after('owner');
            $table->string('contact_number')->after('contact_name');
            $table->integer('duration')->after('contact_number')->comment('Duration in months');
        });
    }

    public function down()
    {
        Schema::table('shops', function (Blueprint $table) {
            $table->dropColumn(['contact_name', 'contact_number', 'duration']);
        });
    }
};
