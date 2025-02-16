<?php

namespace App\Http\Controllers;

use App\Http\Requests\Backup\GetBackupByFileRequest;
use App\Http\Resources\BackupResource;
use App\Models\BackupFile;
use Illuminate\Http\Request;

class BackupFileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function getByFileId(GetBackupByFileRequest $request)
    {
        $file_id = $request->input('file_id');
        $backups = BackupFile::where('file_id', $file_id)->get();

        return response()->json([
            'message' => __('messages.backup_retrieved'),
            'data' => BackupResource::collection($backups)
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $backupFile = BackupFile::findOrFail($id);
        return response()->json([
            'message' => __('messages.backup_retrieved'),
            'data' => new BackupResource($backupFile)
        ]);
    }

}
