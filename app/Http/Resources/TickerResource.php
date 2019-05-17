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
            'last' => rtrim($this->last, '\0.'),
            'volume' => rtrim($this->volume, '\0.')
        ];
    }
}
