<?php

namespace App\Validation;

trait Rules
{

    /**
     * @return string
     */
    public function required(): string
    {
        return 'required';
    }

    /**
     * @param int $length
     *
     * @return string
     */
    public function max(int $length): string
    {
        return sprintf('max:%d', $length);
    }

    /**
     * @param string      $table
     * @param string      $column
     * @param string|null $key
     *
     * @return string
     */
    public function unique(string $table, string $column, string|null $key = null): string
    {
        return empty($key)
            ? sprintf('unique:%s,%s', $table, $column)
            : sprintf('unique:%s,%s,%d', $table, $column, $key);
    }

    /**
     * @return string
     */
    public function nullable(): string
    {
        return 'nullable';
    }

    /**
     * @param int $length
     *
     * @return string
     */
    public function min(int $length): string
    {
        return sprintf('min:%d', $length);
    }

    /**
     * @return string
     */
    public function email(): string
    {
        return 'email';
    }

    /**
     * @return string
     */
    public function string(): string
    {
        return 'string';
    }

    /**
     * @return string
     */
    public function alpha(): string
    {
        return 'regex:/^[a-zA-ZčćđšžČĆĐŠŽ]+$/u';
    }

    /**
     * @return string
     */
    public function numeric(): string
    {
        return 'numeric';
    }

    /**
     * @return string
     */
    public function integer(): string
    {
        return 'integer';
    }

    /**
     * @param int $min
     * @param int $max
     *
     * @return string
     */
    public function between(int $min, int $max): string
    {
        return sprintf('between:%d,%d', $min, $max);
    }
}
