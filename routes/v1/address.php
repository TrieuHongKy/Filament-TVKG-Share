<?php

use App\Http\Controllers\Api\V1\AddressController;
use Illuminate\Support\Facades\Route;

Route::get('province', [AddressController::class, 'getAllProvince']);
Route::get('district/{id}', [AddressController::class, 'getAllDistrictByProvinceId']);
Route::get('ward/{id}', [AddressController::class, 'getAllWardByDistrictId']);
