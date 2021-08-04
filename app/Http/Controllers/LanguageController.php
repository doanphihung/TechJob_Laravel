<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LanguageController extends Controller
{

    public function getAllLanguage(): \Illuminate\Http\JsonResponse
    {
        $languages = DB::table('jobs')->select('language')->groupBy('language')->get();
        return response()->json([
            'languages' => $languages,
            'status' => 'success'],
            200);

    }
}
