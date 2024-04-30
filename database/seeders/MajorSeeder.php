<?php

namespace Database\Seeders;

use App\Models\Major;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class MajorSeeder extends Seeder{

    /**
     * Run the database seeds.
     */
    public function run()
    : void{
        DB::statement('SET FOREIGN_KEY_CHECKS=0;'); // tắt kiểm tra khóa ngoại

        Major::truncate();

        $csvFile = fopen(base_path("database/data/majors.csv"), "r");

        $chunkSize = 200;

        $data = [];

        $firstline = TRUE;
        while (($rowData = fgetcsv($csvFile, 2000, ",")) !== FALSE){
            if (!$firstline){
                $data [] = [
                    "name"       => $rowData['1'],
                    "short_name" => $rowData['3'],
                    "slug"       => Str::slug($rowData['1']),
                    "created_at" => now(),
                    "updated_at" => now()
                ];
            }
            $firstline = FALSE;
        }

        collect($data)->chunk($chunkSize)->each(function ($chunk){
            Major::insert($chunk->toArray());
        });

        DB::statement('SET FOREIGN_KEY_CHECKS=1;'); // khôi phục kiểm tra khóa ngoại

        fclose($csvFile);
    }
}
