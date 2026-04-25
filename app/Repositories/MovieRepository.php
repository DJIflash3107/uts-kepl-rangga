<?php
namespace App\Repositories;

use App\Models\Movie;

class MovieRepository implements MovieRepositoryInterface
{
    protected $model;

    public function __construct(Movie $model)
    {
        $this->model = $model;
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function find($id)
    {
        return $this->model->find($id);
    }

    public function list() {
        return $this->model->latest();
    }

    public function update($id, array $data)
    {
        $movie = $this->model->find($id);

        if ($movie != null) {
            return $movie->update($data);
        }

        return null;
    }

    public function delete($id)
    {
        $movie = $this->model->find($id);

        return $movie->delete();
    }
}