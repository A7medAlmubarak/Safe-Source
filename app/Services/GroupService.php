<?php

namespace App\Services;

use App\Interfaces\IGroupRepository;
use App\Models\Group;
use App\Models\User;

class GroupService{

    protected $groupRepository;

    public function __construct(IGroupRepository $groupRepository) {
        $this->groupRepository = $groupRepository;
    }

    /**
     * Create a new group.
     *
     * @param array $data
     * @param User $owner
     * @return Group
     */
    public function createGroup(array $data, User $owner): Group
    {
        return $this->groupRepository->create($data, $owner->id);
    }

    /**
     * Update an existing group.
     *
     * @param Group $group
     * @param array $data
     * @return Group
     */
    public function updateGroup(Group $group, array $data): Group
    {
        return $this->groupRepository->update($group, $data);
    }


    /**
     * Delete an existing group.
     *
     * @param Group $group
     * @return bool
     */
    public function deleteGroup(Group $group): bool
    {
        return $this->groupRepository->delete($group);
    }

    /**
     * Add a user to a group.
     *
     * @param Group $group
     * @param User $user
     * @return void
     */
    public function addUserToGroup(Group $group, User $user): void
    {
        $group->users()->attach($user);
    }


    /**
     * Remove a user from a group.
     *
     * @param Group $group
     * @param User $user
     * @return void
     */
    public function removeUserFromGroup(Group $group, User $user): void
    {
        $group->users()->detach($user);
    }

    /**
     * Check if a user is in a group.
     *
     * @param Group $group
     * @param User $user
     * @return bool
     */
    public function isUserInGroup(Group $group, User $user): bool
    {
        return $group->users->contains($user);

    }

//🍓⭐
    public function showFileForGroup(int $id)
    {
        $group = $this->groupRepository->find($id);
        return $this->groupRepository->getFiles($group);
    }

    /**
     * Get history records for a specific user.
     *
     * @param int $userId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function showUserForGroup(int $id)
    {
        $group = $this->groupRepository->find($id);
        return $this->groupRepository->getUsers($group);
    }

}



