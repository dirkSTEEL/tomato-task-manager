<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_tasks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('project_id'); 
            $table->integer('absolute_day');
            $table->string('name', 45);
            $table->unsignedBigInteger('story_id')->nullable();

            // Indexes
            $table->foreign('project_id', 'fk_project_id_idx')->references('id')->on('projects')->onDelete('cascade');
            $table->foreign('story_id', 'fk_story_id_idx')->references('id')->on('stories')->onDelete('cascade');
            $table->unique(['project_id', 'absolute_day'], 'un_project_id_day');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('project_tasks');
    }
}
