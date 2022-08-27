<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Application extends Model
{
    use SoftDeletes, HasFactory;

    protected $primaryKey = 'application_id';

    protected $fillable = [
        'user_id',
        'name',
        'app_code',
        'description',
    ];

    /**
     * @return string
     */
    public function getRouteKeyName(): string
    {
        return 'app_code';
    }

    //RELATIONSHIPS

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    /**
     * @return HasMany
     */
    public function versions(): HasMany
    {
        return $this->hasMany(Version::class, 'application_id', 'application_id')
            ->orderByDesc('created_at');
    }
}
