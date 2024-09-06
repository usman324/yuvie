<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FontResource extends JsonResource
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
            'font' => $this->image ? env('APP_IMAGE_URL') . 'font/' . $this->image : '',
        ];
    }
}
