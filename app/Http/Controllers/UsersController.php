<?php

namespace App\Http\Controllers;

use App\Filters\UsersFilters;
use App\Http\Requests\UserRequest;
use App\Models\Role;
use App\Models\User;
use App\Transformers\UserTransformer;
use League\Fractal\Manager;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use League\Fractal\Resource\Collection;

class UsersController
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
     * Получение списка преподавателей
     *
     * @param UserTransformer $transformer
     * @return \Illuminate\Http\JsonResponse
     */
    public function getTeachers(UserTransformer $transformer)
    {
        $teachers = User::teachers()->get();

        $collection = new Collection($teachers, $transformer);

        return response()->json($this->fractal->createData($collection)->toArray());
    }

    /**
     * Store the user
     *
     * @param UserRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(UserRequest $request)
    {
        return response()->json(['data' => User::create($request->validated())]);
    }

    /**
     * Главная страница со студентами
     * @param UserTransformer $userTransformer
     * @param UsersFilters $filters
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(UserTransformer $userTransformer, UsersFilters $filters)
    {
        $students = User::with(['group', 'role'])->filter($filters)->paginate(10);

        $collection = new Collection($students, $userTransformer);
        $collection->setPaginator(new IlluminatePaginatorAdapter($students));

        return response()->json($this->fractal->createData($collection)->toArray());
    }

    /**
     * Получение всех ролей пользователей
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getRoles()
    {
       return response()->json([
           'data' => Role::all()
       ]);
    }
}