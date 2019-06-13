<?php

namespace App\Filters;

class UsersFilters extends Filters
{
    /**
     * Registered filters to operate upon.
     *
     * @var array
     */
    protected $filters = ['byRole', 'byGroup'];

    /**
     * Фильтрация по должности
     *
     * @param $roleId
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function byRole($roleId)
    {
        return $this->builder->where('role_id', $roleId);
    }

    /**
     * Фильтрация по группе
     *
     * @param $groupIds
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function byGroup($groupIds)
    {
        return $this->builder->whereIn('group_id', explode(',', $groupIds))->orderBy('group_id');
    }
}
