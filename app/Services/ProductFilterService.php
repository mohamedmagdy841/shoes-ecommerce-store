<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Product;

class ProductFilterService
{
    public function getFilters()
    {
        return [
            'categories' => Category::all(),
            'brands' => Product::groupBy('brand')->pluck('brand'),
            'colors' => Product::groupBy('color')->pluck('color'),
        ];
    }

    public function filterProducts($filters)
    {
        return Product::with('images')
            ->active()
            ->when(!empty($filters['categories']), function ($query) use ($filters) {
                return $query->whereIn('category_id', $filters['categories']);
            })
            ->when(!empty($filters['brands']), function ($query) use ($filters) {
                return $query->whereIn('brand', $filters['brands']);
            })
            ->when(!empty($filters['colors']), function ($query) use ($filters) {
                $query->whereIn('color', $filters['colors']);
            })
            ->when($filters['price_range'] ?? null, function ($query) use ($filters) {
                $this->applyPriceFilter($query, $filters['price_range']);
            })
            ->when($filters['sort_by'] ?? null, function ($query) use ($filters) {
                $this->applySorting($query, $filters['sort_by']);
            })
            ->paginate(12)
            ->withQueryString();
    }

    private function applyPriceFilter($query, array $priceRanges)
    {
        $query->where(function ($q) use ($priceRanges) {
            $ranges = [
                '50-100' => [50, 100],
                '100-150' => [100, 150],
                '150-200' => [150, 200],
            ];

            foreach ($priceRanges as $range) {
                if ($range === '200-above') {
                    $q->orWhere('price', '>=', 200);
                } elseif (isset($ranges[$range])) {
                    $q->orWhereBetween('price', $ranges[$range]);
                }
            }
        });
    }


    private function applySorting($query, $sortBy)
    {
        $sortingOptions = [
            'price_asc' => ['price', 'asc'],
            'price_desc' => ['price', 'desc'],
        ];

        if (isset($sortingOptions[$sortBy])) {
            [$column, $direction] = $sortingOptions[$sortBy];
            $query->orderBy($column, $direction);
        }
    }
}
