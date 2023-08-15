<?php

namespace App\Services;
use App\Models\User;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;

class UserService
{
    private $user;
    public function __construct(User $user) {
        $this->user = $user;
    }
    public function login($input): JsonResponse
    {
        if(!auth()->attempt($input)) {
            throw new HttpResponseException(response()->json(['E-mail ou Senha invalidos!'], 401));
        } else {
            $token = auth()->user()->createToken('accessToken');
            return response()->json([$token->plainTextToken], 200);
        }
    }
    public function logout() {
        auth()->user()->currentAccessToken()->delete();
        return response()->json(['Usuario deslogado com sucesso!'], 200);
    }
    public function index() {
        $users = User::paginate(2);
        return $users;
    }
    public function store($input) {
        try {
            return $this->user->create([
                'name' => $input['name'],
                'email' => $input['email'],
                'password' => bcrypt($input['password']),
            ]);
        } catch (HttpResponseException $e) {
            throw new HttpResponseException(response()->json([$e->getMessage()], 500));
        }
    }
    public function update(User $user, array $input) {
        try {
            $user->fill($input);
            $user->save();
            return $user;
        } catch (HttpResponseException $e) {
            return response()->json([$e->getMessage()], 500);
        }
    }
    public function delete($user) {
        $user->delete();
        return response()->json(['Usuario removido com sucesso!'], 200);
    }
}
