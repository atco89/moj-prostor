<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;
use Throwable;


/**
 * @property string     $name
 * @property string     $description
 * @property float      $longitude
 * @property float      $latitude
 * @property int        $number_of_reviews
 * @property int        $score
 * @property float      $average
 * @property User       $user
 * @property Collection $reviews
 */
class Space extends Base
{

    /**
     * @var string[]
     */
    protected $fillable = [
        'name',
        'description',
        'longitude',
        'latitude',
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'longitude' => 'float',
        'latitude' => 'float',
        'number_of_reviews' => 'integer',
        'score' => 'integer',
        'average' => 'float',
    ];

    /**
     * @param Base $model
     *
     * @return void
     * @throws Throwable
     */
    protected static function onCreate(Base $model): void
    {
        parent::onCreate($model);
        $model
            ->set(key: 'number_of_reviews', value: 0)
            ->set(key: 'score', value: 0)
            ->set(key: 'average', value: 0.00);
    }

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
