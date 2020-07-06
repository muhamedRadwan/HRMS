<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLivingrequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('livingrequests', function (Blueprint $table) {
            $table->id();
            $table->date('approved_in');
            $table->unsignedBigInteger("approver_id");
            $table->foreign("approver_id")->references("id")->on("users")->delete("cascade");
            $table->unsignedBigInteger("creator_id");
            $table->foreign("creator_id")->references("id")->on("users")->delete("cascade");
            $table->integer("status")->default(0);
            $table->string("reason")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('livingrequests');
    }
}
