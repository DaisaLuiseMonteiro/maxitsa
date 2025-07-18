<?php

namespace App\Core;


class Validator
{
    public static $validators = [];
    private static $errors = [];

    public static function validate(array $data, array $rules)
    {
        self::$validators = [
            Validate::IS_EMPTY->value => function ($champ, $value): void {
                if (empty($value)) {
                    self::$errors[$champ] = "Le champ $champ est vide .";
                }
            },
            Validate::IS_EMAIL->value => function ($champ, $email): void {
                if (!preg_match('/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/', $email)) {
                    self::$errors[$champ] = "Le champ $champ est dois contenir un mail .";
                }
            },
            Validate::IS_LENGTH->value => function ($champ, $value, $max, $min = 1): void {
                if (!($max > $min)) {
                    if ($value > $min && $value < $max) {
                        self::$errors[$champ] = "Le champ $champ dois etre entre $min et $max .";
                    }
                } else {
                    throw new \Exception("Le max $max dois etre superieur au min $min ", 1);
                }
            },
            Validate::IS_CNI->value => function ($champ, $cni): void {
                if (!preg_match('/^[1-2]+[0-9]{12}$/', $cni)) {
                    self::$errors[$champ] = "Le champ $champ dois contenir un $champ contenant 13 caracteres .";
                }
            },
            Validate::IS_TELEPHONE->value => function ($champ, $telephone): void {
                if (preg_match('/^[78|77|70|76|75]+[0-9]{7}$/', $telephone)) {
                    self::$errors[$champ] = "Le champ $champ est dois etre un numero .";
                }
            }
        ];

        foreach ($data as $champ => $value) {
            foreach ($rules[$champ] as $validator) {
                self::$validators[$validator->value]($champ, $value);
            }
        }
    }


    public static function is_valide(): bool
    {
        return empty(self::$errors);
    }


    public static function getErrors(): array
    {
        return self::$errors;
    }
}
