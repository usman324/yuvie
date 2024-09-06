<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BackgroundMusicResource extends JsonResource
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
            'name' => $this->name ? $this->name : '',
            'company' => $this?->company?->name ? $this?->company?->name : '',
            'audio' => $this->audio ? env('APP_IMAGE_URL') . 'background-music/' . $this->audio : '',
        ];
    }
}
