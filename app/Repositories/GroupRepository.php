<?php
namespace App\Repositories;

use App\Interfaces\IGroupRepository;
use App\Models\Group;
use Illuminate\Database\Eloquent\Collection;

class GroupRepository implements IGroupRepository
{
    public function create(array $data, int $ownerId): Group
    {
        $group = new Group();
        $group->name = $data['name'];
        $group->description = $data['description'] ?? null;
        $group->owner_id = $ownerId;
        $group->save();

        return $group;
    }

    public function update(Group $group, array $data): Group
    {
        $group->name = $data['name'] ?? $group->name;
        $group->description = $data['description'] ?? $group->description;
        $group->save();

        return $group;
    }

    public function delete(Group $group): bool
    {
        return $group->delete();
    }

    public function find(int $id): ?Group
    {
        return Group::find($id);
    }

    public function getUsers(Group $group): Collection
    {
        return $group->users;
    }

    public function getFiles(Group $group): Collection
    {
        return $group->files;
    }
}
