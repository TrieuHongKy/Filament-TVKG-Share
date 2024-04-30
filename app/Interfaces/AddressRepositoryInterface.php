<?php

namespace App\Interfaces;

interface AddressRepositoryInterface{

    public function getAllProvince();

    public function getDistrict($id);

    public function getWard($id);
}
