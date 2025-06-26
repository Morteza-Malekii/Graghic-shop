<?php
namespace App\Filters;

class ProductFilter extends QueryFilter
{
    public function allowed(): array
    {
        return ['search','categories','price_min','price_max','orderby'];
    }

    public function search(string $term)
    {
        $this->builder->where('title', 'like', "%{$term}%");
    }

    public function categories(array $ids)
    {
        $this->builder->whereIn('category_id', $ids);
    }

    public function price_min($min)
    {
        $this->builder->where('price', '>=', (float)$min);
    }

    public function price_max($max)
    {
        $this->builder->where('price', '<=', (float)$max);
    }

    public function orderby(string $mode)
    {
        match($mode) {
            'lowToHigh'  => $this->builder->orderBy('price','asc'),
            'highToLow'  => $this->builder->orderBy('price','desc'),
            'newest'     => $this->builder->orderBy('created_at','desc'),
            'mostPopular'=> $this->builder->orderBy('sold_count','desc'),
            default      => null,
        };
    }
}
