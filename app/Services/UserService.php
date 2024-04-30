<?php

namespace App\Services;

use App\Interfaces\UserRepositoryInterface;

class UserService{

    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository){
        $this->userRepository = $userRepository;
    }

    public function getUserById($id){
        return $this->userRepository->find($id);
    }

    public function updateUser($id, $data){
        return $this->userRepository->update($id, $data);
    }

    public function updateImage($id, $data){
        $image     = $data['image'];
        $imageName = $image->getClientOriginalName();

        $image->move(storage_path('users'), $imageName);

        $data['image'] = asset(env('APP_URL') . '/storage/users/' . $imageName);

        return $this->userRepository->update($id, $data);
    }
}
