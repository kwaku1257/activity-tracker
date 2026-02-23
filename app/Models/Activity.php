<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'date',
        'status',
        'created_by',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // all updates for this activity, newest first
    public function updates()
    {
        return $this->hasMany(ActivityUpdate::class)->orderBy('created_at', 'desc');
    }

    // just the most recent update
    public function latestUpdate()
    {
        return $this->hasOne(ActivityUpdate::class)->latestOfMany();
    }
}
