<?php
namespace App\Interfaces;

use App\Models\Group;
use Illuminate\Database\Eloquent\Collection;

interface IGroupRepository
{
    public function create(array $data, int $ownerId): Group;
    public function update(Group $group, array $data): Group;
    public function delete(Group $group): bool;
    public function find(int $id): ?Group;
    public function getUsers(Group $group): Collection;
    public function getFiles(Group $group): Collection;
}
