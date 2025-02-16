<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use App\Models\BackupFile;
use App\Models\File;

class BackupService
{

    /**
     * Create a backup file and its corresponding database record.
     *
     * @param File $oldFile
     * @return BackupFile
     */
    public function createBackup(File $oldFile , int $user_id )
    {
        // Generate a new file name for the backup
        $backupFileName = 'backup_' . time() . '_' . $oldFile->name;

        // Copy the old file to the new backup path
        $backupPath = 'backups/' . $backupFileName;
        Storage::disk('public')->copy($oldFile->path, $backupPath);

        // Create the backup record
        return $this->createBackupRecord($oldFile, $backupPath, $user_id);
    }

    /**
     * Upload a file to the specified disk.
     *
     * @param UploadedFile $file
     * @param string $path
     * @param string $disk
     * @return string
     */
    public function uploadBackupFile(UploadedFile $file, string $path = 'backups', string $disk = 'public')
    {
        $fileName = time() . '_' . $file->getClientOriginalName();
        $filePath = $file->storeAs($path, $fileName, $disk);
        return $filePath;
    }

    /**
     * Create a Backup record in the database.
     * @param string $name
     * @param string $path
     * @param string $type
     * @param int $size
     * @param bool $isFree
     * @param int $user_id
     * @return \App\Models\BackupFile
     */
    public function createBackupRecord(File $oldFile, string $path, int $user_id)
    {
        return BackupFile::create([
            'name' => $oldFile->name,
            'path' => $path,
            'type' => $oldFile->type,
            'size' => $oldFile->size,
            'user_id' => $user_id,
            'file_id' => $oldFile->id,
        ]);
    }


    /**
     * Check if a file exists.
     *
     * @param string $path
     * @param string $disk
     * @return bool
     */
    public function fileExists(string $path, string $disk = 'public')
    {
        return Storage::disk($disk)->exists($path);
    }
    
}
