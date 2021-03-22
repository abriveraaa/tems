<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Traits\NotificationQueries;
use App\Http\Traits\RequestQueries;
use App\Http\Traits\BorrowerQueries;
use App\Http\Traits\ToolQueries;
use App\Http\Traits\SyncQueries;

use App\Http\Requests\ToolRequest;

use App\Models\Tools;
use App\Models\Requests;

use Carbon\Carbon;

class ToolsController extends Controller
{
    use ToolQueries, SyncQueries, NotificationQueries;
    use RequestQueries;
    use BorrowerQueries;

    public function __construct()
    {
        $this->model = 'Tool';
        $this->date = Carbon::now()->toDateTimeString();
    }

    public function index()
    {
        $tools = $this->allTools();

        $data = $this->toolDataTable($tools);

        return $data;
    }

    public function store(ToolRequest $request)
    {
        $validated = $request->validated();

        $tools = $this->saveTools($validated);

        $this->syncTools($validated, $tools);

        $response = $this->notify($this->model, 'added');

        return $response;
    }

    public function show($tools)
    {
        $tool = $this->getTool($tools);

        return response()->json($tool);
    }

    public function update(ToolRequest $request)
    {
        $toolId = $request->toolId;

        $validated = $request->validated();
       
        $tools = $this->updateTool($validated, $toolId);

        $this->syncTools($validated, $tools);
        
    	$response = $this->notify($this->model, 'updated');

        return $response;
    }

    public function report(ToolReportRequest $request)
    {
        $validated = $request->validated();
        
        $check = Tools::Borrowed($validated['repBarcode']);

        if($check){

            $returned = Requests::Borrowed($validated['repBarcode']);

            $this->updatedStatus($returned, 'Returned');

            $this->syncRequestReturned(Auth()->user()->id, $returned);
        }

        $tools = $this->updateReportedTool($toolId, $validated);

        $this->syncToolReport($validated['repnum'], $tools);

        $this->syncToolAdmin(Auth()->user()->id, $tools);

        $this->banBorrower($validated['repnum'], $this->date);

        $response = $this->notify($this->model, 'reported');

        return $response;
    }
}