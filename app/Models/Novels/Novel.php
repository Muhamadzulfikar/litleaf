<?php

namespace App\Models\Novels;

use App\Models\User;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Novel extends Model
{
    use HasFactory;
    use HasUuids;

    protected $table = 'novels';

    protected $primaryKey = 'uuid';

    protected $fillable = [
        'user_uuid',
        'name',
        'description',
        'cover',
        'is_publish',
        'is_private',
    ];

    protected $casts = [
        'is_private' => 'boolean',
        'is_publish' => 'boolean',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    public function genre(): BelongsToMany
    {
        return $this->belongsToMany(Genre::class, 'novel_genre', 'novel_uuid', 'genre_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_uuid', 'uuid');
    }

    public function novelGenre(): HasMany
    {
        return $this->hasMany(NovelGenre::class, 'novel_uuid', 'uuid');
    }
}
