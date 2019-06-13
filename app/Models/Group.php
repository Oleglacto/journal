<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * Модель группы студентов
 *
 * @property string                 $name
 * @property Collection|User[]      $users
 */
class Group extends Model
{
    /**
     * {@inheritdoc}
     */
    protected $primaryKey = 'group_id';

    /**
     * {@inheritdoc}
     */
    protected $table = 'student_groups';

    /**
     * {@inheritdoc}
     */
    protected $fillable = [
        'name',
    ];

    /**
     * {@inheritdoc}
     */
    protected $visible = [
        'name',
        'group_id'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users()
    {
        return $this->hasMany(User::class, 'group_id', 'group_id');
    }
}