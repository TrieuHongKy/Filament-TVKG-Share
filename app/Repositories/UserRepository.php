<?php

namespace App\Repositories;

use App\Interfaces\UserRepositoryInterface;
use App\Models\User;

class UserRepository implements UserRepositoryInterface{

    public function find($id){
        $user = User::find($id);
        if (!$user){
            throw new \Exception("Nguời dùng không tồn tại!");
        }

        return $user;
    }

    public function update($id, $data){
        $user = $this->find($id);
//        dd($user);
        $user->update($data);

        return $user;
    }
}
