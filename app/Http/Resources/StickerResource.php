<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StickerResource extends JsonResource
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
            'id' => $this->id,
            // 'name' => $this->name ? $this->name : '',
            'company' => $this?->company?->name ? $this?->company?->name : '',
            'image' => $this->image ? env('APP_IMAGE_URL') . 'sticker/' . $this->image : '',
        ];
    }
}
