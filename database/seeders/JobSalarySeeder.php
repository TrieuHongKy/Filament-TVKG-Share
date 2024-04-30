<?php

namespace Database\Seeders;

use App\Models\JobSalary;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JobSalarySeeder extends Seeder{

    /**
     * Run the database seeds.
     */
    public function run()
    : void{
        DB::statement('SET FOREIGN_KEY_CHECKS=0;'); // tắt kiểm tra khóa ngoại

        JobSalary::truncate();

        $csvFile = fopen(base_path("database/data/job_salaries.csv"), "r");

        $firstline = TRUE;
        while (($data = fgetcsv($csvFile, 2000, ",")) !== FALSE){
            if (!$firstline){
                JobSalary::create([
                    "job_id"       => $data['0'],
                    "min_salary"   => $data['1'] * 1000000,
                    "max_salary"   => $data['2'] * 1000000,
                    "fixed_salary" => $data['3'] * 1000000
                ]);
            }
            $firstline = FALSE;
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1;'); // khôi phục kiểm tra khóa ngoại

        fclose($csvFile);
    }
}
