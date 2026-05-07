<?php
namespace App\Models\tokens;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
 
class AccessToken extends Model
{

    protected $table = 'access_tokens';

    protected $fillable = [
        'token',
        'name',
        'user_uuid',
    ];
}