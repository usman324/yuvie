<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class VideoResource extends JsonResource
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
            'id'=>$this->id,
            'user' => $this->user,
            'company' => $this->company?->name,
            'title' => $this->title,
            'description' => $this->description,
            'video' =>env('APP_IMAGE_URL').'video/'.$this->video,
            // 'thumbnail_image' =>env('APP_IMAGE_URL').'video/'.$this->thumbnail_image,
        ];
    }
}
