<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tools;

class RouteController extends Controller
{    
    public function viewDashboard()
    {
        return view ('dashboard');
    }
    
    public function showUserPage()
    {
        return view('admin.admin-index');
    }
    
    public function showRequestPage()
    {
        return view('request');
    }
    
    public function showBorrowerPage()
    {
        return view('borrower.borrower-index');
    }

    public function showCollegePage()
    {
        return view('borrower.college-index');
    }

    public function showCoursePage()
    {
        return view('borrower.course-index');
    }

    public function showRoomPage()
    {
        return view('borrower.room-index');
    }

    public function showSourcePage()
    {
        return view('borrower.source-index');
    }

    public function showToolsPage()
    {
        return view('admin.tool-index');
    }

    public function showToolCategoryPage()
    {
        return view('admin.category-index');
    }

    public function showToolNamePage()
    {
        return view('admin.toolname-index');
    }

    public function showReportPage()
    {
        return view('admin.report-index');
    }

    public function showTransactionPage()
    {
        return view('admin.transaction-index');
    }

    public function showRolesPermission()
    {
        return view('admin.roles-permission');
    }

    public function showBarcodePage()
    {
		$barcode = Tools::select('barcode')->get();
        return view('admin.barcode-index')->with('barcode', $barcode);
    }
}
