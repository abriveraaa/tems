<?php

namespace App\Services;

use App\Models\Academic;

class AcademicService
{
    public function addAcademic($college_id, $course_id)
    {
        $academic = Academic::where('college_id', $college_id)
            ->where('course_id', $course_id)
            ->first();
        
        if(! $academic) {
            $academic = Academic::create([
                'college_id' => $college_id,
                'course_id' => $course_id
            ]);
        } else {
            
        }
    }
}