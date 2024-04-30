<?php

namespace Database\Seeders;

use App\Models\JobRequirement;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JobRequirementSeeder extends Seeder{

    /**
     * Run the database seeds.
     */
    public function run()
    : void{
        DB::statement('SET FOREIGN_KEY_CHECKS=0;'); // tắt kiểm tra khóa ngoại

        JobRequirement::truncate();

        $csvFile = fopen(base_path("database/data/job_requirements.csv"), "r");

        $firstline = TRUE;
        while (($data = fgetcsv($csvFile, 2000, ",")) !== FALSE){
            if (!$firstline){
                JobRequirement::create([
                    "job_id"        => $data['0'],
                    "major_id"      => $data['1'],
                    "degree_id"     => $data['2'],
                    "experience_id" => $data['3']
                ]);
            }
            $firstline = FALSE;
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1;'); // khôi phục kiểm tra khóa ngoại

        fclose($csvFile);
    }
}
