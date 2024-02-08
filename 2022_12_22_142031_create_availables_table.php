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
        Schema::create('availables', function (Blueprint $table) {
            $table->id();
            $table->foreignId('expert_id')->constrained('experts')->CascadeOnDelete()-> CascadeOnUpdate();
            $table->foreignId('day_id')->constrained('days')->CascadeOnDelete()-> CascadeOnUpdate();
            $table->integer('from');
            $table->integer('to');
            $table->boolean('full')->default(false);
            $table->integer('hour');
            $table->integer('session');
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
        Schema::dropIfExists('availables');
    }
};
