<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAuthorisationFieldsToUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function ($table) {
            $table->string('state')->nullable();
            $table->string('code')->nullable();
            $table->string('scope')->nullable();
            $table->string('authuser')->nullable();
            $table->string('session_state')->nullable();
            $table->string('promt')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('state');
            $table->dropColumn('code');
            $table->dropColumn('scope');
            $table->dropColumn('authuser');
            $table->dropColumn('session_state');
            $table->dropColumn('promt');
        });
    }
}
