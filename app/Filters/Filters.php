<?php

namespace App\Filters;

use Illuminate\Http\Request;

abstract class Filters
{
    /**
     * @var Request
     */
    protected $request;

    /**
     * The Eloquent builder.
     *
     * @var \Illuminate\Database\Eloquent\Builder
     */
    protected $builder;

    /**
     * Список полей доступных для фильтрации
     *
     * @var array
     */
    protected $filters = [];

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Применяем фильтры
     *
     * @param  \Illuminate\Database\Eloquent\Builder $builder
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function apply($builder)
    {
        $this->builder = $builder;

        foreach ($this->getFilters() as $filter => $value) {
            if (method_exists($this, $filter)) {
                $this->$filter($value);
            }
        }

        return $this->builder;
    }

    /**
     * Получаем данные из реквеста для фильтации
     *
     * @return array
     */
    public function getFilters()
    {
        return $this->request->only($this->filters);
    }
}