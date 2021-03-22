<?php

namespace App\Http\Traits;

use Illuminate\Http\Request;

use App\Models\Borrower;
use App\Models\Requests;

use Auth;

trait SyncQueries {

    public function syncRequest($adminId, $request, $requestlog)
    {

        $borrower = $request->borrower;
        $item = $request->hiddendesc;
        $room = $request->room;
        $course = $request->course;

        $requestlog->borrower()->sync($borrower, $requestlog);
        $requestlog->course()->sync($course, $requestlog);
        $requestlog->item()->sync($item, $requestlog);
        $requestlog->room()->sync($room, $requestlog);
        $requestlog->borrow()->sync($adminId, $requestlog);

        return $requestlog;
    }

    public function syncTools($validated, $tools)
    {
        $tools->toolname()->sync($validated['description'], $tools);
        $tools->toolcategory()->sync($validated['category'], $tools);
        $tools->toolsource()->sync($validated['source'], $tools);
        $tools->tooladmin()->sync($validated['admin_num'], $tools);

        return $tools;
    }

    public function syncToolReport($borrower, $tools)
    {
        $tools->toolreport()->sync($borrower, $tools);

        return $tools;
    }

    public function syncToolAdmin($admin, $tools)
    {
        $tools->tooladmin()->sync($admin, $tools);

        return $tools;
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

    public function syncToolName($toolcategory, $toolname)
    {
        $toolname->categories()->sync($toolcategory, $toolname);

        return $toolname;
    }

}