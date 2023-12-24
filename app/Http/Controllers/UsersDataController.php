<?php

namespace App\Http\Controllers;

use App\Services\UsersApiService;

class UsersDataController extends Controller
{
    public function index(UsersApiService $randomApiService)
    {
        $users = $randomApiService->getUsers();
        
        return view('randomdata.index', ['users' => $users]);
    }
}
