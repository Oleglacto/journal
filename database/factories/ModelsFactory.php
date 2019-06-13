<?php

use App\Models\Group;
use App\Models\Lesson;
use App\Models\RecordBook;
use Faker\Generator as Faker;


$factory->define(Group::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
    ];
});


$factory->define(Lesson::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
    ];
});

$factory->define(RecordBook::class, function (Faker $faker) {
    return [
        'user_id' => null,
        'lesson_id' => null,
        'mark' => rand(1,5)
    ];
});

$factory->define(\App\Models\Schedule::class, function (Faker $faker) {
    return [
        'group_id' => null,
        'lesson_id' => null,
        'dateFrom' => $faker->time('H:i'),
        'dateTo' => $faker->time('H:i'),
        'user_id' => null,
        'day' => strtolower($faker->dayOfWeek()),
    ];
});

$factory->define(\App\Models\LessonLog::class, function (Faker $faker) {
    return [
        'schedule_id' => null,
        'date' => $faker->date('Y.m.d H:m')
    ];
});

$factory->define(\App\Models\Journal::class, function (Faker $faker) {
    return [
        'lesson_log_id' => null,
        'user_id' => null,
        'is_visited' => $faker->boolean(),
    ];
});
