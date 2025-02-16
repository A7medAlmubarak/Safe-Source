<?php
namespace App\Interfaces;

interface IBackupFileRepository {
    public function createBackupFile(array $data);
}
