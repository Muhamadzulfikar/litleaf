<?php

namespace App\Models\Novels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Genre extends Model
{
    use HasFactory;

    protected $table = 'genre';

    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    public function novel(): BelongsToMany
    {
        return $this->belongsToMany(Novel::class, 'novel_genre', 'genre_id', 'novel_uuid');
    }

    public function novelGenre(): HasMany
    {
        return $this->hasMany(NovelGenre::class, 'genre_id', 'id');
    }
}
