<?php

namespace Database\Seeders;

use App\Models\Education;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EducationSeeder extends Seeder{

    /**
     * Run the database seeds.
     */
    public function run()
    : void{
        DB::statement('SET FOREIGN_KEY_CHECKS=0;'); // tắt kiểm tra khóa ngoại

        Education::truncate();

        $csvFile = fopen(base_path("database/data/educations.csv"), "r");

        $firstline = TRUE;
        while (($data = fgetcsv($csvFile, 2000, ",")) !== FALSE){
            if (!$firstline){
                Education::create([
                    "education_name" => $data['0'],
                    "description"    => $data['1'],
                    "start_date"     => $data['2'],
                    "end_date"       => $data['3'],
                    "major"          => $data['4'],
                    "institution"    => $data['5'],
                    "city"           => $data['6'],
                    "country"        => $data['7']
                ]);
            }
            $firstline = FALSE;
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1;'); // khôi phục kiểm tra khóa ngoại

        fclose($csvFile);
    }
}
