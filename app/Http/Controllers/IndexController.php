<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Role;
use League\Fractal\Manager;

class IndexController
{
    /**
     * @var Manager
     */
    private $fractal;

    public function __construct(Manager $fractal)
    {
        $this->fractal = $fractal;
    }

    /**
     * Получение всех ролей пользователей
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getServiceInformation()
    {
        return response()->json([
            'data' => [
                'roles' => Role::all(),
                'groups' => Group::all()
            ]
        ]);
    }
}