<?php

namespace App\Policies;

use App\Models\File;
use App\Models\User;

class FilePolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function checkOut(User $user, File $file): bool
    {
        return $file->checked_by === $user->id;
    }

    /**
     * Determine if user can check in a file
     */
    public function checkIn(User $user, File $file): bool
    {
        if (!$file->group_id) {
            return false;
        }

        return $user->groups()
            ->where('group_id', $file->group_id)
            ->exists();
    }

    /**
     * Determine if user can check in multiple files
     */
    public function checkInMultiple(User $user, array $fileIds): bool
    {
        $files = File::whereIn('id', $fileIds)->get();

        foreach ($files as $file) {
            if (!$this->checkIn($user, $file)) {
                return false;
            }
        }
        return true;
    }


}
