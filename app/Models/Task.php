<?php

namespace App\Models;

use App\Traits\ModelBootingTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Task extends Model
{
    use HasFactory, ModelBootingTrait, SoftDeletes, HasSlug;

    protected $guarded = [
        "id",
        "uuid",
        "created_at",
        "deleted_at",
    ];

    protected $fillable = [
        "task",
        "description",
    ];

    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('task')
            ->saveSlugsTo('slug');
    }

    public function user(): BelongsTo{
        return $this->belongsTo(User::class);
    }
}
