<?php

namespace Database\Seeders;

use App\Models\Ward;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class WardSeeder extends Seeder{

    /**
     * Run the database seeds.
     */
    public function run()
    : void{
        DB::statement('SET FOREIGN_KEY_CHECKS=0;'); // tắt kiểm tra khóa ngoại

        Ward::truncate();

        $csvFile = fopen(base_path("database/data/wards.csv"), "r");

        $chunkSize = 10000;

        $data = [];

        $firstline = TRUE;
        while (($rowData = fgetcsv($csvFile, 10000, ",")) !== FALSE){
            if (!$firstline){
                $data [] = [
                    "id"          => $rowData['1'],
                    "name"        => $rowData['2'],
                    "slug"        => Str::slug($rowData['2']),
                    "district_id" => $rowData['3']
                ];
            }
            $firstline = FALSE;
        }

        collect($data)->chunk($chunkSize)->each(function ($chunk){
            Ward::insert($chunk->toArray());
        });

        DB::statement('SET FOREIGN_KEY_CHECKS=1;'); // khôi phục kiểm tra khóa ngoại

        fclose($csvFile);
    }
}
