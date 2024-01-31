<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property User $user
 * @property Space $space
 * @property Category $category
 * @property int $rate
 * @property string|null $description
 */
class SpaceReview extends Base
{

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(related: User::class);
    }

    /**
     * @return BelongsTo
     */
    public function space(): BelongsTo
    {
        return $this->belongsTo(related: Space::class);
    }

    /**
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(related: Category::class);
    }
}
