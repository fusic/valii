<?php

namespace Valii\Rules;

use Illuminate\Contracts\Validation\Rule;

class MaxByte implements Rule
{
    /**
     * Max byte value
     *
     * @var int
     */
    public $maxByte;

    /**
     * __construct
     *
     * @param int $maxByte
     */
    public function __construct(int $maxByte)
    {
        $this->maxByte = $maxByte;
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
        return mb_strwidth($value) <= $this->maxByte;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute may not be greater than :max bytes.';
    }
}
