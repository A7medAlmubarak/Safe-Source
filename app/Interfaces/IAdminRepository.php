<?php
namespace App\Interfaces;

interface IAdminRepository {
    public function getAllUsers();
    public function getUserById($id);
    public function getUserByEmail($email);
    public function createUser(array $data);
}
