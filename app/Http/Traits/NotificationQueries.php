<?php

namespace App\Http\Traits;

trait NotificationQueries {
    
    public function notify($model, $status)
    {
        return response()->json(['success' => $model. ' ' . $status .' successfully!']);
    }
}
