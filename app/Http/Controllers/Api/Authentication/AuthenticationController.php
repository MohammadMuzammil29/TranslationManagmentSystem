<?php

namespace App\Http\Controllers\Api\Authentication;

use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\Authentication\LoginRequest;
use App\Http\Requests\Authentication\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AuthenticationController extends BaseController
{
    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Register api
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(RegisterRequest $request)
    {
        try {

            $data = $request->all();
            $userData = $this->userRepository->createUser($data);
            $token = $userData->createToken('auth_token')->plainTextToken;

            return $this->sendResponse('User registered successfully.', [
                'token' => $token,
                'user'  => new UserResource($userData)
            ]);

        } catch (\Exception $e) {

            return $this->sendError('Registration failed.', 500, ['error' => $e->getMessage()]);
        }
    }


    /**
     * Login api
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {

            $userRaw = DB::table('users')->where('email', $request->email)->first();

            if (!$userRaw) {
                return $this->sendError('User not found.', 404);
            }

            $user = User::find($userRaw->id);

            $token = $user->createToken('auth_token')->plainTextToken;

            return $this->sendResponse('User login successfully.', [
                'token' => $token,
                'user'  => new UserResource($user)
            ]);

        } else {
            return $this->sendError('Unauthorised.', 401, ['error' => 'Invalid credentials']);
        }
    }

}
