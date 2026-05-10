<?php
namespace App\Models\tokens;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;

class RefreshToken extends Model
{

    protected $table = 'refresh_tokens';
    public $timestamps = false;

    protected $fillable = [
        'token',
        'name',
        'user_uuid',
        'expires_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_uuid');
    }

}