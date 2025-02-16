<?php

namespace App\Repositories;

use App\Interfaces\IFileRepository;
use App\Models\File;

class FileRepository implements IFileRepository
{
    public function create(array $data): File
    {
        return File::create($data);
    }

    public function update(File $file, array $data): File
    {
        $file->update($data);
        return $file;
    }

    public function delete(File $file): bool
    {
        return $file->delete();
    }

    public function find(int $id): ?File
    {
        return File::find($id);
    }
}
