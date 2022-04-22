<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ExpiryDate implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($date_issued)
    {
        $this->date_issued = $date_issued;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
       return $value >  $this->date_issued;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Expiration date must be greater than issuance date';
    }
}