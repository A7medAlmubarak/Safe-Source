<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Exceptions\Auth\InvalidCredentialsException;
use App\Interfaces\IUserRepository;

class UserService
{
    protected $userRepository;

    public function __construct(IUserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function createUser(array $data)
    {
        return $this->userRepository->createUser([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

    public function loginUser(array $credentials)
    {
        $user = $this->userRepository->getUserByEmail($credentials['email']);
        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            throw new InvalidCredentialsException();
        }
        return $user;
    }


    public function updateUser(User $user, array $data)
    {
        return $this->userRepository->updateUser($user->id, $data);
    }

    public function deleteUser(User $user)
    {
        return $this->userRepository->deleteUser($user->id);
    }

    public function findUserById($id)
    {
        return $this->userRepository->getUserById($id);
    }

    public function getAllUsers()
    {
        return $this->userRepository->getAllUsers();
    }

}
