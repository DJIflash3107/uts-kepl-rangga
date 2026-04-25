<?php
namespace App\Services;

interface MovieServiceInterface {
    public function createMovie($data);
    public function getMovie($id);
    public function listMovie(int $paginate, $search);
    public function updateMovie($id, $data, $request);
    public function deleteMovie($id);
}