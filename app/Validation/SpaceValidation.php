<?php

namespace App\Validation;

class SpaceValidation extends Validation
{
    use Rules;


    /**
     * @param int|null $key
     *
     * @return array
     */
    protected function rules(int|null $key = null): array
    {
        return [
            'name' => [
                $this->required(),
                $this->string(),
                $this->max(length: 255),
                $this->unique(table: 'spaces', column: 'name', key: $key),
            ],
            'description' => [
                $this->nullable(),
                $this->string(),
            ],
            'longitude' => [
                $this->required(),
                $this->numeric(),
                $this->between(min: -180, max: 180),
            ],
            'latitude' => [
                $this->required(),
                $this->numeric(),
                $this->between(min: -90, max: 90),
            ],
        ];
    }

    /**
     * @return array
     */
    protected function messages(): array
    {
        return [
            'name.required' => trans(key: 'validation.Polje za ime je obavezno.'),
            'name.string' => trans(key: 'validation.Ime mora biti tekstualni niz.'),
            'name.max' => trans(key: 'validation.Ime ne sme biti duže od 255 karaktera.'),
            'name.unique' => trans(key: 'validation.Ime je već zauzeto.'),
            'description.string' => trans(key: 'validation.Opis mora biti tekstualni niz.'),
            'longitude.required' => trans(key: 'validation.Polje za geografsku dužinu je obavezno.'),
            'longitude.numeric' => trans(key: 'validation.Geografska dužina mora biti broj.'),
            'longitude.between' => trans(key: 'validation.Geografska dužina mora biti između -180 i 180 stepeni.'),
            'latitude.required' => trans(key: 'validation.Polje za geografsku širinu je obavezno.'),
            'latitude.numeric' => trans(key: 'validation.Geografska širina mora biti broj.'),
            'latitude.between' => trans(key: 'validation.Geografska širina mora biti između -90 i 90 stepeni.'),
        ];
    }
}
