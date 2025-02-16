<?php

namespace App\Services;

use App\Exceptions\File\FileAlreadyCheckedException;
use App\Exceptions\File\UnauthorizedFileAccessException;
use App\Models\File;
use Illuminate\Support\Facades\Auth;

class FileGuardService
{
    /**
     * @param int $fileId
     * @throws FileAlreadyCheckedException
     */
    public function checkIn(int $fileId): File
    {
        $file = File::lockForUpdate()->findOrFail($fileId);

        if ($file->checked_by !== null) {
            throw new FileAlreadyCheckedException("File is already checked out by another user.");
        }

        $file->checked_by = Auth::id();
        $file->isFree = false;
        $file->save();

        return $file;
    }

    /**
     * @param array $fileIds
     * @throws FileAlreadyCheckedException
     * @return array<int, File>
     */
    public function checkInMultiple(array $fileIds): array
    {
        $results = [];
        foreach ($fileIds as $fileId) {
            $results[$fileId] = $this->checkIn($fileId);
        }

        return $results;
    }

    /**
     * @param int $fileId
     * @throws UnauthorizedFileAccessException
     */
    public function checkOut(int $fileId): File
    {
        $file = File::lockForUpdate()->findOrFail($fileId);

        if ($file->checked_by !== Auth::id()) {
            throw new UnauthorizedFileAccessException("You don't have permission to check out this file.");
        }

        $file->checked_by = null;
        $file->isFree = true;
        $file->save();

        return $file;

    }

    /**
     * @param int $fileId
     * @throws UnauthorizedFileAccessException
     */
    public function cancelCheckIn(int $fileId): File
    {
        $file = File::lockForUpdate()->findOrFail($fileId);

        if ($file->checked_out_by !== Auth::id()) {
            throw new UnauthorizedFileAccessException("You don't have permission to cancel check-in for this file.");
        }

        $file->checked_out_by = null;
        $file->checked_out_at = null;
        $file->save();

        return $file;
    }
}
