<?php declare(strict_types = 1);

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AdListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'dateStart' => $this->dateStart,
            'dateEnd' => $this->dateEnd,
            'usdDaily' => $this->usdDaily,
            'usdTotal' => $this->usdTotal,
            'images' => AdRecordImagesResource::collection($this->images),
        ];
    }
}
