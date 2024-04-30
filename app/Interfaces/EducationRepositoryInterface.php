<?php

namespace App\Interfaces;

interface EducationRepositoryInterface{

    public function all();

    public function find($id);

    public function getWidget($key);

    public function create(array $data);

    public function update($id, array $data);

    public function delete($id);
}
