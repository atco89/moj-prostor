<?php

namespace App\Models;

use App\Notifications\AccountVerificationNotification;
use App\Notifications\PasswordRecoveryNotification;
use Carbon\Carbon;
use Throwable;


/**
 * @property string   $name
 * @property string   $email
 * @property string   $email_verified_at
 * @property string   $password
 * @property string   $remember_token
 * @property string[] $roles
 */
class User extends Auth
{

    /**
     * @var string[]
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'roles' => 'array',
    ];

    /**
     * @return int
     */
    public function getJWTIdentifier(): int
    {
        return $this->getKey();
    }

    /**
     * @return array
     */
    public function getJWTCustomClaims(): array
    {
        return [
            'uid' => $this->uid,
            'name' => $this->name,
            'email' => $this->email,
        ];
    }

    /**
     * @return bool
     */
    public function hasVerifiedEmail(): bool
    {
        return $this->email_verified_at instanceof Carbon;
    }

    /**
     * @return void
     * @throws Throwable
     */
    public function markEmailAsVerified(): void
    {
        $this
            ->set(key: 'email_verified_at', value: now())
            ->saveOrFail();
    }

    /**
     * @return void
     */
    public function sendEmailVerificationNotification(): void
    {
        $this->notify(instance: new AccountVerificationNotification());
    }

    /**
     * @return string
     */
    public function getEmailForVerification(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getEmailForPasswordReset(): string
    {
        return $this->email;
    }

    /**
     * @param $token
     *
     * @return void
     */
    public function sendPasswordResetNotification($token): void
    {
        $this->notify(instance: new PasswordRecoveryNotification(token: $token));
    }
}
