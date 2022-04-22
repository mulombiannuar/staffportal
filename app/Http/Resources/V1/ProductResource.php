<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'product_id' => $this->product_id,
            'product_name' => $this->product_name,
            'slug' => $this->slug,
            'chassis_number' => $this->chassis_number,
            'mileage' => $this->mileage,
            'color' => $this->color,
            'engine' => $this->engine,
            'reg_no' => $this->reg_no,
            'condition' => $this->condition,
            'location' => $this->location,
            'image' => $this->images,
            'additional_info' => $this->additional_info,
            'date_purchased' => $this->date_purchased,
            'outpost_name' => $this->outpost_name,
            'branch_name' => $this->branch_name,
            'type_name' => $this->type_name,
            'category_name' => $this->category_name,
            'disposal_price' => $this->disposal_price,
            'purchase_price' => $this->purchase_price,
            'image_url' => asset('storage/assets/app/images/products/'.$this->images),
        ];
    }
}