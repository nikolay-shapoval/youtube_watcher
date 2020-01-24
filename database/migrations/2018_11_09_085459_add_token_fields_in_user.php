<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTokenFieldsInUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function ($table) {
            $table->string('access_token')->nullable();
            $table->string('expires_in')->nullable();
            $table->string('token_scope')->nullable();
            $table->string('token_type')->nullable();
            $table->text('id_token')->nullable();
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
            $table->dropColumn('access_token');
            $table->dropColumn('expires_in');
            $table->dropColumn('token_scope');
            $table->dropColumn('token_type');
            $table->dropColumn('id_token');
        });
    }
}
