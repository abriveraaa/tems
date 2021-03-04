<?php

namespace App\Http\Traits;

use App\Models\Course;

trait CourseQueries {

    public function allCourse()
    {
        $course = Course::withTrashed()->with('colleges')->get();

        return $course;
    }

    public function saveCourse($validated)
    {
        $course = new Course();
        $course->description = $validated['description'];
        $course->code = strtoupper($validated['code']);
        $course->save();

        return $course;
    }

    public function getCourse($course)
    {
        $courses = Course::whereId($course)->with('colleges')->get();

        return $courses;
    }

    public function updateCourse($courseId, $validated)
    {
        $course = Course::where('id', $courseId)->first();
        $course->description = $validated['description'];
        $course->code = strtoupper($validated['code']);
        $course->save();

        return $course;
    }

    public function deleteCourse($course)
    {
        $courses = Course::whereId($course)->delete();

        return $courses;
    }

    public function restoreCourse($course)
    {
        $courses = Course::withTrashed()
        ->where('id', $course)
        ->restore();

        return $courses;
    }
}