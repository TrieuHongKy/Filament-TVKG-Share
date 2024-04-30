<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder{

    /**
     * Run the database seeds.
     */
    public function run()
    : void{
        DB::statement('SET FOREIGN_KEY_CHECKS=0;'); // tắt kiểm tra khóa ngoại

        Category::truncate();

        $csvFile = fopen(base_path("database/data/categories.csv"), "r");

        $firstline = TRUE;
        while (($data = fgetcsv($csvFile, 2000, ",")) !== FALSE){
            if (!$firstline){
                $parent_id = empty($data['4']) ? NULL : $data['4'];
                Category::create([
                    "name"        => $data['1'],
                    "slug"        => Str::slug($data['1']),
                    "description" => $data['3'],
                    "parent_id"   => $parent_id,
                    "image"       => $data['5'],
                    "status"      => $data['6'] === 'FALSE'
                ]);
            }
            $firstline = FALSE;
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1;'); // khôi phục kiểm tra khóa ngoại

        fclose($csvFile);
    }
}
