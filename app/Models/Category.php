<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;


/**
 * @property string     $name
 * @property Collection $reviews
 */
class Category extends Base
{

    /**
     * @var string[]
     */
    protected $fillable = [
        'name',
    ];

    /**
     * @return HasMany
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(related: SpaceReview::class);
    }
}
