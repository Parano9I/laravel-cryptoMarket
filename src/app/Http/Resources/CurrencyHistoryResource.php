<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CurrencyHistoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $currency = $this['currency'];

        return [
            'id' => $currency->id,
            'name' => $currency->name,
            'imageUrl' => $currency->image_url,
            'history' => HistoryResource::collection($this['history']),
        ];
    }
}
