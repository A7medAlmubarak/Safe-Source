<?php
namespace App\Aspects;

use App\Models\File;
use App\Services\ChangeService;
use App\Services\HistoryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Throwable;

class ChangeAspect
{
    protected $changeService;
    protected $differences;
    protected $historyService;

    public function __construct(ChangeService $changeService, HistoryService $historyService)
    {
        $this->changeService = $changeService;
        $this->historyService = $historyService;
    }

    public function before(Request $request): void
    {
        try {
            // Access the ID from the route
            $id = $request->route('id');

            // Retrieve the original file
            $originalFile = File::findOrFail($id);
            $newFile = $request->file('file');
            if ($newFile) {
                // Get the old file path
                $oldFilePath = $originalFile->path;
                // Compare the original file with the new file
                $this->differences = $this->changeService->compareFiles($oldFilePath, $newFile);
            }
        } catch (Throwable $e) {
            Log::error("Error in before method: " . $e->getMessage());
        }
    }

    public function after(Request $request, $response): void
    {
        try {
            // Check if the request was successful
            if ($response->isSuccessful()) {
                $this->historyService->createHistory
                ($request->route('id'), auth()->user()->id, 'edit' , $this->differences);
            }
        } catch (Throwable $e) {
            Log::error("Error in after method: " . $e->getMessage());
        }
    }

}
