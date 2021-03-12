<?php

namespace App\Http\Traits;

use Illuminate\Http\Request;

trait ToolQueries {

    public function updateReason($reason, $changestat)
    {
        $changestat->reason = $reason;
        $changestat->save(); 

        return $changestat;
    }

}