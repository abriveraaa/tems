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
    
    public function deleteCollege($college)
    {
        $colleges = College::whereId($college)->delete();

        return $colleges;
    }

    public function restoreCollege($college)
    {
        $colleges = College::withTrashed()
        ->where('id', $college)
        ->restore();

        return $colleges;
    }
}
