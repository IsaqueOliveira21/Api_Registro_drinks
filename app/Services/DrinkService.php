<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use function PHPUnit\Framework\assertJson;

class DrinkService
{
    public function rankIndex($datas = null) {
        $query = DB::table('drinks')
            ->select('users.name', DB::raw("COUNT(*) AS qtd"))
            ->join('users', 'drinks.user_id', '=', 'users.id')
            ->when(!empty($datas), function ($query) use ($datas) {
                $query->whereBetween('drinks.created_at', $datas);
            })
            ->groupBy('users.name')
            ->orderBy('qtd', 'DESC')
            ->get();
        return $query;
    }
    public function userDrinksToday($user) {
        $query = DB::table('drinks')
            ->select('users.name', DB::raw("COUNT(*) AS qtdHoje"))
            ->join('users', 'drinks.user_id', '=', 'users.id')
            ->where('user_id', $user->id)
            ->where('drinks.data', Carbon::now()->toDateString())
            ->groupBy('users.name')
            ->get();
        return response()->json([$query], 200);
    }

    public function store($user, $qtd) {
        for($i = $qtd; $i > 0; $i--) {
            $user->drinks()->create([
                'user_id' => $user->id,
                'data' => Carbon::now()->toDateString()
            ]);
        }
        return response()->json(["Voce inseriu $qtd registro(s)"], 200);
    }
}
