<?php

namespace App\Services;

use App\Interfaces\IHistoryRepository;
use App\Models\History;
use App\Services\Export\CsvExport;
use App\Services\Export\PdfExport;

class HistoryService
{

    protected $historyRepository;
    protected $pdfExport;
    protected $csvExport;

    public function __construct(IHistoryRepository $historyRepository, string $blade_file_name = 'history', string $exported_file_name = 'history_export' , string $csvFileName = 'history_export')
    {
        $this->historyRepository = $historyRepository;
        $this->pdfExport = new PdfExport($blade_file_name, $exported_file_name);
        $this->csvExport = new CsvExport($csvFileName);

    }

    /**
     * Create a new history record.
     *
     * @param int $fileId
     * @param int $userId
     * @param string $status
     * @return History
     */
    public function createHistory(int $fileId, int $userId, string $status , array $changes = null): History
    {
        return $this->historyRepository->create([
            'file_id' => $fileId,
            'user_id' => $userId,
            'status' => $status,
            'changes' => json_encode($changes),
        ]);
    }

    /**
     * Get history records for a specific file.
     *
     * @param int $fileId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getHistoryForFile(int $fileId)
    {
        return $this->historyRepository->getHistoryForFile($fileId);
    }

    /**
     * Get history records for a specific user.
     *
     * @param int $userId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getHistoryForUser(int $userId)
    {
        return $this->historyRepository->getHistoryForUser($userId);
    }


    /**
     * Export history records for a specific file to PDF.
     *
     * @param int $fileId
     * @return \Illuminate\Http\Response
     */
    public function exportHistoryToPdf(int $fileId)
    {
        $data = $this->getHistoryForFile($fileId);
        $this->pdfExport->setData($data->toArray());
        return $this->pdfExport->export();
    }




}
