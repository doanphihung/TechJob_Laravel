<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public function getUserCurrent($id) {
        $user = User::find($id);
        return response()->json(['user' => $user], 200);
    }
}
