<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private $service;

    public function __construct(UserService $userService) {
        $this->service = $userService;
    }

    public function login(Request $request) {
        $input = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);
        return $this->service->login($input);
    }
}
