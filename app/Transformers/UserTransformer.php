<?php

namespace App\Transformers;

use App\Models\User;
use League\Fractal\TransformerAbstract;

/**
 * Трансформер для преподавателей
 *
 * Желательно подгрузить изначально релейшн с
 *  - ролями
 *  - группами
 */
class UserTransformer extends TransformerAbstract
{
    public function transform(User $user)
    {
        return [
            'user_id' => $user->getKey(),
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'middle_name' => $user->middle_name,
            'science_degree' => $user->science_degree,
            'role' => $user->role->role,
            'full_name'     => sprintf(
                '%s %s %s',
                $user->last_name,
                $user->first_name,
                $user->middle_name ?? ''
            ),
            'group' => $user->group ? $user->group->name : ''
        ];
    }
}