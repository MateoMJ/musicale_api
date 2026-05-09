<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Calendar extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'date_string',
        'day',
        'month',
        'year',
        'is_weekday',
        'is_business_day',
        'is_holiday',
        'holiday_name'
    ];

    public function event(): HasMany
    {
        return $this->hasMany(Event::Class);
    }

}