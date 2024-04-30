<?php

namespace Database\Seeders;

use App\Models\CompanyTracking;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompanyTrackingSeeder extends Seeder{

    /**
     * Run the database seeds.
     */
    public function run()
    : void{
        DB::statement('SET FOREIGN_KEY_CHECKS=0;'); // tắt kiểm tra khóa ngoại

        CompanyTracking::truncate();

        $csvFile = fopen(base_path("database/data/company_trackings.csv"), "r");

        $firstline = TRUE;
        while (($data = fgetcsv($csvFile, 2000, ",")) !== FALSE){
            if (!$firstline){
                CompanyTracking::create([
                    "company_id"    => $data['0'],
                    "follower_id"   => $data['1'],
                    "tracking_date" => $data['2']
                ]);
            }
            $firstline = FALSE;
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1;'); // khôi phục kiểm tra khóa ngoại

        fclose($csvFile);
    }
}
