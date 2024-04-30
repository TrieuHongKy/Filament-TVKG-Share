<?php

namespace Database\Seeders;

use App\Models\Job;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JobSeeder extends Seeder{

    /**
     * Run the database seeds.
     */
    public function run()
    : void{
        DB::statement('SET FOREIGN_KEY_CHECKS=0;'); // tắt kiểm tra khóa ngoại

        Job::truncate();

        $csvFile = fopen(base_path("database/data/jobs.csv"), "r");

        $chunkSize = 100;

        $data = [];

        $firstline = TRUE;
        while (($rowData = fgetcsv($csvFile, 2000, ",")) !== FALSE){
            if (!$firstline){
                $data[] = [
                    "company_id"    => $rowData['0'],
                    "category_id"   => $rowData['1'],
                    "province_id"   => $rowData['2'],
                    "district_id"   => $rowData['3'],
                    "ward_id"       => $rowData['4'],
                    "job_type_id"   => $rowData['5'],
                    "job_status_id" => $rowData['6'],
                    "created_at"    => $rowData['7'],
                    "updated_at"    => $rowData['7'],
                ];
            }
            $firstline = FALSE;
        }

        collect($data)->chunk($chunkSize)->each(function ($chunk){
            Job::insert($chunk->toArray());
        });

        DB::statement('SET FOREIGN_KEY_CHECKS=1;'); // khôi phục kiểm tra khóa ngoại

        fclose($csvFile);
    }
}
