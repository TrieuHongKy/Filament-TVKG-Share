<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Http\Traits\Helpers\ApiResponseTrait;
use App\Services\UserService;

class UserController extends Controller{

    use ApiResponseTrait;

    protected $userService;

    public function __construct(UserService $userService){
        $this->userService = $userService;
    }

    public function getUserById($id){
        try{
            $user = $this->userService->getUserById($id);

            return $this->success($user);
        }catch (\Exception $e){
            return $this->error($e->getMessage());
        }
    }

    public function update(UserRequest $request, $id){
        try{

            $user = $this->userService->updateUser($id, $request->validated());
            $data = new UserResource($user);

            return $this->ResponseWithResource($data);
        }catch (\Exception $e){
            return $this->ResponseWithError($e->getMessage());
        }
    }

    public function updateImage(UserRequest $request, $id){
        try{
            $image = $request->file('image');

            $data = [
                'image' => $image
            ];
            //            $user = $this->userService->updateUser($id, $request->validated());
            //            $data = new UserResource($user);
            $user = new UserResource($this->userService->updateImage($id, $data));

            return $this->ResponseWithResource($user);
        }catch (\Exception $e){
            return $this->responseWithError($e->getMessage());
        }
    }

    public function show($id){
        try{
            $user = $this->userService->getUserById($id);
            $data = new UserResource($user);

            return $this->ResponseWithResource($data);
        }catch (\Exception $e){
            return $this->ResponseWithError($e->getMessage());
        }
    }
}
