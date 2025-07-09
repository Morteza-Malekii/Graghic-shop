<?php
namespace App\Filters;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

abstract class QueryFilter
{
    protected Request $request;
    protected Builder $builder;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    abstract public function allowed(): array;

    public function apply(Builder $builder): Builder
    {
        $this->builder = $builder;
        foreach ($this->request->only($this->allowed()) as $name => $value) {
            if ($value === null || $value === '') continue;
            if (! method_exists($this, $name)) continue;
            $this->$name($value);
        }
        return $this->builder;
    }
}
