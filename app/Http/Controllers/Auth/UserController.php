<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginUserRequest;
use App\Http\Requests\Auth\RegisterUserRequest;
use App\Http\Requests\Auth\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\NotificationService;
use App\Services\TokenService;
use App\Services\UserService;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    protected $userService;
    protected $tokenService;
    protected $notificationService;

    public function __construct(UserService $userService, TokenService $tokenService , NotificationService $notificationService)
    {
        $this->userService = $userService;
        $this->tokenService = $tokenService;
        $this->notificationService = $notificationService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return UserResource::collection($this->userService->getAllUsers());
    }

    /**
     * Store a newly created resource in storage.
    */
    public function register(RegisterUserRequest $request)
    {
        $userData = $request->only(['name', 'email', 'password']);
        $user = $this->userService->createUser($userData);

        return response()->json([
            'message' => __('messages.user_created'),
            'user' => new UserResource($user)
        ], 201);

    }

    public function login(LoginUserRequest $request)
    {
        $userData = $request->only(['email', 'password']);
        $user = $this->userService->loginUser($userData);
        $token = $this->tokenService->createPersonalAccessToken($user);
        return response()->json([
            'message' => __('messages.user_logged_in'),
            'user' => new UserResource($user),
            'token' => $token
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return new UserResource($this->userService->findUserById($user->id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request)
    {
        $user = Auth::guard('api')->user();
        $userData = $request->only(['name']);
        $newUser = $this->userService->updateUser($user, $userData);
        return response()->json([
            'message' => __('messages.user_updated'),
            'user' => new UserResource($newUser)
        ], 200);
    }

    public function logout()
    {
        /** @var \App\Models\User $user **/
        $user = Auth::guard('api')->user();
        if ($user) {
            $user->token()->revoke();
            return response()->json(['message' => __('messages.user_logged_out')], 200);
        } else {
            return response()->json(['message' => __('messages.user_not_found')], 404);
        }
    }
}
