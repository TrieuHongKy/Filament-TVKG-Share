<?php

namespace App\Interfaces;

interface ContactRepositoryInterface{

    public function all();

    public function find($id);

    public function create(array $data);

    public function delete($id);
}
