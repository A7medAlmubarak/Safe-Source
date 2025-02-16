<?php

namespace App\Interfaces;

use App\Models\File;

interface IFileRepository
{
    public function create(array $data): File;
    public function update(File $file, array $data): File;
    public function delete(File $file): bool;
    public function find(int $id): ?File;
}
