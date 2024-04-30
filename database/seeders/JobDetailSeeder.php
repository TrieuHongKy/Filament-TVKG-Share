<?php

namespace Database\Seeders;

use App\Models\JobDetail;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class JobDetailSeeder extends Seeder{

    /**
     * Run the database seeds.
     */
    public function run()
    : void{
        DB::statement('SET FOREIGN_KEY_CHECKS=0;'); // tắt kiểm tra khóa ngoại

        JobDetail::truncate();

        $csvFile = fopen(base_path("database/data/job_details.csv"), "r");

        $firstline = TRUE;
        while (($data = fgetcsv($csvFile, 2000, ",")) !== FALSE){
            if (!$firstline){
                JobDetail::create([
                    "job_id"      => $data['0'],
                    "title"       => $data['1'],
                    "slug"        => Str::slug($data['1']),
                    "description" => $data['2'],
                    "address"     => $data['3']
                ]);
            }
            $firstline = FALSE;
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1;'); // khôi phục kiểm tra khóa ngoại

        fclose($csvFile);
    }
}
