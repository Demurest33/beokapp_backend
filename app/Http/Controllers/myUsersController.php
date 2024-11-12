<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\myUser;

class myUsersController extends Controller
{
    public function index()
    {
        $users = myUser::all();
        return response()->json($users);
    }


}
