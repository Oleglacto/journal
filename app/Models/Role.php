<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Модель ролей
 *
 * @property string     $role
 */
class Role extends Model
{
    /**
     * {@inheritdoc}
     */
    protected $primaryKey = 'role_id';

    /**
     * {@inheritdoc}
     */
    protected $table = 'roles';

    /**
     * {@inheritdoc}
     */
    protected $fillable = [
        'role',
    ];

    /**
     * {@inheritdoc}
     */
    protected $visible = [
        'role_id',
        'role'
    ];

    /**
     * Релейшн с пользователями
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function users()
    {
        return $this->belongsTo(User::class, 'role_id', 'role_id');
    }
}