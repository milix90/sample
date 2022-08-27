<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Version extends Model
{
    use SoftDeletes, HasFactory;

    /**
     * @var string
     */
    protected $primaryKey = 'version_id';

    /**
     * @var string[]
     */
    protected $fillable = [
        'application_id',
        'app_file',
        'images',
        'version',
        'change_log',
        'status',
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'images' => 'array',
    ];


    /**
     * @param $q
     * @return mixed
     */
    public function scopeProgress($q)
    {
        return $q->where('status', 'in_progress');
    }

    /**
     * @return string
     */
    public function getRouteKeyName(): string
    {
        return 'version';
    }

    //RELATIONSHIPS

    /**
     * @return BelongsTo
     */
    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class, 'application_id', 'application_id');
    }
}
