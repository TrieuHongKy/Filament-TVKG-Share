<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\DistrictCollection;
use App\Http\Resources\ProvinceCollection;
use App\Http\Resources\WardCollection;
use App\Http\Traits\Helpers\ApiResponseTrait;
use App\Services\AddressService;
use Exception;
use Illuminate\Http\JsonResponse;

class AddressController extends Controller{

    use ApiResponseTrait;

    protected $addressService;

    public function __construct(addressService $addressService){
        $this->addressService = $addressService;
    }

    /**
     * get all province
     *
     * @return JsonResponse
     */
    public function getAllProvince()
    : JsonResponse{
        $province = new ProvinceCollection($this->addressService->getAllProvince());

        return $this->responseWithResource($province, 'Lấy danh sách các tỉnh thành công.');
    }

    /**
     * get all district by province_id
     *
     * @param mixed $id
     *
     * @return JsonResponse
     */
    public function getAllDistrictByProvinceId($id)
    : JsonResponse{
        try{
            $district = new DistrictCollection($this->addressService->getDistrictByProvinceId($id));

            return $this->responseWithResource($district, 'Lấy danh sách quận/huyện thành công.');
        }catch (Exception $e){
            return $this->responseWithError($e->getMessage(), 404);
        }
    }

    /**
     * get a
     * ll ward by district_id
     *
     * @param mixed $id
     *
     * @return JsonResponse
     */
    public function getAllWardByDistrictId($id)
    : JsonResponse{
        try{
            $ward = new WardCollection($this->addressService->getWardByDistrictId($id));

            return $this->responseWithResource($ward, 'Lấy danh sách phường/xã thành công.');
        }catch (Exception $e){
            return $this->responseWithError($e->getMessage(), 404);
        }
    }
}
