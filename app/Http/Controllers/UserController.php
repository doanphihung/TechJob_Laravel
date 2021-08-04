<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Seeker;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public function details($id): \Illuminate\Http\JsonResponse
    {
        $currentUser = User::find($id);
        $company = Company::where('user_id', '=', $id)->first();
        return response()->json(['currentUser' => $currentUser,
                                 'company' => $company], 200);
    }
}
