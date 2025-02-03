<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Http\Resources\ItemResource;

class ItemCollection extends ResourceCollection
{


    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'items'  => $this->collection->map(function($items) {
                return new ItemResource($items);
            }),
        ];
    }
}
