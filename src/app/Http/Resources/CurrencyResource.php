<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CurrencyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $currency = $this[0][0]->currency;

        return [
            'name' => $currency->name,
            'image' => $currency->image_url,
            'data' => CurrencyListResource::collection($this[0]),
        ];
    }
}
