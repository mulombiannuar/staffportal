<?php

namespace App\Rules;

use App\Models\Products\Motor;
use Illuminate\Contracts\Validation\Rule;

class MileageRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($motor_id)
    {
        $this->motor_id = $motor_id;
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
        $motor = Motor::find($this->motor_id);
        return $value >= $motor->mileage;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Current mileage reading must be greater than previous reading';
    }
}