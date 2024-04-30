<?php

namespace Database\Seeders;

use App\Models\ApplyJob;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ApplyJobSeeder extends Seeder{

    /**
     * Run the database seeds.
     */
    public function run()
    : void{
        DB::statement('SET FOREIGN_KEY_CHECKS=0;'); // tắt kiểm tra khóa ngoại

        ApplyJob::truncate();

        $csvFile = fopen(base_path("database/data/apply_jobs.csv"), "r");

        $firstline = TRUE;
        while (($data = fgetcsv($csvFile, 2000, ",")) !== FALSE){
            if (!$firstline){
                ApplyJob::create([
                    "job_id"       => $data['1'],
                    "candidate_id" => $data['2'],
                    "created_at"   => $data['3'],
                    "updated_at"   => $data['3']
                ]);
            }
            $firstline = FALSE;
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1;'); // khôi phục kiểm tra khóa ngoại

        fclose($csvFile);
    }
}
