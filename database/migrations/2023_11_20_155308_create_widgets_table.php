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
        Schema::create('widgets', function (Blueprint $table){
            $table->id();
            $table->string('key', 255)->unique()->required();
            $table->string('title', 255)->required();
            $table->string('slug');
            $table->string('image', 255)->nullable();
            $table->string('link', 255)->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    : void{
        Schema::dropIfExists('widgets');
    }
};
