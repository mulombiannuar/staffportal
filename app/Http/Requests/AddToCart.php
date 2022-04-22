<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class AddToCart extends FormRequest
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
            'customer_name' => [
                'required', 
                'string', 
                'max:255'],

            'customer_mobile' => [
                'required',
                'digits:10', 
                'max:10', 
                'min:10'
            ],
            'bid_amount' => [
                'required',
                'numeric',
            ],
            'customer_id' => [
                'required',
                'integer',
            ],
            'product_id' => [
                'required',
                'integer',
                'exists:products,product_id'
            ],
            
        ];
    }
}