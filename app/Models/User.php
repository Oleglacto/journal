<?php

namespace App\Models;

use App\Filters\UsersFilters;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * Модель пользователей
 *
 * @property string                     $first_name         Имя
 * @property string                     $last_name          Фамилия
 * @property string                     $middle_name        Отчество
 * @property Role                       $role               роль (студент, преподаватель...)
 * @property Group                      $group              группа
 * @property string                     $science_degree     научная степень
 * @property Collection|Schedule[]      $schedule           расписание
 */
class User extends Model
{
    /**
     * Преподаватели
     */
    const ROLE_TEACHER = 1;

    /**
     * Студенты
     */
    const ROLE_STUDENT = 2;

    /**
     * {@inheritdoc}
     */
    protected $primaryKey = 'user_id';

    /**
     * {@inheritdoc}
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'middle_name',
        'role_idз',
        'science_degree',
        'group_id'
    ];

    /**
     * Релейшн с моделью ролей
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function role()
    {
        return $this->hasOne(Role::class, 'role_id', 'role_id');
    }

    /**
     * Релейшен к расписанию
     */
    public function schedule()
    {
        return $this->hasMany(Schedule::class, 'user_id', 'user_id');
    }

    /**
     * Релейшн к группе
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function group()
    {
        return $this->belongsTo(Group::class, 'group_id', 'group_id');
    }

    /**
     * Релейшн к группе
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function recordBooks()
    {
        return $this->hasMany(RecordBook::class, 'user_id', 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function journals()
    {
        return $this->hasMany(Journal::class, 'user_id', 'user_id');
    }

    /**
     * Скоуп по преподавателям
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeTeachers(Builder $query)
    {
        return $query->where('role_id', self::ROLE_TEACHER);
    }

    /**
     * Скоуп по роли пользователя
     *
     * @param Builder $query
     * @param int $role
     * @return Builder
     */
    public function scopeByRole(Builder $query, int $role)
    {
        return $query->where('role_id', $role);
    }

    /**
     * Скоуп по студентам
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeStudents(Builder $query)
    {
        return $query->where('role_id', 2);
    }

    /**
     * Применяем все фильтры
     *
     * @param  Builder $query
     * @param UsersFilters $filters
     * @return Builder
     */
    public function scopeFilter($query, UsersFilters $filters)
    {
        return $filters->apply($query);
    }
}