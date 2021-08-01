<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(): \Illuminate\Http\JsonResponse
    {
        $categories = Category::all();
        return response()->json($categories, 200);
    }

    public function test(): \Illuminate\Http\JsonResponse
    {
        $user = auth()->user();
        return response()->json(['user' => $user], 200);
    }
}
