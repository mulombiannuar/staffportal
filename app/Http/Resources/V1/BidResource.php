<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class BidResource extends JsonResource
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
            'order_id' => $this->order_id,
            'order_chosen' => $this->order_chosen,
            'customer_id' => $this->customer_id,
            'customer_name' => $this->customer_name,
            'customer_mobile' => $this->customer_mobile,
            'bid_amount' => $this->bid_amount,
            'bid_number' => $this->bid_number,
            'disposal_price' => $this->disposal_price,
            'bid_date' => $this->bid_date,
            'status' => $this->status,
            'slug' => $this->slug,
            'location' => $this->location,
            'city' => $this->city,
            'county' => $this->county,
            'payment' => $this->payment,
            'product_name' => $this->product_name,
            'image_url' => asset('storage/assets/app/images/products/'.$this->images),
        ];
    }
}