<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Http\Resources\CategorySimpleResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CategoryNestedResourceCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "data" => CategorySimpleResource::collection($this->collection),
            "total" => count($this->collection)
        ];
    }
}
