<?php

namespace App\Http\Controllers;

use App\Http\Requests\File\ChechInMultipleRequest;
use App\Http\Requests\File\ChechInRequest;
use App\Http\Requests\File\CreateFileRequest;
use App\Http\Resources\FileResource;
use App\Models\File;
use App\Services\FileService;
use App\Services\BackupService;
use App\Services\ChangeService;
use App\Services\HistoryService;
use App\Services\FileGuardService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FileController extends Controller
{
    protected $fileService;
    protected $backupService;
    protected $historyService;
    protected $fileGuardService;
    protected $changeService;

    public function __construct(
        FileService $fileService,
        BackupService $backupService,
        HistoryService $historyService,
        ChangeService $changeService,
        FileGuardService $fileGuardService
    ) {
        $this->fileService = $fileService;
        $this->backupService = $backupService;
        $this->historyService = $historyService;
        $this->fileGuardService = $fileGuardService;
        $this->changeService = $changeService;
    }

    public function create(CreateFileRequest $request)
    {
        $file = $request->file('file');
        $path = $this->fileService->uploadFile($file);
        $size = $this->fileService->getFileSize($path);
        $type = $this->fileService->getFileType($file);
        $owner_id = auth()->id();
        $fileRecord = $this->fileService->createFileRecord(
            $file->getClientOriginalName(),
            $path,
            $type,
            $size,
            $owner_id,
            true
        );

        $this->backupService->createBackup($fileRecord, $owner_id);
        $this->historyService->createHistory($fileRecord->id, $owner_id, 'create');

        return response()->json([
            'message' => __('messages.file_uploaded'),
            'file' => new FileResource($fileRecord)
        ]);
    }

    public function update(CreateFileRequest $request, $id)
    {
        $file = File::findOrFail($id);
        $this->backupService->createBackup($file, auth()->user()->id);

        // Delete the old file
        $this->fileService->deleteFile($file->path);

        // Upload the new file
        $newFile = $request->file('file');
        $newPath = $this->fileService->uploadFile($newFile);
        $newSize = $this->fileService->getFileSize($newPath);
        $newType = $newFile->getClientMimeType();

        // Update file record
        $file = $this->fileService->updateFileRecord(
            $file->id,
            $newFile->getClientOriginalName(),
            $newPath,
            $newType,
            $newSize,
            $file->isFree,
        );

        $file->save();

        return response()->json([
            'message' => __('messages.file_updated'),
            'file' => new FileResource($file)
        ]);
    }

    public function delete(Request $request)
    {
        $file = File::findOrFail($request->file_id);
        $deleted = $this->fileService->deleteFile($file->path);

        if ($deleted) {
            $file->delete();
            return response()->json(['message' => __('messages.file_deleted'), 'deleted' => $deleted]);
        }
        return response()->json(['deleted' => $deleted]);
    }

    /**
     * Check in a file for editing.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkIn(ChechInRequest $request)
    {
        $this->fileGuardService->checkIn($request->file_id);
        $file = File::findOrFail($request->file_id);
        return response()->json([
            'message' => __('messages.file_checked_in'),
            'file' => new FileResource($file)
        ]);
    }

    /**
     * Check in multiple files at once.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkInMultiple(ChechInMultipleRequest $request)
    {
        $results = $this->fileGuardService->checkInMultiple($request->file_ids);
        $files = File::whereIn('id', $request->file_ids)->get();
        return response()->json([
            'results' => $results,
            'files' => FileResource::collection($files)
        ]);
    }

    /**
     * Check out a file after editing.
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkOut(Request $request)
    {
        $file = File::findOrFail($request->file_id);
        // Check if the user is authorized to check out the file using policy
        $this->authorize('checkOut', $file);
        $success = $this->fileGuardService->checkOut($request->file_id);
        return response()->json([
            'file' => new FileResource($success)
        ]);
    }

    /**
     * Cancel a file check-in.
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function cancelCheckIn(Request $request)
    {
        $request->validate([
            'file_id' => 'required|exists:files,id'
        ]);
        $success = $this->fileGuardService->cancelCheckIn($request->file_id);
        $file = File::findOrFail($request->file_id);
        return response()->json([
            'success' => $success,
            'file' => new FileResource($file)
        ]);
    }

}
