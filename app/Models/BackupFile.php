<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BackupFile extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'path',
        'type',
        'size',
        'version_number',
        'file_id',
        'user_id',
    ];

    public function file()
    {
        return $this->belongsTo(File::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public static function boot()
    {
        parent::boot();

        static::creating(function ($backupFile) {
            $latestBackup = BackupFile::where('file_id', $backupFile->file_id)
                ->orderBy('version_number', 'desc')
                ->first();

            if ($latestBackup) {
                $backupFile->version_number = $latestBackup->version_number + 1;
            } else {
                $backupFile->version_number = 1;
            }
        });
    }


}
