<?php
namespace App\Interfaces;

interface IUserRepository {
    public function getAllUsers();
    public function getUserById($id);
    public function getUserByEmail($email);
    public function createUser(array $data);
    public function updateUser($id, array $data);
    public function deleteUser($id);
}
