<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\food;
use App\Services\FrontService;
use Illuminate\Http\Request;


class FrontController extends Controller
{
    protected $frontService;

    public function __construct(FrontService $frontService)
    {
        $this->frontService = $frontService;
    }

    public function search(Request $request)
    {
        $keyword = $request->input('keyword');
        $food = $this->frontService->searchFood($keyword);

        return view('front.search',[
            'food' => $food,
            'keyword' => $keyword,
        ]);
    }

    public function index()
    {
        $data = $this->frontService->getFrontPageData();
        return view('front.index', $data);
    }

    public function details(Food $food) {
        return view('front.details', compact('food'));
    }

    public function category(Category $category) {
        return view('front.category', compact('category'));
    }

    public function viewAll()
    {
        $data = $this->frontService->getFrontPageData();
        return view('front.viewAll', $data);
    }
}
