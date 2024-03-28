<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\MessageBag;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\JsonResponse;
use Throwable;


abstract class Error extends Exception
{

    /**
     * @param string|MessageBag $errors
     * @param Throwable|null    $throwable
     */
    public function __construct(
        protected string|MessageBag $errors,
        protected Throwable|null    $throwable = null,
    ) {
        parent::__construct(message: $throwable?->getMessage() ?? null, previous: $this->throwable);
    }

    /**
     * @return void
     */
    public function report(): void
    {
        Log::error(message: $this->message);
    }

    /**
     * @return JsonResponse
     */
    final public function render(): JsonResponse
    {
        return response()->json(data: $this->data(), status: $this->statusCode());
    }

    /**
     * @return array
     */
    public function data(): array
    {
        return [
            'cid' => Uuid::uuid4()->toString(),
            'timestamp' => now()->getTimestamp(),
            'messages' => $this->errors,
        ];
    }

    /**
     * @return int
     */
    abstract protected function statusCode(): int;
}
