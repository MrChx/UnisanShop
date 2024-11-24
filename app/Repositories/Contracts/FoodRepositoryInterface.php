<?php

namespace App\Repositories\Contracts;

interface FoodRepositoryInterface
{
    public function getPopularFood($limit);
    public function getAllNewFood();
    public function find($id);
    public function getPrice($ticketId);

    public function searchByName(string $keyword);

}