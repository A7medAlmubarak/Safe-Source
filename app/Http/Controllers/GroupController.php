<?php

namespace App\Http\Controllers;

use App\Http\Requests\Group\CreateGroupRequest;
use App\Http\Requests\Group\UpdateGroupRequest;
use App\Http\Resources\GroupResource;
use App\Http\Resources\UserResource;
use App\Http\Resources\FileResource;
use App\Models\File;
use App\Models\Group;
use App\Models\User;
use App\Services\FileGroupService;
use App\Services\GroupService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GroupController extends Controller
{
    protected $groupService;
    protected $fileGroupService;

    public function __construct(GroupService $groupService , FileGroupService $fileGroupService)
    {
        $this->groupService = $groupService;
        $this->fileGroupService = $fileGroupService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $groups = Group::all();
        return GroupResource::collection($groups);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateGroupRequest $request)
    {
        $owner = Auth::user();
        $group = $this->groupService->createGroup($request->all(), $owner);
        $this->groupService->addUserToGroup($group, $owner);

        return response()->json([
            'message' => __('messages.group_created'),
            'group' => new GroupResource($group)
        ], 201);
    }
    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $group = Group::findOrFail($id);
        return new GroupResource($group);
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGroupRequest $request, $id)
    {
        $group = Group::findOrFail($id);
        $group = $this->groupService->updateGroup($group, $request->all());
        return response()->json([
            'message' => __('messages.group_updated'),
            'group' => new GroupResource($group)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $group = Group::findOrFail($id);
        $deleted = $this->groupService->deleteGroup($group);
        if ($deleted) {
            return response()->json(['message' => __('messages.group_deleted')], 200);
        }
        return response()->json(['message' => __('messages.group_not_found')], 500);
    }

    /**
     * Add a user to the group.
     */
    public function addUser($id,$userId)
    {
        $user = User::findOrFail($userId);
        $group = Group::findOrFail($id);

        if (!$this->groupService->isUserInGroup($group, $user)) {
            $this->groupService->addUserToGroup($group, $user);
            return response()->json(['message' => __('messages.user_added_to_group')], 200);
        }

        return response()->json(['message' => __('messages.user_already_in_group')], 409);
    }

    /**
     * Remove a user from the group.
     */
    public function removeUser($id,$userId)
    {
        $user = User::findOrFail($userId);
        $group = Group::findOrFail($id);

        if ($this->groupService->isUserInGroup($group, $user)) {
            $this->groupService->removeUserFromGroup($group, $user);
            return response()->json(['message' => 'User removed from group successfully'], 200);
        }

        return response()->json(['message' => 'User is not in this group'], 404);
    }



    public function share($group_id , $file_id )
    {
        $file = File::findOrFail($file_id);
        $group = Group::findOrFail($group_id);

        if (!$this->fileGroupService->fileExistsInGroup($group, $file)) {
            $this->fileGroupService->addFileToGroup($group, $file);
            return response()->json(['message' => 'File added to group successfully'], 200);
        }

        return response()->json(['message' => 'File already exists in this group'], 409);
    }


    //🍓🍓

    public function getFileForGroup($id)
    {
        $files = $this->groupService->showFileForGroup($id);
        return FileResource::collection($files);
    }

    /**
     * Get history for a specific user.
     */
    public function getUserForGroup($id)
    {
        $users = $this->groupService->showUserForGroup($id);
        return UserResource::collection($users);
    }

}
