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
        Schema::table('candidate_addresses', function (Blueprint $table){
            $table->unsignedBigInteger('candidate_id')->after('id');

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
        Schema::table('candidate_addresses', function (Blueprint $table){
            $table->dropConstrainedForeignId('candidate_id');
        });
    }
};
