<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'              => $this->id,
            'item_name'  => $this->item_name,
            'description'   => $this->description,
            'price_per_unit' => $this->price_per_unit,
            'unit'  => $this->unit,
            'vendor_id' => $this->vendor_id,
            'vendor_code'   => $this->vendor_code,
            'vendor_name'   => $this->vendor_name,
            'vendor_item_code'  => $this->vendor_item_code,
            'vendor_item_category'  => $this->vendor_item_category,
            'user_id' => $this->user_id,
            'user_name' => $this->user_name,
            'user_email'    => $this->user_email,
            'item_category_id'  => $this->item_category_id,
            'item_category_name'    => $this->item_category_name,
            'created_at'    => $this->created_at,
            'updated_at'    => $this->updated_at,
            'deleted_at'    => $this->deleted_at,
        ];
    }
}
