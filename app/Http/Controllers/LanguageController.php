<?php

namespace App\Http\Controllers;

use App\Models\Language;
use Illuminate\Http\Request;

class LanguageController extends Controller
{

    public function index(): \Illuminate\Http\JsonResponse
    {
        $languages = Language::all();
        return response()->json($languages, 200);

    }
}
