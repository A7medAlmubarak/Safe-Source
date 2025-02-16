<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Group extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'owner_id'
    ];

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    /**
     * Get the files associated with the group through fileGroup.
     */
    public function files()
    {
        return $this->belongsToMany(File::class, 'file_groups');
    }

    /**
     * Get the users associated with the group through group_users.
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'group_users', 'group_id', 'user_id');
    }



}
