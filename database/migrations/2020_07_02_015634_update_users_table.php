<?php

use App\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class UpdateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // //
        Schema::table('users', function (Blueprint $table) {
            $table->string('token')->unique()->nullable(false);
        });
        // DB::table('users')->update(['token' => 'users.remember_token']);
        // User::all()->foreach(function())update('token', 'remember_token');
      
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('token');
        });
    }
}
