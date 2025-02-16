<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ChangeService
{

    public function compareFiles($originalFilePath, UploadedFile $newFile)
    {
        // Ensure the original file exists using the public disk
        if (!Storage::disk('public')->exists($originalFilePath)) {
            return ['error' => 'Original file does not exist.'];
        }

        // Read the contents of the original file
        $originalContent = Storage::disk('public')->get($originalFilePath);

        // Read the contents of the new file
        $newContent = $newFile->get(); // Get the contents of the uploaded file

        // Split the contents into lines
        $originalLines = explode("\n", $originalContent);
        $newLines = explode("\n", $newContent);

        // Compare the files and get the differences
        return $this->getDifferences($originalLines, $newLines);
    }

    private function getDifferences(array $originalLines, array $newLines)
    {
        $differences = [];

        foreach ($originalLines as $lineNumber => $line) {
            if (isset($newLines[$lineNumber])) {
                if ($line !== $newLines[$lineNumber]) {
                    $differences[] = [
                        'line' => $lineNumber + 1,
                        'original' => $line,
                        'new' => $newLines[$lineNumber],
                    ];
                }
            } else {
                // If the new file has fewer lines, treat it as a deletion
                $differences[] = [
                    'line' => $lineNumber + 1,
                    'original' => $line,
                    'new' => null, // Line removed in new file
                ];
            }
        }

        // Check for any additional lines in the new file
        foreach ($newLines as $lineNumber => $line) {
            if (!isset($originalLines[$lineNumber])) {
                // If the original file has fewer lines, treat it as an addition
                $differences[] = [
                    'line' => $lineNumber + 1,
                    'original' => null, // Line added in new file
                    'new' => $line,
                ];
            }
        }

        return $differences;
    }
}
