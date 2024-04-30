<?php

namespace Database\Seeders;

use App\Models\CandidateLanguage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CandidateLanguageSeeder extends Seeder{

    /**
     * Run the database seeds.
     */
    public function run()
    : void{
        DB::statement('SET FOREIGN_KEY_CHECKS=0;'); // tắt kiểm tra khóa ngoại

        CandidateLanguage::truncate();

        $csvFile = fopen(base_path("database/data/candidate_languages.csv"), "r");

        $firstline = TRUE;
        while (($data = fgetcsv($csvFile, 2000, ",")) !== FALSE){
            if (!$firstline){
                CandidateLanguage::create([
                    "candidate_id"   => $data['0'],
                    "language_id"    => $data['1'],
                    "language_level" => $data['2']
                ]);
            }
            $firstline = FALSE;
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1;'); // khôi phục kiểm tra khóa ngoại

        fclose($csvFile);
    }
}
