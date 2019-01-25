<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TickerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'bid' => $this->bid,
            'ask' => $this->ask,
            'high_price' => $this->high_price,
            'low_price' => $this->low_price,
            'volume' => $this->volume
        ];
    }
}
