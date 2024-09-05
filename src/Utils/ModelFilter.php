<?php

namespace Cloudteam\CoreV2\Utils;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class ModelFilter
{
    public $query;

    public $page;

    public $with;

    public $excludeIds;

    public $includeIds;

    public $orderBy;

    public $queryBy;

    public $direction;

    public $limit;

    public $offset;

    /**
     * @var Builder
     */
    public $builder;

    public $configs = [
        'query'      => '',
        'page'       => 1,
        'excludeIds' => [],
        'includeIds' => [],
        'orderBy'    => 'id',
        'queryBy'    => 'name',
        'direction'  => 'desc',
        'limit'      => 10,
        'with'       => '',
    ];

    public function __construct($builder, $options = [])
    {
        $this->builder = $builder;

        $this->configs = array_merge($this->configs, $options);

        $this->prepareConfig();

        $this->excludeIds = array_filter(Arr::wrap($this->excludeIds));
        $this->includeIds = array_filter(Arr::wrap($this->includeIds));

        $this->offset = ($this->page - 1) * $this->limit;
    }

    private function prepareConfig()
    {
        $request = request();

        $configs = $this->configs;

        foreach ($configs as $key => $config) {
            $value        = $request->input($key);
            $this->{$key} = $value ?? $config;
        }
    }

    public function filter()
    {
        if ($this->excludeIds) {
            $this->builder->exclude($this->excludeIds);
        }

        if ($this->includeIds) {
            $this->builder->include($this->includeIds);
        }

        $query   = $this->query;
        $queryBy = $this->queryBy;

        if ($query && $queryBy) {
            $this->builder->when(Str::contains($queryBy, ','), static function (Builder $builder) use ($query, $queryBy) {
                $fields = explode(',', $queryBy);

                $filters = collect($fields)->mapWithKeys(static function ($key, $idx) use ($query) {
                    return [$idx => [$key, 'like', "%$query%"]];
                })->all();

                $builder->where(function($query) use($filters) {
                    foreach ($filters as $filter) {
                        $query->orWhere([$filter]);
                    }
                });
            }, static function (Builder $builder) use ($query, $queryBy) {
                $builder->where($queryBy, 'like', "%{$query}%");
            });
        }

        if ($this->with) {
            $this->builder->with(array_map('trim', explode(',', $this->with)));
        }

        return $this->builder;
    }

    public function getData($builder, $isToBase = false)
    {
        $builder->offset($this->offset)->limit($this->limit);

        if ($this->orderBy) {
            $builder->orderBy($this->orderBy, $this->direction);
        }

        if ($isToBase) {
            return $builder->toBase()->get();
        }

        return $builder->get();
    }
}
