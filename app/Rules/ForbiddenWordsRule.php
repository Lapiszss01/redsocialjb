<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\Rule;

class ForbiddenWordsRule implements Rule
{
    protected $palabrasProhibidas = ['spam', 'ofensivo', 'prohibido'];

    public function __construct()
    {
        //
    }

    public function passes($attribute, $value)
    {
        foreach ($this->palabrasProhibidas as $palabra) {
            if (stripos($value, $palabra) !== false) {
                return false;
            }
        }
        return true;
    }

    public function message()
    {
        return 'El campo :attribute contiene palabras prohibidas.';
    }
}
