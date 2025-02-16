<?php
namespace App\Repositories;

use App\Interfaces\IBackupFileRepository;
use App\Models\BackupFile;

class BackupFileRepository implements IBackupFileRepository {

    public function createBackupFile(array $data) {
        return BackupFile::create($data); // Create a new user
    }

}
