<?php

namespace App\Validation;

class UserValidation extends Validation
{
    use Rules;


    /**
     * @param int|null $key
     *
     * @return array[]
     */
    protected function rules(int|null $key = null): array
    {
        $rules = [
            'name' => [
                $this->required(),
                $this->string(),
                $this->max(length: 255),
                $this->unique(table: 'users', column: 'name', key: $key),
            ],
            'email' => [
                $this->required(),
                $this->string(),
                $this->email(),
                $this->max(length: 255),
                $this->unique(table: 'users', column: 'email', key: $key),
            ],
            'password' => $key
                ? [
                    $this->nullable(),
                    $this->string(),
                    $this->min(length: 6),
                ]
                : [
                    $this->required(),
                    $this->string(),
                    $this->min(length: 6),
                ],
        ];

        if (!auth()->guest()) {
            $rules['roles'] = [
                $this->required(),
            ];
        }

        return $rules;
    }

    /**
     * @return string[]
     */
    protected function messages(): array
    {
        return [
            'name.required' => trans(key: 'validation.Polje za ime je obavezno.'),
            'name.string' => trans(key: 'validation.Ime mora biti tekstualni niz.'),
            'name.max' => trans(key: 'validation.Ime ne sme biti duže od 255 karaktera.'),
            'name.unique' => trans(key: 'validation.Ime je već zauzeto.'),
            'email.required' => trans(key: 'validation.Polje za e-mail je obavezno.'),
            'email.string' => trans(key: 'validation.E-mail mora biti tekstualni niz.'),
            'email.email' => trans(key: 'validation.E-mail mora biti validna adresa.'),
            'email.max' => trans(key: 'validation.E-mail ne sme biti duži od 255 karaktera.'),
            'email.unique' => trans(key: 'validation.E-mail je već zauzet.'),
            'password.required' => trans(key: 'validation.Polje za lozinku je obavezno prilikom kreiranja novog korisnika.'),
            'password.string' => trans(key: 'validation.Lozinka mora biti tekstualni niz.'),
            'password.min' => trans(key: 'validation.Lozinka mora imati najmanje 6 karaktera.'),
        ];
    }
}
