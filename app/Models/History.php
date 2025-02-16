<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    use HasFactory;
    protected $fillable = [
        'file_id',
        'user_id',
        'status',
        'changes',
    ];

    /**
     * Get the file associated with the history.
     */
    public function file()
    {
        return $this->belongsTo(File::class);
    }

    /**
     * Get the user associated with the history.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }


}
