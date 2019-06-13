<?php

use App\Models\User;
use Illuminate\Database\Seeder;

class DataSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $lessonsName = [
            'История',
            'Философия',
            'Веб-технологии',
            'Английский язык',
            'Компьютерная графика',
            'Машинное обучение',
            'Математический анализ',
            'Базы данных'
        ];

        $lessons = [];

        foreach ($lessonsName as $lesson) {
            $lessons[] = factory('App\Models\Lesson')->create([
                'name' => $lesson
            ]);
        }

        $teacherRole = factory('App\Models\Role')->create([
            'role' => 'Преподаватель'
        ]);

        $studentRole = factory('App\Models\Role')->create([
            'role' => 'Студент'
        ]);

        $groups = [];

        for ($i = 0; $i < 5; $i++) {
            $groups[] = factory('App\Models\Group')->create([
                'name' => 'group ' . $i
            ]);
        }

        $teachers = [];

        /**
         * Создаем преподавателей
         */
        for ($i = 0; $i < 3; $i++) {
            $teachers[] = factory('App\Models\User')->create([
                'role_id' => $teacherRole->getKey()
            ]);
        }

        $students = [];

        /**
         * Распихиваем пользователей по группам
         */
        for ($i = 0; $i < 70; $i++) {
            $students[] = factory('App\Models\User')->create([
                'group_id' => $groups[rand(0,4)]->getKey(),
                'role_id' => $studentRole->getKey()
            ]);
        }

        foreach ($students as $student) {
            /** @var User $student */
            $randomKeys = array_rand($lessons, rand(1, count($lessons)));

            if (!is_array($randomKeys)) {
                $randomKeys = [$randomKeys];
            }

            foreach ($randomKeys as $key) {
                factory('App\Models\RecordBook')->create([
                    'user_id' => $student->getKey(),
                    'lesson_id' => $lessons[$key]->getKey()
                ]);
            }
        }

        $schedule = [];

        for ($i = 0; $i < 30; $i++) {
            $schedule[] = factory('App\Models\Schedule')->create([
                'user_id' => $teachers[rand(0,count($teachers) - 1)]->getKey(),
                'lesson_id' => $lessons[rand(0, count($lessons) - 1)]->getKey(),
                'group_id' => $groups[rand(0,4)]->getKey(),
            ]);
        }

        $lessonLogs = [];

        for ($i = 0; $i < 500; $i++) {
            $lessonLogs[] = factory('App\Models\LessonLog')->create([
                'schedule_id' => $schedule[rand(0,count($schedule) - 1)]->getKey(),
            ]);
        }

        foreach ($lessonLogs as $lessonLog) {
            /** @var \App\Models\LessonLog $lessonLog */
            $students = $lessonLog->schedule->group->users;

            foreach ($students as $student) {
                factory('App\Models\Journal')->create([
                    'user_id' => $student->getKey(),
                    'lesson_log_id' => $lessonLog->getKey()
                ]);
            }
        }
    }
}