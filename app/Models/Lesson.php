<?php

namespace App\Models;

use App\Search\LessonSearch;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Модель занятий
 */
class Lesson extends Model
{
    /**
     * {@inheritdoc}
     */
    protected $primaryKey = 'lesson_id';

    /**
     * {@inheritdoc}
     */
    protected $fillable = [
        'name'
    ];

    /**
     * Поиск
     *
     * @param  Builder $query
     * @param LessonSearch $search
     * @return Builder
     */
    public function scopeSearch($query, LessonSearch $search)
    {
        return $search->search($query);
    }
}