<?php

namespace App\Http\Traits;

use Illuminate\Http\Request;

use App\Models\Requests;

trait RequestQueries {

    public function newRequest($request)
    {
        $requestlog = new Requests;
        $requestlog->lhof = strtoupper($request->lhofhidden);
        $requestlog->tool = strtoupper($request->search_item);
        $requestlog->status = "Borrowed";
        $requestlog->save();

        return $requestlog;
    }

    public function updateStatus($returned, $status)
    {
        $returned->status = $status;
        $returned->save();

        return $returned;
    }

}