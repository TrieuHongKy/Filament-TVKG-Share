<?php

namespace Database\Seeders;

use App\Models\Candidate;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CandidateSeeder extends Seeder{

    /**
     * Run the database seeds.
     */
    public function run()
    : void{
        DB::statement('SET FOREIGN_KEY_CHECKS=0;'); // tắt kiểm tra khóa ngoại

        Candidate::truncate();

        $csvFile = fopen(base_path("database/data/candidates.csv"), "r");

        $chunkSize = 120;

        $data = [];

        $firstline = TRUE;
        while (($rowData = fgetcsv($csvFile, 2000, ",")) !== FALSE){
            if (!$firstline){
                $data[] = [
                    "user_id"    => $rowData['0'],
                    "major_id"   => $rowData['1'],
                    "resume_id"  => $rowData['2'],
                    "major_name" => $rowData['3'],
                    "created_at" => $rowData['4'],
                    "updated_at" => $rowData['4']
                ];
            }
            $firstline = FALSE;
        }

        collect($data)->chunk($chunkSize)->each(function ($chunk){
            Candidate::insert($chunk->toArray());
        });

        DB::statement('SET FOREIGN_KEY_CHECKS=1;'); // khôi phục kiểm tra khóa ngoại

        fclose($csvFile);
    }
}
