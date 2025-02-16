<?php

namespace App\Http\Controllers;

use App\Models\History;
use App\Services\HistoryService;
use App\Http\Resources\HistoryResource;

class HistoryController extends Controller
{
    protected $historyService;

    public function __construct(HistoryService $historyService)
    {
        $this->historyService = $historyService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $history = History::all();
        return HistoryResource::collection($history);
    }

    /**
     * Get history for a specific file.
     */
    public function getHistoryForFile($fileId)
    {
        $history = $this->historyService->getHistoryForFile($fileId);
        return HistoryResource::collection($history);
    }

    /**
     * Get history for a specific user.
     */
    public function getHistoryForUser($userId)
    {
        $history = $this->historyService->getHistoryForUser($userId);
        return HistoryResource::collection($history);
    }

    public function downloadHistoryForFile($fileId)
    {
        return $this->historyService->exportHistoryToPdf($fileId);
    }



}
