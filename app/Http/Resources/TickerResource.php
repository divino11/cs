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
            'bid' => rtrim($this->bid, '\0.'),
            'ask' => rtrim($this->ask, '\0.'),
            'high_price' => rtrim($this->high_price, '\0.'),
            'low_price' => rtrim($this->low_price, '\0.'),
            'volume' => rtrim($this->volume, '\0.')
        ];
    }
}
