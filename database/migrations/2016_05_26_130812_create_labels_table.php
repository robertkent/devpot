<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLabelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        print "Migrating: " . (new ReflectionClass($this))->getFileName() . " ";
        
        Schema::create('labels', function(Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->text('description');
            $table->integer('project_id')->unsigned();
            $table->foreign('project_id')
                ->references('id')
                ->on('projects')
                ->onDelete('CASCADE')
                ->onUpdate('CASCADE');
            $table->timestamps();
            $table->unique(['name', 'project_id']);
        });

        print "[SUCCESS]" . PHP_EOL;
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('labels');
    }
}
