<?php

namespace App\Services;

use App\Repositories\Contracts\CategoryRepositoryInterface;
use App\Repositories\Contracts\FoodRepositoryInterface;

class FrontService
{
    protected $categoryRepository;
    protected $foodRepository;

    public function __construct(FoodRepositoryInterface $foodRepository,
    CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
        $this->foodRepository = $foodRepository;
    }

    public function searchFood(string $keyword = '')
    {
        return $this->foodRepository->searchByName($keyword);
    }


    public function getFrontPageData()
    {
        $categories = $this->categoryRepository->getAllCategories();
        $popularFood = $this->foodRepository->getPopularFood(4);
        $newFood = $this->foodRepository->getAllNewFood();

        return compact('categories', 'popularFood', 'newFood');
    }
}