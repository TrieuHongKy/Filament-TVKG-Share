<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CompanySeeder extends Seeder{

    /**
     * Run the database seeds.
     */
    public function run()
    : void{
        DB::statement('SET FOREIGN_KEY_CHECKS=0;'); // tắt kiểm tra khóa ngoại

        Company::truncate();

        $csvFile = fopen(base_path("database/data/companies.csv"), "r");

        $chunkSize = 120;

        $data = [];

        $firstline = TRUE;
        while (($rowData = fgetcsv($csvFile, 2000, ",")) !== FALSE){
            if (!$firstline){
                $data[] = [
                    "user_id"             => $rowData['0'],
                    "company_name"        => $rowData['1'],
                    "slug"                => Str::slug($rowData['1']),
                    "company_logo"        => $rowData['3'],
                    "company_address"     => $rowData['10'],
                    "tax_code"            => $rowData['11'],
                    "banner"              => $rowData['4'],
                    "company_description" => $rowData['5'],
                    "website"             => $rowData['6'],
                    "company_size"        => $rowData['7'],
                    "company_type"        => $rowData['8'],
                    "company_industry"    => $rowData['9'],
                    "created_at"          => $rowData['12'],
                    "updated_at"          => $rowData['12']
                ];
            }
            $firstline = FALSE;
        }

        collect($data)->chunk($chunkSize)->each(function ($chunk){
            Company::insert($chunk->toArray());
        });

        DB::statement('SET FOREIGN_KEY_CHECKS=1;'); // khôi phục kiểm tra khóa ngoại

        fclose($csvFile);
    }
}
