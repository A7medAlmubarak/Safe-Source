<?php

namespace App\Services\Export;

use Symfony\Component\HttpFoundation\BinaryFileResponse;

class CsvExport implements ExportInterface
{
    private string $file_name;
    protected array $data;

    public function __construct(string $file_name)
    {
        $this->file_name = $file_name;
        $this->data = []; // Initialize as empty
    }

    public function setData(array $data): void
    {
        $this->data = $data;
    }

    public function export(): BinaryFileResponse
    {
        $fileName = $this->file_name . '.csv'; // Ensure the file extension is correct
        $filePath = storage_path('app/' . $fileName);

        // Open a file in write mode
        $file = fopen($filePath, 'w');

        // Check if data is not empty and is an array of arrays
        if (!empty($this->data) && is_array($this->data)) {
            // Write the header row if the first row is an array
            if (is_array($this->data[0])) {
                fputcsv($file, array_keys($this->data[0])); // Write header row
            }

            foreach ($this->data as $row) {
                // Ensure each row is an array
                if (is_array($row)) {
                    fputcsv($file, $row);
                } else {
                    throw new \Exception("Row data must be an array. Received: " . print_r($row, true));
                }
            }
        } else {
            throw new \Exception("No data available to export.");
        }

        fclose($file); // Close the file

        // Return the file as a download response
        return response()->download($filePath)->deleteFileAfterSend();
    }
}
