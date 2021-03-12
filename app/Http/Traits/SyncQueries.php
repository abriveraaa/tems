<?php

namespace App\Http\Traits;

use Illuminate\Http\Request;

use App\Models\Borrower;
use App\Models\Requests;

trait SyncQueries {

    public function syncRequest($request, $requestlog)
    {

        $borrower = $request->borrower;
        $item = $request->hiddendesc;
        $room = $request->room;
        $borrow = $request->admin;
        $course = $request->course;

        $requestlog->borrower()->sync($borrower, $requestlog);
        $requestlog->course()->sync($course, $requestlog);
        $requestlog->item()->sync($item, $requestlog);
        $requestlog->room()->sync($room, $requestlog);
        $requestlog->borrow()->sync($borrow, $requestlog);

        return $requestlog;
    }

    public function syncAcademic($request, $borrower)
    {
        $borrower->borrowercourse()->sync($request->course, $borrower);
        $borrower->borrowercollege()->sync($request->college, $borrower);

        return $borrower;
    }

    public function syncCourse($request, $course)
    {
        $college = $request->college;

        $course->colleges()->sync($college, $course);

        return $course;
    }

    public function syncRequestReturned($admin, $returned)
    {
        $returned->return()->sync($admin, $returned);

        return $returned;
    }

}