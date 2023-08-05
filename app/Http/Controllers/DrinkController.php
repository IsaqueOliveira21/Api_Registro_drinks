<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\DrinkService;
use Illuminate\Http\Request;

class DrinkController extends Controller
{
    private $service;

    public function __construct(DrinkService $drinkService) {
        $this->service = $drinkService;
    }

    public function rankIndex() {
        return $this->service->rankIndex();
    }
    public function userDrinksToday(User $user) {
        return $this->service->userDrinksToday($user);
    }

    public function store(User $user, Request $request) {
        $qtd = $request->qtd;
        return $this->service->store($user, $qtd);
    }
}
