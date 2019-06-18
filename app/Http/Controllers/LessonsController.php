<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use App\Search\LessonSearch;
use App\Transformers\LessonTransformer;
use Illuminate\Http\Request;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;

class LessonsController extends Controller
{
    /**
     * @var Manager
     */
    protected $fractal;

    public function __construct(Manager $fractal)
    {
        $this->fractal = $fractal;
    }

    /**
     * Страница со всеми занятиями
     *
     * @param LessonTransformer $lessonTransformer
     * @param LessonSearch $lessonSearch
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(LessonTransformer $lessonTransformer, LessonSearch $lessonSearch)
    {
        $lessons = Lesson::search($lessonSearch)->get();

        $collection = new Collection($lessons, $lessonTransformer);

        return response()->json($this->fractal->createData($collection)->toArray());
    }

    /**
     * Обновление дисциплины
     *
     * @param Request $request
     * @param Lesson $lesson
     * @param LessonTransformer $lessonTransformer
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Lesson $lesson, LessonTransformer $lessonTransformer)
    {
        $request->validate([
            'name' => 'required'
        ]);

        $lesson->update([
            'name' => $request->get('name')
        ]);

        $lessons = Lesson::all();

        $collection = new Collection($lessons, $lessonTransformer);

        return response()->json($this->fractal->createData($collection)->toArray());
    }

    /**
     * Добавление дисциплины
     *
     * @param Request $request
     * @param LessonTransformer $lessonTransformer
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, LessonTransformer $lessonTransformer)
    {
        $request->validate([
            'name' => 'required'
        ]);

        Lesson::create($request->all());

        $lessons = Lesson::all();

        $collection = new Collection($lessons, $lessonTransformer);

        return response()->json($this->fractal->createData($collection)->toArray());
    }



    /**
     * Удаление дисциплины
     *
     * @param Lesson $lesson
     * @param LessonTransformer $lessonTransformer
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Lesson $lesson, LessonTransformer $lessonTransformer)
    {
        $lesson->delete();

        $lessons = Lesson::all();

        $collection = new Collection($lessons, $lessonTransformer);

        return response()->json($this->fractal->createData($collection)->toArray());
    }
}