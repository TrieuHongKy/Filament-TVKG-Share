<?php

namespace Database\Seeders;

use App\Models\CompanyAddress;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompanyAddressSeeder extends Seeder{

    /**
     * Run the database seeds.
     */
    public function run()
    : void{
        DB::statement('SET FOREIGN_KEY_CHECKS=0;'); // tắt kiểm tra khóa ngoại

        CompanyAddress::truncate();

        $csvFile = fopen(base_path("database/data/company_addresses.csv"), "r");

        $firstline = TRUE;
        while (($data = fgetcsv($csvFile, 2000, ",")) !== FALSE){
            if (!$firstline){
                CompanyAddress::create([
                    "company_id"  => $data['0'],
                    "province_id" => $data['1'],
                    "district_id" => $data['2'],
                    "ward_id"     => $data['3']
                ]);
            }
            $firstline = FALSE;
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1;'); // khôi phục kiểm tra khóa ngoại

        fclose($csvFile);
    }
}
