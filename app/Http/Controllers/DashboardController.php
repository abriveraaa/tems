<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Requests;
use App\Models\Category;
use App\Models\ToolName;
use App\Models\Tools;

use Carbon\Carbon;
use DB;

class DashboardController extends Controller
{
    public function getAllHour()
    {
        $date = Carbon::today()->toDateString();
        $hour_array = [];
        $allhour = Requests::orderBy('created_at', 'ASC')->whereDate('created_at', '=', $date)->pluck('created_at');
        if(!empty($allhour))
        {
            foreach($allhour as $unfomatted_hour)
            {
                $gethour = Carbon::parse($unfomatted_hour);
                $hour_24 = $gethour->format('H');
                $hour_12 = $gethour->format('h A');
                $hour_array[$hour_24] = $hour_12; 
            }
        }
        
        return $hour_array;
    }
    
    public function getHourlyCount($hour)
    {
        $date = Carbon::today()->toDateString();
        $borrowed_count = DB::table('requests')->select('lhof')->groupBy('lhof')->whereRaw(DB::raw("HOUR(created_at) = $hour"))->whereDate('created_at', '=', $date)->get()->count();
        return $borrowed_count; 
    }

    public function getHourlyData()
    {
        $borrowed_count_array = [];
        $hour_array = $this->getAllHour();
        $hour_12_array = [];
        if(!empty($hour_array))
        {
            foreach($hour_array as $hour_24 => $hour_12)
            {
                $borrowed_count = $this->getHourlyCount($hour_24);
                array_push($borrowed_count_array, $borrowed_count);
                array_push($hour_12_array, $hour_12);
            }
        }
        $max_no = max($borrowed_count_array);
        $max = round( ($max_no + 10/2) / 10) * 10;
        $borrowed_data_array = [
            'hours' => $hour_12_array, 
            'borrowed_count' => $borrowed_count_array,
            'max' => $max,
        ];
        return $borrowed_data_array;
    }

    public function getCategoryCount()
    {
        $category = Category::select('id', 'description')->get();

        $toolname = ToolName::with(['tools', 'categories'])->withCount(['tools' => function (\Illuminate\Database\Eloquent\Builder $query) {
            $query->whereNull('tools.reason');
        }])->get();
        
        return ['toolname' => $toolname, 'category' => $category];

    }
}
