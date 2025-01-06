<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // Determine the level of details based on the provided flag
        $isRelatedProduct = $this->resource->is_related ?? false;

        if ($isRelatedProduct) {
            return [
                'id' => $this->id,
                'brand' => $this->brand,
                'name' => $this->name,
                'price' => $this->price,
                'image' => asset($this->images->first()->path),
            ];
        }

        $data = [
            'id' => $this->id,
            'name' => $this->name,
            'brand' => $this->brand,
            'slug' => $this->slug,
            'status'=>$this->status,
            'price' => $this->price,
        ];

        // to return data based on route, show product will return all data
        if($request->is('api/product/*')){
            $data['description']  = $this->description;
            $data['qty']  = $this->qty;
            $data['color']  = $this->color;
            $data['width']  = $this->width;
            $data['height']  = $this->height;
            $data['depth']  = $this->depth;
            $data['weight']  = $this->weight;
            $data['images'] = ImageResource::collection($this->images);
            $data['category'] = CategoryResource::make($this->category);
            $data['reviews'] = ReviewResource::collection($this->reviews);
        }

        return $data;
    }
}
