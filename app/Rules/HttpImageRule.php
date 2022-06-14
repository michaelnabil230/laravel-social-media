<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class HttpImageRule implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        return ! preg_match('/!\[.*\]\(http:\/\/.*\)/', $value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return 'The :attribute field contains at least one image with an HTTP link.';
    }
}
