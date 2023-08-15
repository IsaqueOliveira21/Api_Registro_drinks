<?php

namespace App\Http\Controllers;

use App\Http\Resources\DrinkResource;
use App\Models\User;
use App\Services\DrinkService;
use Illuminate\Http\Request;

class DrinkController extends Controller
{
    private $service;

    public function __construct(DrinkService $drinkService) {
        $this->service = $drinkService;
    }

    public function rankIndex(Request $request) {
        $datas = ['inicial' => $request->data_inicio, 'final' => $request->data_final];
        $rank = $this->service->rankIndex($datas);
        return DrinkResource::collection($rank);
    }
    public function userDrinksToday(User $user) {
        return $this->service->userDrinksToday($user); // aqui iria precisar de um resource diferente
    }

    public function store(User $user, Request $request) {
        $qtd = $request->qtd;
        return $this->service->store($user, $qtd); // aqui iria precisar de um resource diferente
    }
}
