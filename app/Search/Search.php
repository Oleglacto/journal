<?php

namespace App\Search;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

abstract class Search
{
    /**
     * Список полей доступных для фильтрации
     *
     * @var array
     */
    protected $searchableFields = [];

    /**
     * @var Builder
     */
    protected $builder;

    /**
     * @var Request
     */
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Делаем поиск
     *
     * @param  \Illuminate\Database\Eloquent\Builder $builder
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function search(Builder $builder): Builder
    {
        $this->builder = $builder;

        foreach ($this->getSearchableFields() as $filter => $value) {
            if (method_exists($this, $filter)) {
                $this->$filter($value);
            }
        }

        return $this->builder;
    }

    /**
     * Получаем данные из реквеста для поиска
     *
     * @return array
     */
    public function getSearchableFields()
    {
        return $this->request->only($this->searchableFields);
    }
}
