<?php

namespace App\Http\Resources\Currency;

use App\Http\Resources\CurrencyListResource;
use App\Models\Currency;
use Illuminate\Http\Resources\Json\JsonResource;

class CurrenciesResource extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $currency = $this[0]->Currency;

        return [
            'name' => $currency->name,
            'image' => $currency->image_url,
            'data' => CurrencyListResource::collection($this),
        ];
    }
}
