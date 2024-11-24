<?php

namespace App\Repositories;

use App\Models\food;
use App\Repositories\Contracts\FoodRepositoryInterface;

class FoodRepository implements FoodRepositoryInterface
{
    public function getPopularFood($limit = 10)
    {
        return Food::where('is_populer', true)->take($limit)->get();
    }

    public function searchByName(string $keyword)
    {
        return Food::where('name', 'LIKE', '%' . $keyword . '%')->get();
    }

    public function getAllNewFood()
    {
        return food::latest()->get();
    }

    public function find($id)
    {
        return food::find($id);
    }

    public function getPrice($foodId)
    {
        $food = $this->find($foodId);
        return $food ? $food->price : 0;
    }
}