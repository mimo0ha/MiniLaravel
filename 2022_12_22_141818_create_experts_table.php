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
        Schema::create('experts', function (Blueprint $table) {
            $table->id();
            $table->string('name');//1
            $table->string('email');//2
            $table->string('password');//3
            $table->text('address');//4
            $table->integer('phone')->unique();//5
            //skill_id
            $table->foreignId('skill_id')->constrained('skills')->CascadeOnDelete()-> CascadeOnUpdate();
            $table->text('description');//6
            $table->integer('pocket');//7
            $table->integer('price');//8
            $table->text('photo');//9
            $table->rememberToken();
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
        Schema::dropIfExists('experts');
    }
};
