<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class CategoryController extends Controller
{
    public function getAll(): \Illuminate\Http\JsonResponse
    {
        $categories = Category::with('jobs')->get();
        return response()->json($categories, 200);
    }

    public function add(Request $request)
    {
        try {
            DB::beginTransaction();
            $city = new Category();
            $city->fill($request->all());
            $city->save();
            DB::commit();
            $cities = Category::all();
            return response()->json($cities);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'error']);
        }
    }

    //test thử middleware
    public function test(): \Illuminate\Http\JsonResponse
    {
        $user = auth()->user();
        return response()->json(['user' => $user], 200);
    }
}
