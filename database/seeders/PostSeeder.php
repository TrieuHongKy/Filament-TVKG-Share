<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PostSeeder extends Seeder{

    /**
     * Run the database seeds.
     */
    public function run()
    : void{
        DB::statement('SET FOREIGN_KEY_CHECKS=0;'); // tắt kiểm tra khóa ngoại

        Post::truncate();

        $csvFile = fopen(base_path("database/data/posts.csv"), "r");

        $firstline = TRUE;
        while (($data = fgetcsv($csvFile, 2000, ",")) !== FALSE){
            if (!$firstline){
                Post::create([
                    "title"        => $data['0'],
                    "slug"         => Str::slug($data['0']),
                    "content"      => $data['1'],
                    "image"        => $data['2'],
                    "published_at" => $data['3'],
                    "user_id"      => $data['4'],
                    "category_id"  => $data['5']
                ]);
            }
            $firstline = FALSE;
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1;'); // khôi phục kiểm tra khóa ngoại

        fclose($csvFile);
    }
}
