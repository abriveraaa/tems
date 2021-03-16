<?php

namespace App\Http\Traits;

use Illuminate\Http\Request;

use App\Models\Tools;

trait ToolQueries {

    public function allTools()
    {
        $tools = Tools::with('toolname')->with(['tooladmin', 'toolcategory', 'toolname', 'toolsource'])->get();

        return $tools;
    }

    public function saveTools($validated)
    {
        $tools = new Tools;
        $tools->barcode = $validated['barcode'];
        $tools->brand = $validated['brand'];
        $tools->property = strtoupper($validated['property']);
        $tools->save();

        return $tools;
    }

    public function updateTool($validated, $toolId)
    {
        $tools = Tools::where('id', $toolId)->first();
        $tools->brand = $validated['brand'];
        $tools->property = strtoupper($validated['property']);
        $tools->save();

        return $tools;
    }

    public function getTool($toolId)
    {
        $tool = Tools::whereId($toolId)->with(['toolcategory', 'toolname', 'toolsource', 'tooladmin'])->first();

        return $tool;
    }

    public function updateReason($reason, $changestat)
    {
        $changestat->reason = $reason;
        $changestat->save(); 

        return $changestat;
    }

}