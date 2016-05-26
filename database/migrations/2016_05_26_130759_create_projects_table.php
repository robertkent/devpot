<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        echo "Migrating: " . (new ReflectionClass($this))->getFileName() . " ";

        Schema::create('projects', function(Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->text('description');
            $table->integer('owner_id')->unsigned()->nullable()->default(null);
            $table->foreign('owner_id')
                ->references('id')
                ->on('users')
                ->onDelete('RESTRICT')
                ->onUpdate('CASCADE');
            $table->timestamps();
            $table->softDeletes();
            $table->unique(['name', 'owner_id']);
        });

        Schema::create('project_collaborators', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('project_id')->unsigned();
            $table->foreign('project_id')
                ->references('id')
                ->on('projects')
                ->onDelete('CASCADE')
                ->onUpdate('CASCADE');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('RESTRICT')
                ->onUpdate('CASCADE');
            $table->timestamps();
            $table->softDeletes();
            $table->unique(['project_id', 'user_id']);
        });

        echo "[SUCCESS]" . PHP_EOL;
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('projects');
        Schema::drop('project_collaborators');
    }
}
