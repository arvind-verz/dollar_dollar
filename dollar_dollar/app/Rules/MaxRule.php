<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;


class MaxRule implements Rule
{
    protected $max_placement;
    protected $rule;

    public function __construct($max_value, $rule)
    {
        $this->max_placement = $max_value;
        $this->rule = $rule;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string $attribute
     * @param  mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {

        return $value <= $this->max_placement;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {

        return 'The :attribute may not be greater than ' . str_replace('_', ' ', $this->rule) . '.';

    }
}
