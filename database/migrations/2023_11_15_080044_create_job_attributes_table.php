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
        Schema::create('job_attributes', function (Blueprint $table){
            $table->id();
            $table->foreignId('job_id')->constrained()->cascadeOnDelete();
            $table->boolean('is_active')->default(TRUE);
            $table->boolean('is_featured')->default(FALSE);
            $table->boolean('is_published')->default(FALSE);
            $table->timestamp('published_at')->nullable();
            $table->timestamp('expired_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    : void{
        Schema::dropIfExists('job_attributes');
    }
};
