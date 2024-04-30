<?php

namespace App\Interfaces;

interface UserRepositoryInterface{

    public function find($id);

    public function update($id, $data);
}
