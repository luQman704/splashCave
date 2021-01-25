<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;

class PostCollection extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

        return [
            'id' => $this->id,
            'name' => $this->title,
            'message' => $this->message,
            'category' => $this->category,
            'images'  => PostImagesCollection::collection($this->postImages),
            'user'  =>   $this->user,
            'price' => $this->price,
        ];
    }
}
