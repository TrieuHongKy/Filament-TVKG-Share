<?php

namespace Database\Seeders;

use App\Models\JobAttribute;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JobAttributeSeeder extends Seeder{

    /**
     * Run the database seeds.
     */
    public function run()
    : void{
        DB::statement('SET FOREIGN_KEY_CHECKS=0;'); // tắt kiểm tra khóa ngoại

        JobAttribute::truncate();

        $csvFile = fopen(base_path("database/data/job_attributes.csv"), "r");

        $firstline = TRUE;
        while (($data = fgetcsv($csvFile, 2000, ",")) !== FALSE){
            if (!$firstline){
                JobAttribute::create([
                    "job_id"       => $data['0'],
                    "is_active"    => $data['1'] === 'TRUE',
                    "is_featured"  => $data['2'] === 'TRUE',
                    "is_published" => $data['3'] === 'TRUE',
                    "published_at" => $data['4'],
                    "expired_at" => $data['5']
                ]);
            }
            $firstline = FALSE;
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1;'); // khôi phục kiểm tra khóa ngoại

        fclose($csvFile);
    }
}
