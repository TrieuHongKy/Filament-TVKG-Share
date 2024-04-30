<?php

namespace Database\Seeders;

use App\Models\Skill;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SkillSeeder extends Seeder{

    /**
     * Run the database seeds.
     */
    public function run()
    : void{
        DB::statement('SET FOREIGN_KEY_CHECKS=0;'); // tắt kiểm tra khóa ngoại

        Skill::truncate();

        $csvFile = fopen(base_path("database/data/skills.csv"), "r");

        $chunkSize = 100;

        $data = [];

        $firstline = TRUE;
        while (($rowData = fgetcsv($csvFile, 2000, ",")) !== FALSE){
            if (!$firstline){
                $data [] = [
                    "name"       => $rowData['1'],
                    "slug"       => Str::slug($rowData['1']),
                    "created_at" => now(),
                    "updated_at" => now()
                ];
            }
            $firstline = FALSE;
        }

        collect($data)->chunk($chunkSize)->each(function ($chunk){
            Skill::insert($chunk->toArray());
        });

        DB::statement('SET FOREIGN_KEY_CHECKS=1;'); // khôi phục kiểm tra khóa ngoại

        fclose($csvFile);
    }
}
