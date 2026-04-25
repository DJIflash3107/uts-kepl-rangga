<?php

namespace App\Repositories;

use App\Models\Category;

class CategoryRepository implements CategoryRepositoryInterface {
    protected $model;

    public function __construct(Category $model) {
        $this->model = $model;
    }

    public function list() {
        return $this->model->all();
    }
}