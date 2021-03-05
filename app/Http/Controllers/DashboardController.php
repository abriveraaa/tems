<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Requests;
use DB;
use Carbon\Carbon;

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

    public function getAllCategory()
    {
        $category_array = [];
        $allcategory = DB::SELECT("SELECT id, description FROM categories");
        if(!empty($allcategory))
        {
            foreach($allcategory as $category_id)
            {
                $category_num = $category_id->id;
                $category_name = $category_id->description;
                $category_array[$category_num] = $category_name; 
            }
        }
        return $category_array;
    }

    public function getCategoryCount($category_num)
    {
        $category_count = DB::table('items')->where('category', '=', $category_num)->where('stat', '=', 1)->get()->count();
        return $category_count; 
    }

    public function getCategoryData()
    {
        $category_count_array = array();
        $category_array = $this->getAllCategory();
        $category_id_array = array();
        if(!empty($category_array))
        {
            foreach($category_array as $category_num => $category_name)
            {
                $borrowed_count = $this->getCategoryCount($category_num);
                array_push($category_count_array, $borrowed_count);
                array_push($category_id_array, $category_name);
            }
        }
        $borrowed_data_array = array(
            'category_name' => $category_id_array, 
            'category_count' => $category_count_array,
        );
        return $borrowed_data_array;
    }
}
