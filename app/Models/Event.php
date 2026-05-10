<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Event extends Model
{
    public $timestamps = false;
    public $incrementing = false;
    protected $keyType = 'string';
    protected $primaryKey = 'uuid';

    protected $fillable = [
        'uuid',
        'name',
        'description',
        'event_type',
        'location',
        'hour',
        'user_uuid',
    ];

    public function calendar(): BelongsTo
    {
        return $this->belongsTo(Calendar::Class, 'date_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::Class);
    }
}