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
        Schema::table('candidate_languages', function (Blueprint $table){
            $table->integer('language_level')->default(0)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    : void{
        Schema::table('candidate_languages', function (Blueprint $table){
            $table->integer('language_level')->change();
        });
    }
};
