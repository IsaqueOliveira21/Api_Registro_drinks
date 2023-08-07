<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
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

    public function logout() {
        return $this->service->logout();
    }

    public function index() {
        $users = $this->service->index();
        return UserResource::collection($users);
    }

    public function store(Request $request) {
        $input = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|string',
        ]);
        $user = $this->service->store($input);
        return new UserResource($user);
    }
}
