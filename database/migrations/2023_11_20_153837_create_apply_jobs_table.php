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
        Schema::create('apply_jobs', function (Blueprint $table){
            $table->id();
            $table->unsignedBigInteger('job_id');
            $table->unsignedBigInteger('candidate_id');
            $table->timestamps();
            $table->foreign('job_id')->references('id')->on('jobs')->onDelete('cascade');
            $table->foreign('candidate_id')
                  ->references('id')
                  ->on('candidates')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    : void{
        Schema::dropIfExists('apply_jobs');
    }
};
