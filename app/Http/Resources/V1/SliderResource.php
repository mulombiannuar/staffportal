<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class SliderResource extends JsonResource
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
            'slider_id' => $this->slider_id,
            'title' => $this->title,
            'description' => $this->description,
            'description' => $this->description,
            'link_text' => $this->link_text,
            'link_url' => $this->link_url,
            'image' => $this->image,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'image_url' => asset('storage/assets/app/images/sliders/'.$this->image),
        ];
    }
}