<?php

namespace App\Providers;

use App\Models\SpaceReview;
use App\Observers\SpaceReviewObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;


class EventServiceProvider extends ServiceProvider
{

    /**
     * @var string[][]
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * @return void
     */
    public function boot(): void
    {
        parent::boot();
        SpaceReview::observe(classes: SpaceReviewObserver::class);
    }

    /**
     * @return bool
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
