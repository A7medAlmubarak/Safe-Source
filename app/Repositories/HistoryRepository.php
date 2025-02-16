<?php

namespace App\Repositories;

use App\Interfaces\IHistoryRepository;
use App\Models\History;
use Illuminate\Database\Eloquent\Collection;

class HistoryRepository implements IHistoryRepository
{
    public function create(array $data): History
    {
        return History::create($data);
    }

    public function getHistoryForFile(int $fileId): Collection
    {
        return History::where('file_id', $fileId)->with('user')->get();
    }

    public function getHistoryForUser(int $userId): Collection
    {
        return History::where('user_id', $userId)->with('file')->get();
    }
}
