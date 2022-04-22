<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PlaceBid extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'location' => [
                'required', 
                'string', 
                'max:255'],

            'city' => [
                'required', 
                'string', 
                'max:255'
            ],
            'county' => [
                'required',
                'string',
            ],
            'payment' => [
                'required',
                'string',
            ],
            'carts' => [
                'required',
            ],
            'user_id' => [
                'required',
                'integer',
            ],
            
        ];
    }
}