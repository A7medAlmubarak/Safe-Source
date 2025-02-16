<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginUserRequest;
use App\Http\Requests\Auth\RegisterUserRequest;
use App\Http\Resources\HistoryResource;
use App\Services\AdminService;
use App\Services\HistoryService;
use App\Services\NotificationService;
use App\Services\TokenService;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    protected $adminService;
    protected $historyService;
    protected $notificationService;

    public function __construct(AdminService $adminService, HistoryService $historyService , NotificationService $notificationService)
    {
        $this->adminService = $adminService;
        $this->notificationService = $notificationService;
        $this->historyService = $historyService;

    }

    /**
     * Store a newly created resource in storage.
    */
    public function register(Request $request)
    {
        $userData = $request->only(['name', 'email', 'password']);
        $user = $this->adminService->createUser($userData);

        return response()->json([
            'message' => __('messages.user_created'),
            'user' => $user
        ], 201);

    }

    public function login(LoginUserRequest $request)
    {
        $userData = $request->only(['email', 'password']);
        $user = $this->adminService->loginUser($userData);
        $token = $this->adminService->createPersonalAccessToken($user);
        return response()->json([
            'message' => __('messages.user_logged_in'),
            'user' => $user,
            'token' => $token
        ], 200);
    }

        /**
     * Get history for a specific file.
     */
    public function getHistoryForFile($fileId)
    {
        $history = $this->historyService->getHistoryForFile($fileId);
        return $history;
    }


}
