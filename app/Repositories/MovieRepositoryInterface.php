<?php

namespace App\Repositories;

interface MovieRepositoryInterface {
    public function create(array $data);
    public function find($id);
    public function list();
    public function update($id, array $data);
    public function delete($id);
}