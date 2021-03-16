<?php

namespace App\Http\Traits;

use App\Models\Source;

trait SourceQueries {

    public function saveSource($validated)
    {
        $source = new Source();
        $source->description = ucwords(mb_strtolower($validated['description']));
        $source->save();

        return $source;
    }

    public function updateSource($sourceId, $validated)
    {
        $source = Source::where('id', $sourceId)->first();
        $source->description = ucwords(mb_strtolower($validated['description']));
        $source->save();

        return $source;
    }

}