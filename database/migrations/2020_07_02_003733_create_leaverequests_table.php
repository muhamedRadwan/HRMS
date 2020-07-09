<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeaverequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leave_requests', function (Blueprint $table) {
            $table->id();
            $table->date('approved_at')->nullable();
            $table->unsignedBigInteger("approver_id")->nullable();
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
        Schema::dropIfExists('leaverequests');
    }
}
