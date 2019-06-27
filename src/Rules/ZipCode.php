<?php

namespace Valii\Rules;

use Illuminate\Contracts\Validation\Rule;

class ZipCode implements Rule
{
    public $parameters;

    public function __construct($parameters = [])
    {
        $this->parameters = $parameters;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @SuppressWarnings("unused")
     *
     * @param  string $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $regex = '/^\d{3}\-?\d{4}$/';

        // in strict mode, $value must include a hyphen
        if ($this->parameters[0] == 'strict') {
          $regex = '/^\d{3}\-\d{4}$/';
        }
        return preg_match($regex, $value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute is not a valid ZIP Code.';
    }
}
