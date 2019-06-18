<?php

namespace App\Search;

/**
 * Поиск по урокам
 */
class LessonSearch extends Search
{
    /**
     * @var array
     */
    protected $searchableFields = ['byName'];

    /**
     * Поиск по имени
     *
     * @param string $name
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function byName(string $name)
    {
        return $this->builder->where('name', 'like', '%'.$name.'%');
    }

}