<?php

namespace App\Services;

use App\Models\FileGroup;
use App\Models\File;
use App\Models\Group;

class FileGroupService
{

    public function addFileToGroup(Group $group, File $file): void
    {
        $group->files()->attach($file->id);
    }

    /**
     * Check if a file already exists in the group.
     *
     * @param FileGroup $group
     * @param File $file
     * @return bool
     */
    public function fileExistsInGroup(Group $group, File $file): bool
    {
        return $group->files()->where('file_id', $file->id)->exists();
    }
}



