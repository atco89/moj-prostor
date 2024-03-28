<?php

namespace App\Models;

use App\Models\Scopes\WithoutTrashedScope;
use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Ramsey\Uuid\Uuid;
use Throwable;


/**
 * @property integer     $id
 * @property string      $uid
 * @property Carbon      $created_at
 * @property Carbon      $updated_at
 * @property Carbon|null $deleted_at
 */
abstract class Base extends Model
{
    use SoftDeletes, HasFactory, Notifiable;


    /**
     * @var string[]
     */
    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * @return void
     */
    protected static function booted(): void
    {
        parent::booted();
        static::addGlobalScope(scope: new WithoutTrashedScope());
    }

    /**
     * @return void
     */
    protected static function booting(): void
    {
        parent::booting();
        static::creating(callback: fn(self $model) => static::onCreate(model: $model));
        static::updating(callback: fn(self $model) => static::onUpdate(model: $model));
        static::deleting(callback: fn(self $model) => static::onDelete(model: $model));
    }

    /**
     * @param Base $model
     *
     * @return void
     * @throws Throwable
     */
    protected static function onCreate(self $model): void
    {
        $model
            ->set(key: 'uid', value: Uuid::uuid4()->toString())
            ->set(key: 'created_at', value: static::timestamp())
            ->set(key: 'updated_at', value: static::timestamp());
    }

    /**
     * @param string $key
     * @param mixed  $value
     *
     * @return $this
     */
    final public function set(string $key, mixed $value): static
    {
        parent::setAttribute(key: $key, value: $value);
        return $this;
    }

    /**
     * @return DateTimeInterface
     */
    final protected static function timestamp(): DateTimeInterface
    {
        return now();
    }

    /**
     * @param Base $model
     *
     * @return void
     * @throws Throwable
     */
    protected static function onUpdate(self $model): void
    {
        $model
            ->set(key: 'updated_at', value: static::timestamp());
    }

    /**
     * @param Base $model
     *
     * @return void
     * @throws Throwable
     */
    protected static function onDelete(self $model): void
    {
        $model
            ->set(key: 'deleted_at', value: static::timestamp())
            ->update();
    }

    /**
     * @return string
     */
    public function getUid(): string
    {
        return $this->uid;
    }
}
