<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public function details($id): \Illuminate\Http\JsonResponse
    {
        $currentUser = User::find($id);
        return response()->json($currentUser, 200);

    }
}
