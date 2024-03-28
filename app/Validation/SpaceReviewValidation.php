<?php

namespace App\Validation;

class SpaceReviewValidation extends Validation
{
    use Rules;


    /**
     * @param int|null $key
     *
     * @return array
     */
    protected function rules(?int $key = null): array
    {
        return [
            'rate' => [
                $this->required(),
                $this->integer(),
                $this->between(min: 1, max: 5),
            ],
            'description' => [
                $this->required(),
                $this->string(),
            ],
        ];
    }

    /**
     * @return array
     */
    protected function messages(): array
    {
        return [
            'rate.required' => trans(key: 'validation.Polje za ocenu je obavezno.'),
            'rate.integer' => trans(key: 'validation.Ocena mora biti ceo broj.'),
            'rate.between' => trans(key: 'validation.Ocena mora biti između 1 i 5.'),
            'description.required' => trans(key: 'validation.Polje za opis je obavezno.'),
            'description.string' => trans(key: 'validation.Opis mora biti tekstualni niz.'),
        ];
    }
}
