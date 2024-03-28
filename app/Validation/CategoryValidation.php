<?php

namespace App\Validation;

class CategoryValidation extends Validation
{
    use Rules;


    /**
     * @param int|null $key
     *
     * @return array[]
     */
    protected function rules(int|null $key = null): array
    {
        return [
            'name' => [
                $this->required(),
                $this->max(length: 45),
                $this->unique(table: 'categories', column: 'name', key: $key),
            ],
        ];
    }

    /**
     * @return string[]
     */
    protected function messages(): array
    {
        return [
            'name.required' => trans(key: 'validation.Naziv kategorije je obavezan za unos.'),
            'name.max' => trans(key: 'validation.Naziv kategorije ne sme premašiti 45 karaktera.'),
            'name.unique' => trans(key: 'validation.Naziv kategorije već postoji. Molimo izaberite drugačiji naziv.'),
        ];
    }
}
