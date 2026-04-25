<?php

namespace App\Services;

use App\Repositories\CategoryRepositoryInterface;

class CategoryService implements CategoryServiceInterface {
    protected $categoryRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository) {
        $this->categoryRepository = $categoryRepository;
    }

    public function listCategory() {
        return $this->categoryRepository->list();
    }
}