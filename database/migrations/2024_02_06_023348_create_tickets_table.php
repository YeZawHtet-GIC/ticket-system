<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('text_description');
            $table->longText('file_path_data');
            $table->unsignedBigInteger('created_user_id');
            $table->unsignedBigInteger('priority_id');
            $table->foreign('priority_id')->references('id')->on('priorities')->onDelete('cascade');
            $table->enum('status', [1, 2])->default(2)->comment("0 for open, 1 for closed");
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('created_user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
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
        Schema::dropIfExists('tickets');
    }
}
