<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Transformers\StudentInformationTransformer;
use League\Fractal\Manager;


/**
 * Контроллер страницы списка студентов
 */
class StudentsController extends \Illuminate\Routing\Controller
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
     * Информация по одному студенту
     *
     * @param User $user
     * @param StudentInformationTransformer $transformer
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(User $user, StudentInformationTransformer $transformer)
    {
        $user->load(['group', 'recordBooks.lessons', 'journals.lessonLog.schedule.lesson']);

        $data = $transformer->transform($user);

        return response()->json($data);
    }
}