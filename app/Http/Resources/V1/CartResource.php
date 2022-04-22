<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'cart_id' => $this->cart_id,
            'product_id' => $this->product_id,
            'customer_id' => $this->customer_id,
            'customer_name' => $this->customer_name,
            'customer_mobile' => $this->customer_mobile,
            'bid_date' => $this->bid_date,
            'bid_amount' => $this->bid_amount,
            'product_name' => $this->product_name,
            'type_name' => $this->type_name,
            'category_name' => $this->category_name,
            'reg_no' => $this->reg_no,
            'disposal_price' => $this->disposal_price,
            'purchase_price' => $this->purchase_price,
            'image_url' => asset('storage/assets/app/images/products/'.$this->images),
        ];
    }
}