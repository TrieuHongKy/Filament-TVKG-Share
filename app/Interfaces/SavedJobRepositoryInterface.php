<?php

namespace App\Interfaces;

interface SavedJobRepositoryInterface{

    public function all();

    public function find($id);

    public function create($data);

    public function delete($id);
}
