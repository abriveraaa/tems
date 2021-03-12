<?php

namespace App\Http\Traits;

use Illuminate\Http\Request;

use App\Models\Borrower;

use Carbon\Carbon;
use DataTables;
use Auth;

trait BorrowerQueries {

    public function allBorrower()
    {
        $data = Borrower::withTrashed()->with(['borrowercourse', 'borrowercollege'])->get();
    
        return $data;
    }

    public function saveBorrower($validatedData, $image_name)
    {
        $borrower = new Borrower;
        $borrower->image = $image_name;
        $borrower->studnum = strtoupper($validatedData['studnum']);
        $borrower->firstname = ucwords(mb_strtolower($validatedData['firstname']));
        $borrower->midname = ucwords(mb_strtolower($validatedData['midname'] ));
        $borrower->lastname = ucwords(mb_strtolower($validatedData['lastname']));
        $borrower->contact = $validatedData['contact'];
        $borrower->sex = $validatedData['sex'];
        $borrower->year = $validatedData['year'];
        $borrower->section = $validatedData['section'];
        $borrower->save();

        return $borrower;
    }

    public function getBorrower($borrower)
    {
        $borrowers = Borrower::where('id', $borrower)->with(['borrowercourse', 'borrowercollege'])->first();

        return $borrowers;
    }

    public function updateBorrower($borrowerId, $validatedData, $image_name)
    {
        $borrower = Borrower::where('id', $borrowerId)->first();
        $borrower->image = $image_name;
        $borrower->studnum = strtoupper($validatedData['studnum']);
        $borrower->firstname = ucwords(mb_strtolower($validatedData['firstname']));
        $borrower->midname = ucwords(mb_strtolower($validatedData['midname'] ));
        $borrower->lastname = ucwords(mb_strtolower($validatedData['lastname']));
        $borrower->contact = $validatedData['contact'];
        $borrower->sex = $validatedData['sex'];
        $borrower->year = $validatedData['year'];
        $borrower->section = $validatedData['section'];
        $borrower->save();

        return $borrower;   	
    }

    public function updateReport($borrowerId, $report)
    {
        $borrower = Borrower::where('id', $borrowerId)->first();
        $borrower->reported_at = $report;
        $borrower->save();

        return $borrower;
    }

    public function storeImage($request)
    {

        $image_name = $request->hidden_image;
        $image = $request->file('borrower_image');

        if($image != null || $image != '') 
        {
            $image_name = rand() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('img/borrower'), $image_name);
        }

        return $image_name;
    }

    public function updateReportedDate($borrower)
    {
        $banneduser = Borrower::where('id', $borrower)->first();
        $banneduser->reported_at = Carbon::now()->toDateTimeString();
        $banneduser->save();

        return $banneduser;
    }

}
