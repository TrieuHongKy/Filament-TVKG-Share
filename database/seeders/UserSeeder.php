<?php

namespace Database\Seeders;

use App\Enums\UserType;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder{

    /**
     * Run the database seeds.
     */
    public function run()
    : void{
        DB::statement('SET FOREIGN_KEY_CHECKS=0;'); // tắt kiểm tra khóa ngoại

        User::truncate();

        $csvFile = fopen(base_path("database/data/users.csv"), "r");

        $chunkSize           = 200;

        $data = [];

        $firstline = TRUE;
        while (($rowData = fgetcsv($csvFile, 2000, ",")) !== FALSE){
            if (!$firstline){
                if (isset($rowData[1], $rowData[2], $rowData[3], $rowData[4], $rowData[5], $rowData[6], $rowData[7], $rowData[8], $rowData[9])){
                    $user_type         = $rowData['8'] ? UserType::from($rowData['8']) : UserType::Candidate;
                    $data [] = [
                        "name"              => $rowData['1'],
                        "email"             => $rowData['2'],
                        "phone"             => $rowData['3'],
                        "image"             => $rowData['4'],
                        "address"           => $rowData['5'],
                        "email_verified_at" => NULL,
                        "password"          => Hash::make($rowData['7']),
                        "user_type"         => $user_type,
                        "created_at"        => $rowData['9'],
                        "updated_at"        => $rowData['9']
                    ];
                }
            }
            $firstline = FALSE;
        }
        collect($data)->chunk($chunkSize)->each(function ($chunk){
            User::insert($chunk->toArray());
        });

        DB::statement('SET FOREIGN_KEY_CHECKS=1;'); // khôi phục kiểm tra khóa ngoại

        fclose($csvFile);
    }
}
