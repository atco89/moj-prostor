<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

/**
 * @property string $name
 * @property string $description
 * @property float $longitude
 * @property float $latitude
 * @property int $number_of_reviews
 * @property int $score
 * @property float $average
 * @property User $user
 * @property Collection $reviews
 */
class Space extends Base
{

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(related: User::class);
    }

    /**
     * @return HasMany
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(related: SpaceReview::class);
    }
}
