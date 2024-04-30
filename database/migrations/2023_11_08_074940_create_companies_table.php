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
        Schema::create('companies', function (Blueprint $table){
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('company_name', 255);
            $table->string('slug');
            $table->string('company_logo', 255);
            $table->string('company_adress', 255);
            $table->string('tax_code', 13)->unique();
            $table->string('banner', 255)->nullable();
            $table->text('company_description')->nullable();
            $table->string('website')->nullable();
            $table->integer('company_size')->nullable();
            $table->string('company_type')->nullable();
            $table->string('company_industry')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    : void{
        Schema::dropIfExists('companies');
    }
};
