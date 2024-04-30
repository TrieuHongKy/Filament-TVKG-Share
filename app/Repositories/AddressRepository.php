<?php

namespace App\Repositories;

use App\Interfaces\AddressRepositoryInterface;
use App\Models\District;
use App\Models\Province;
use App\Models\Ward;

class AddressRepository implements AddressRepositoryInterface{

    public function getAllProvince(){
        return Province::get();
    }

    public function getDistrict($id){
        $district = District::where('province_id', $id)->get();
        if (!$district){
            throw new \Exception('Quận/huyện không tồn tại.');
        }

        return $district;
    }

    public function getWard($id){
        $ward = Ward::where('district_id', $id)->get();;
        if (!$ward){
            throw new \Exception('Phường/xã không tồn tại.');
        }

        return $ward;
    }
}
