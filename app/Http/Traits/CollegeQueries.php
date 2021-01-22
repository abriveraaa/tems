<?php

namespace App\Http\Traits;

use App\Models\College;

trait CollegeQueries {
    
    public function allCollege()
    {
        $college = College::withTrashed()->get();

        return $college;
    }

    public function saveCollege($validated)
    {
        $college = new College;
        $college->description = $validated['description'];
        $college->code = strtoupper($validated['code']);
        $college->save();

        return $college;
    }
    
    public function getCollege($college)
    {
        $colleges = College::whereId($college)->get();

        return $colleges;
    }

    public function updateCollege($collegeId, $validated)
    {
        $college = College::where('id', $collegeId);
        $college->description = $validated['description'];
        $college->code = strtoupper($validated['code']);
        $college->save();

        return $college;
    }
}
