<?php

namespace App\Services;

use App\Interfaces\AddressRepositoryInterface;

class AddressService{

    protected $addressRepository;

    public function __construct(AddressRepositoryInterface $addressRepository){
        $this->addressRepository = $addressRepository;
    }

    public function getAllProvince(){
        return $this->addressRepository->GetAllProvince();
    }

    public function getDistrictByProvinceId($id){
        return $this->addressRepository->getDistrict($id);
    }

    public function getWardByDistrictId($id){
        return $this->addressRepository->getWard($id);
    }
}
