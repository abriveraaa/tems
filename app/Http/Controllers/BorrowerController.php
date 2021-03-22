<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

use App\Http\Traits\NotificationQueries;
use App\Http\Traits\BorrowerQueries;
use App\Http\Traits\SyncQueries;
use App\Http\Requests\BorrowerRequest;

use App\Models\Borrower;

use Carbon\Carbon;

class BorrowerController extends Controller
{
    use BorrowerQueries, SyncQueries, NotificationQueries;

    public function __construct()
    {
        $this->date = Carbon::now()->toDateTimeString();
        $this->model = 'Borrower';
    }

    public function index()
    {
        $borrower = $this->allBorrower();

        $data = $this->borrowerDataTable($borrower);

        return $data;
    }

    public function store(BorrowerRequest $request)
    {
        $validatedData = $request->validated();

        $image_name = $this->storeImage($request);
        
        $borrower = $this->saveBorrower($validatedData, $image_name);

        $this->syncAcademic($request, $borrower);

    	$response = $this->notify($this->model, 'added');

        return $response;
    }

    public function show($borrower)
    {
        $borrowers = $this->getBorrower($borrower);
            
        return response()->json($borrowers);
    }

    public function update(BorrowerRequest $request)
    {       
        $validatedData = $request->validated();

        $image_name = $this->storeImage($request);

        $borrower = $this->updateBorrower($request->borrower_id, $validatedData, $image_name);

        $this->syncAcademic($request, $borrower);

        $response = $this->notify($this->model, 'updated');

        return $response;
    }

    public function destroy($borrower)
    {
        $this->banBorrower($borrower, $this->date);

        $response = $this->notify($this->model, 'banned');

        return $response;
    }

    public function restore($borrower)
    {
        $this->banBorrower($borrower, null);

        $response = $this->notify($this->model, 'restored');

        return $response;
    }
}