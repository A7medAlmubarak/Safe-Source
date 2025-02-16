<?php

namespace App\Services;

use Illuminate\Support\Facades\Hash;
use App\Exceptions\Auth\InvalidCredentialsException;
use App\Interfaces\IAdminRepository;
use App\Models\Admin;

class AdminService
{
    protected $adminRepository;

    public function __construct(IAdminRepository $adminRepository)
    {
        $this->adminRepository = $adminRepository;
    }

    public function createUser(array $data)
    {
        return $this->adminRepository->createUser([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

    public function loginUser(array $credentials)
    {
        $user = $this->adminRepository->getUserByEmail($credentials['email']);
        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            throw new InvalidCredentialsException();
        }
        return $user;
    }



    public function findUserById($id)
    {
        return $this->adminRepository->getUserById($id);
    }

    public function getAllUsers()
    {
        return $this->adminRepository->getAllUsers();
    }

        /**
     * Create a new personal access token for the user.
     *
     * @param User $user
     * @param string $tokenName
     * @return PersonalAccessTokenResult
     */
    public function createPersonalAccessToken(Admin $user, string $tokenName = 'Personal Access Token')
    {
        return $user->createToken($tokenName)->accessToken;
    }


}
