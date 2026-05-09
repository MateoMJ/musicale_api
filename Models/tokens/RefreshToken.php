<?php
namespace App\Models\tokens;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
 
class RefreshToken extends Model
{

    protected $table = 'refresh_tokens';

    protected $fillable = [
        'token',
        'name',
        'user_id',
    ];
}