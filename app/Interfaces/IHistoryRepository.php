<?php

namespace App\Interfaces;

use App\Models\History;
use Illuminate\Database\Eloquent\Collection;

interface IHistoryRepository
{
    public function create(array $data): History;
    public function getHistoryForFile(int $fileId): Collection;
    public function getHistoryForUser(int $userId): Collection;
}
