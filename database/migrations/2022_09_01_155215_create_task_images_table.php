<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('task_images', function (Blueprint $table) {
            $table->id();
            $table->string('iiif_url')->unique();
            $table->integer('task_user_id')->nullable();
            $table->timestamp('task_open')->nullable();
            $table->timestamp('task_close')->nullable();
            $table->timestamp('task_expire')->nullable();
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
        Schema::dropIfExists('task_images');
    }
};
