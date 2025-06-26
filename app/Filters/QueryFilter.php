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

    // لیست پارامترهایی که فیلتر می‌کنیم
    abstract public function allowed(): array;

    // اجرا روی Query\Builder
    public function apply(Builder $builder): Builder
    {
        $this->builder = $builder;

        foreach ($this->request->only($this->allowed()) as $name => $value) {
            if ($value === null || $value === '') continue;
            if (! method_exists($this, $name)) continue;

            // $this->search($value) یا $this->categories($value) …
            $this->$name($value);
        }

        return $this->builder;
    }
}
