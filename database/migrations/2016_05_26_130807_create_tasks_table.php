<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        echo "Migrating: " . (new ReflectionClass($this))->getFileName() . " ";

        Schema::create('tasks', function(Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->text('description');
            $table->integer('project_id')->unsigned();
            $table->foreign('project_id')
                ->references('id')
                ->on('projects')
                ->onDelete('CASCADE')
                ->onUpdate('CASCADE');
            $table->integer('assigned_to')->unsigned()->nullable()->default(null);
            $table->foreign('assigned_to')
                ->references('id')
                ->on('users')
                ->onDelete('RESTRICT')
                ->onUpdate('CASCADE');
            $table->timestamp('originally_expected_at')->nullable()->default(null);
            $table->timestamp('expected_at')->nullable()->default(null);
            $table->timestamps();
            $table->softDeletes();
            $table->unique(['name', 'project_id']);
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
        Schema::drop('tasks');
    }
}
