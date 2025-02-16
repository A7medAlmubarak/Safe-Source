<?php

namespace App\Services;

use App\Exceptions\File\FileDeleteException;
use App\Exceptions\File\FileNotFoundException;
use App\Exceptions\File\FileUploadException;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use App\Exceptions\File\FileCreateException;
use App\Interfaces\IFileRepository;

class FileService
{

    protected $fileRepository;

    public function __construct(IFileRepository $fileRepository)
    {
        $this->fileRepository = $fileRepository;
    }

    /**
     * Upload a file to the specified disk.
     *
     * @param UploadedFile $file
     * @param string $path
     * @param string $disk
     * @return string
     */
    public function uploadFile(UploadedFile $file, string $path = 'uploads', string $disk = 'public')
    {
        if (!$file->isValid()) {
            throw new FileUploadException('Invalid file upload');
        }

        try {
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs($path, $fileName, $disk);

            if (!$filePath) {
                throw new FileUploadException('Failed to store file');
            }

            return $filePath;
        } catch (\Exception $e) {
            throw new FileUploadException('File upload failed: ' . $e->getMessage());
        }
    }

    /**
     * Get the full URL for a file.
     *
     * @param string $path
     * @param string $disk
     * @return string|null
     */
    public function getFileUrl(string $path, string $disk = 'public')
    {
        if (Storage::disk($disk)->exists($path)) {
            return Storage::url($path);
        }
        return null;
    }

    /**
     * Create a file record in the database.
     * @param string $name
     * @param string $path
     * @param string $type
     * @param int $size
     * @param bool $isFree
     * @param int $owner_id
     * @return \App\Models\File
     */
    public function createFileRecord(string $name, string $path, string $type, int $size, int $owner_id, bool $isFree = true)
    {
        try {
            return $this->fileRepository->create([
                'name' => $name,
                'path' => $path,
                'type' => $type,
                'size' => $size,
                'isFree' => $isFree,
                'owner_id' => $owner_id,
            ]);
        } catch (\Exception $e) {
            throw new FileCreateException("Failed to create file record" );
        }
    }

    /**
     * Update a file record in the database.
     *
     * @param int $id
     * @param string $name
     * @param string $path
     * @param string $type
     * @param int $size
     * @param bool $isFree
     * @return \App\Models\File|null
     */
    public function updateFileRecord(int $id, string $name, string $path, string $type, int $size, bool $isFree)
    {
        $file = $this->fileRepository->find($id);
        if (!$file) {
            return null;
        }
        return $this->fileRepository->update($file, [
            'name' => $name,
            'path' => $path,
            'type' => $type,
            'size' => $size,
            'isFree' => $isFree,
        ]);
    }


    /**
     * Get the size of a file.
     *
     * @param string $path
     * @param string $disk
     * @return int|null
     */
    public function getFileSize(string $path, string $disk = 'public'): ?int
    {
        if (Storage::disk($disk)->exists($path)) {
            return Storage::disk($disk)->size($path);
        }

        return null;
    }

    /**
     * Get the MIME type of a file.
     *
     * @param \Illuminate\Http\UploadedFile $file
     * @return string|null
     */
    public function getFileType(UploadedFile $file): ?string
    {
        return $file->getClientMimeType();
    }

    /**
     * Delete a file from storage.
     *
     * @param string $path
     * @param string $disk
     * @return bool
     */
    public function deleteFile(string $path, string $disk = 'public')
    {
        if (!$this->fileExists($path, $disk)) {
            throw new FileNotFoundException("File not found at path: {$path}");
        }

        if (!Storage::disk($disk)->delete($path)) {
            throw new FileDeleteException("Failed to delete file at path: {$path}");
        }

        return true;
    }

    /**
     * Get the contents of a file.
     *
     * @param string $path
     * @param string $disk
     * @return string|null
     */
    public function getFileContents(string $path, string $disk = 'public')
    {
        if (Storage::disk($disk)->exists($path)) {
            return Storage::disk($disk)->get($path);
        }

        return null;
    }

    /**
     * Check if a file exists.
     *
     * @param string $path
     * @param string $disk
     * @return bool
     */
    public function fileExists(string $path, string $disk = 'public')
    {
        return Storage::disk($disk)->exists($path);
    }
}
