<?php
namespace App\Repositories;

use App\Interfaces\IUserRepository;
use App\Models\User;

class UserRepository implements IUserRepository {
    public function getAllUsers() {
        return User::all(); // Fetch all users
    }

    public function getUserById($id) {
        return User::find($id); // Fetch a user by ID
    }

    public function getUserByEmail($email) {
        return User::where('email', $email)->first(); // Fetch a user by email
    }

    public function createUser(array $data) {
        return User::create($data); // Create a new user
    }

    public function updateUser($id, array $data) {
        $user = User::find($id);
        if ($user) {
            $user->update($data); // Update an existing user
        }
        return $user;
    }

    public function deleteUser($id) {
        $user = User::find($id);
        if ($user) {
            $user->delete(); // Delete a user by ID
        }
        return $user;
    }
}
