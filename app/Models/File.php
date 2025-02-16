<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'path', 'type', 'size', 'isFree', 'owner_id', 'checked_by'];

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function checkedBy()
    {
        return $this->belongsTo(User::class, 'checked_by');
    }
}
