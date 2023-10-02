<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LinkResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'full_reference' => $this->full_reference,
            'short_reference' => $this->short_reference,
            'created_at' => $this->created_at->format('d.m.Y'),
        ];
    }
}
