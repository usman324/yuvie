<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CompanyVideoResource extends JsonResource
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
            'user' => $this->user,
            'company' => $this->company?->name,
            'company_url' => $this->company?->companyDetail?->company_website_url ? $this->company?->companyDetail?->company_website_url : '',
            'company_icon' => $this?->company?->getLogo() ? env('APP_IMAGE_URL') . 'watermark/' . $this?->company->getLogo() : '',
            'title' => $this->title,
            'alpha' => $this->alpha != 0 ? true : false,
            'description' => $this->description ? $this->description : '',
            'video' => $this->video ? env('APP_IMAGE_URL') . 'video/' . $this->video : '',
            'outer_video' => $this->outer_video ? env('APP_IMAGE_URL') . 'video/' . $this->outer_video : '',
            'intro_video' => $this->intro_video ? env('APP_IMAGE_URL') . 'video/' . $this->intro_video : '',
            'thumbnail_image' => $this?->thumbnail_image ? env('APP_IMAGE_URL') . 'video/' . $this->thumbnail_image : '',
        ];
    }
}
