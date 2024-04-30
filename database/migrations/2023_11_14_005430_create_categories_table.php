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
        Schema::create('categories', function (Blueprint $table){
            $table->id();
            $table->string('name', 255)->unique();
            $table->string('slug');
            $table->text('description')->nullable();
            $table->foreignId('parent_id')
                  ->nullable()
                  ->constrained('categories')
                  ->onDelete('cascade');
            $table->string('image')->nullable();
            $table->boolean('status')->default(FALSE);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    : void{
        Schema::dropIfExists('categories');
    }
};
