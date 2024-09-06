<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class WaterMarkResource extends JsonResource
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
            'company' => $this?->company?->name ? $this?->company?->name : '',
            'video_watermark' => $this->video_watermark ? env('APP_IMAGE_URL') . 'watermark/' . $this->video_watermark : '',
            'white_logo' => $this->white_logo ? env('APP_IMAGE_URL') . 'watermark/' . $this->white_logo : '',
        ];
    }
}
