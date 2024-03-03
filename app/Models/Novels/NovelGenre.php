<?php

namespace App\Models\Novels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NovelGenre extends Model
{
    use HasFactory;

    protected $table = 'novel_genre';

    protected $primaryKey = 'id';

    protected $fillable = [
        'novel_uuid',
        'genre_id',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    public function novel(): BelongsTo
    {
        return $this->belongsTo(Novel::class, 'novel_uuid', 'uuid');
    }

    public function genre(): BelongsTo
    {
        return $this->belongsTo(Genre::class, 'genre_id', 'id');
    }
}
