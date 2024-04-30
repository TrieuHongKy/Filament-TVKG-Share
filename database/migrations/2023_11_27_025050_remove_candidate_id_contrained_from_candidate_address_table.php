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
            $table->dropConstrainedForeignId('candidate_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    : void{
        Schema::disableForeignKeyConstraints();
        Schema::table('candidate_addresses', function (Blueprint $table){
            if (!Schema::hasColumn('candidate_addresses', 'candidate_id')){
                $table->foreignId('candidate_id')
                      ->constrained();
            }
        });
        Schema::enableForeignKeyConstraints();
    }
};
