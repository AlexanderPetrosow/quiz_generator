<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUniqueKeyToQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('questions', function (Blueprint $table) {
            $table->string('unique_key', 10)->unique()->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('questions', function (Blueprint $table) {
            $table->dropColumn('unique_key');
        });
    }
}
