<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFollowUpDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('follow_up_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('follow_up_id')->unsigned();
            $table->foreign('follow_up_id')
                    ->references('id')->on('follow_ups')
                    ->onDelete('cascade');
            $table->string('method');
            $table->text('reason');
            $table->text('pre_meeting_notes');
            $table->text('post_meeting_notes');
            $table->date('date');
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
        Schema::drop('follow_up_details');
    }
}
