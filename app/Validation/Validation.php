<?php

namespace App\Validation;

use Illuminate\Support\Facades\Validator as v;
use Illuminate\Validation\Validator;


abstract class Validation
{

    /**
     * @param array    $data
     * @param int|null $key
     *
     * @return Validator
     */
    public function validation(array $data, int|null $key = null): Validator
    {
        return v::make(data: $data, rules: $this->rules(key: $key), messages: $this->messages());
    }

    /**
     * @param int|null $key
     *
     * @return array
     */
    abstract protected function rules(int|null $key = null): array;

    /**
     * @return array
     */
    abstract protected function messages(): array;
}
