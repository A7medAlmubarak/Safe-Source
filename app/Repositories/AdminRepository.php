<?php
namespace App\Repositories;

use App\Interfaces\IAdminRepository;
use App\Models\Admin;

class AdminRepository implements IAdminRepository {
    public function getAllUsers() {
        return Admin::all(); // Fetch all users
    }

    public function getUserById($id) {
        return Admin::find($id); // Fetch a user by ID
    }

    public function getUserByEmail($email) {
        return Admin::where('email', $email)->first(); // Fetch a user by email
    }

    public function createUser(array $data) {
        return Admin::create($data); // Create a new user
    }

}
