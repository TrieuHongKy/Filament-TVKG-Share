<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration{

    /**
     * Run the migrations.
     */
    public function up()
    : void{
        Schema::create('education_degrees', function (Blueprint $table){
            $table->id();
            $table->unsignedBigInteger('education_id');
            $table->unsignedBigInteger('degree_id');
            $table->timestamps();

            $table->foreign('education_id')
                  ->references('id')
                  ->on('educations')
                  ->onDelete('cascade');
            $table->foreign('degree_id')->references('id')->on('degrees')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    : void{
        Schema::dropIfExists('education_degrees');
    }
};
