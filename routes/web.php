<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    if(Auth::check()){
        return redirect()->route('dashboard');
    }else{
        return redirect()->route('login');
    }
});

Route::get('/sample', ['as' => 'sample', 'uses' => 'RequestController@sample']);


//LOGIN
Route::group(['prefix' => '/login'], function() {
    Route::get('', ['as' => 'login', 'uses' => 'Auth\LoginController@showLoginForm']);
    Route::post('', ['as' => '', 'uses' => 'Auth\LoginController@login']);
});

//PASSWORD
Route::group(['prefix' => '/password'], function() {
    Route::get('/confirm', ['as' => 'password.confirm', 'uses' => 'Auth\ConfirmPasswordController@showConfirmForm']);
    Route::post('/confirm', ['as' => '', 'uses' => 'Auth\ConfirmPasswordController@confirm']);
    Route::post('/email', ['as' => 'password.email', 'uses' => 'Auth\ForgotPasswordController@sendResetLinkEmail']);
    Route::get('/reset', ['as' => 'password.request', 'uses' => 'Auth\ForgotPasswordController@showLinkRequestForm']);
    Route::post('/reset', ['as' => 'password.update', 'uses' => 'Auth\ResetPasswordController@reset']);
    Route::get('/reset/token/{token}', ['as' => 'password.reset', 'uses' => 'Auth\ResetPasswordController@showResetForm']);
});

Route::middleware(['route'])->group(function() {
    
    Route::resource('/roles-permission', RolesAssignmentController::class, ['middleware' => ['auth', 'web', 'permission:manage-dashboard'], 'as' => 'admintrust'])
    ->only(['index', 'edit', 'update']);

    //DASHBOARD
    Route::get('/dashboard', ['as' => 'dashboard', 'middleware' => ['permission:manage-dashboard'], 'uses' => 'RouteController@viewDashboard']);
    Route::group(['prefix' => '/data/dashboard', 'middleware' => []], function() {
        Route::get('/borrower', ['as' => 'dashboard.borrower', 'uses' => 'DashboardController@getHourlyData']);
    });
    
    //REQUEST
    Route::get('/request', ['as' => 'request', 'middleware' => ['permission:manage-request'], 'uses' => 'RouteController@showRequestPage']);
    Route::group(['prefix' => '/data/requests', 'middleware' => []], function() {
        Route::post('', ['as' => 'requests.store', 'uses' => 'RequestController@createRequestLog']);
    });

    //ADMIN
    Route::get('/admin', ['as' => 'admin', 'middleware' => ['permission:users-view|users-create|users-update|users-delete'], 'uses' => 'RouteController@showUserPage']);
    Route::group(['prefix' => '/data/admin', 'middleware' => []], function() {
        Route::get('', ['middleware' => ['permission:users-view'], 'as' => 'admin.index', 'uses' => 'UserController@index']);
        Route::post('', ['middleware' => ['permission:users-create'], 'as' => 'admin.store', 'uses' => 'UserController@createAdmin']);
        Route::get('/{admin}', ['middleware' => ['permission:users-view'], 'as' => 'admin.show', 'uses' => 'UserController@getAdmin']);
        Route::post('/{admin}', ['middleware' => ['permission:users-update'], 'as' => 'admin.update', 'uses' => 'UserController@updateAdmin']);
        Route::delete('/{admin}', ['middleware' => ['permission:users-delete'], 'as' => 'admin.destroy', 'uses' => 'UserController@destroy']); 
        Route::put('/{admin}', ['middleware' => ['permission:users-delete'], 'as' => 'admin.restore', 'uses' => 'UserController@restore']); 
    });

    //BORROWER
    Route::get('/borrower', ['as' => 'borrower', 'middleware' => ['permission:borrower-view|borrower-create|borrower-update|borrower-delete'], 'uses' => 'RouteController@showBorrowerPage']);
    Route::group(['prefix' => '/data/borrower', 'middleware' => ['web']], function() {
        Route::get('', ['middleware' => ['permission:borrower-view'], 'as' => 'borrower.index', 'uses' => 'BorrowerController@index']);
        Route::post('', ['middleware' => ['permission:borrower-create'], 'as' => 'borrower.store', 'uses' => 'BorrowerController@store']);
        Route::get('/{borrower}', ['middleware' => ['permission:borrower-view'], 'as' => 'borrower.show', 'uses' => 'BorrowerController@show']);
        Route::post('/{borrower}', ['middleware' => ['permission:borrower-update'], 'as' => 'borrower.update', 'uses' => 'BorrowerController@update']);
        Route::delete('/{borrower}', ['middleware' => ['permission:borrower-delete'], 'as' => 'borrower.destroy', 'uses' => 'BorrowerController@destroy']);
        Route::put('/{borrower}', ['middleware' => ['permission:borrower-delete'], 'as' => 'borrower.restore', 'uses' => 'BorrowerController@restore']);
    });

    //TOOLS
    Route::get('/tool', ['as' => 'tool', 'middleware' => ['permission:tools-view|tools-create|tools-update|tools-delete|tools-print'], 'uses' => 'RouteController@showToolsPage']);
    Route::group(['prefix' => '/data/tools', 'middleware' => []], function() {
        Route::get('', ['middleware' => ['permission:tools-view'], 'as' => 'tools.index', 'uses' => 'ToolsController@index']);
        Route::post('', ['middleware' => ['permission:tools-create'], 'as' => 'tools.store', 'uses' => 'ToolsController@store']);
        Route::get('/{tools}', ['middleware' => ['permission:tools-view'], 'as' => 'tools.show', 'uses' => 'ToolsController@show']);
        Route::post('/{tools}', ['middleware' => ['permission:tools-update|tools-delete'], 'as' => 'tools.update', 'uses' => 'ToolsController@update']);
        Route::post('/report/{tools}', ['middleware' => ['permission:tools-delete'], 'as' => 'tools.report', 'uses' => 'ToolsController@report']);
    });

    //TOOL CATEGORY
    Route::get('/toolcategory', ['as' => 'toolcategory', 'middleware' => ['permission:toolcategory-view|toolcategory-create|toolcategory-update|toolcategory-delete'], 'uses' => 'RouteController@showToolCategoryPage']);
    Route::group(['prefix' => '/data/categories', 'middleware' => []], function() {
        Route::get('', ['middleware' => ['permission:toolcategory-view'], 'as' => 'categories.index', 'uses' => 'ToolCategoryController@index']);
        Route::post('', ['middleware' => ['permission:toolcategory-create'], 'as' => 'categories.store', 'uses' => 'ToolCategoryController@store']);
        Route::get('/{categories}', ['middleware' => ['permission:toolcategory-view'], 'as' => 'categories.show', 'uses' => 'ToolCategoryController@show']);
        Route::put('/{categories}', ['middleware' => ['permission:toolcategory-update'], 'as' => 'categories.update', 'uses' => 'ToolCategoryController@update']);
        Route::delete('/{categories}', ['middleware' => ['permission:toolcategory-delete'], 'as' => 'categories.destroy', 'uses' => 'ToolCategoryController@destroy']);
        Route::post('/{categories}', ['middleware' => ['permission:toolcategory-delete'], 'as' => 'categories.restore', 'uses' => 'ToolCategoryController@restore']);
    });

    //TOOL NAME
    Route::get('/toolname', ['as' => 'toolname', 'middleware' => ['permission:toolname-view|toolname-create|toolname-update|toolname-delete'], 'uses' => 'RouteController@showToolNamePage']);
    Route::group(['prefix' => '/data/toolname', 'middleware' => []], function() {
        Route::get('', ['middleware' => ['permission:toolname-view'], 'as' => 'toolname.index', 'uses' => 'ToolNameController@index']);
        Route::post('', ['middleware' => ['permission:toolname-create'], 'as' => 'toolname.store', 'uses' => 'ToolNameController@store']);
        Route::get('/{toolname}', ['middleware' => ['permission:toolname-view'], 'as' => 'toolname.show', 'uses' => 'ToolNameController@show']);
        Route::put('/{toolname}', ['middleware' => ['permission:toolname-update'], 'as' => 'toolname.update', 'uses' => 'ToolNameController@update']);
        Route::delete('/{toolname}', ['middleware' => ['permission:toolname-delete'], 'as' => 'toolname.destroy', 'uses' => 'ToolNameController@destroy']);
        Route::post('/{toolname}', ['middleware' => ['permission:toolname-delete'], 'as' => 'toolname.restore', 'uses' => 'ToolNameController@restore']);
    });

    //COLLEGE
    Route::get('/college', ['as' => 'college', 'middleware' => ['permission:college-view|college-create|college-update|college-delete'], 'uses' => 'RouteController@showCollegePage']);
    Route::group(['prefix' => '/data/college', 'middleware' => []], function() {
        Route::get('', ['middleware' => ['permission:college-view'], 'as' => 'college.index', 'uses' => 'CollegeController@index']);
        Route::post('', ['middleware' => ['permission:college-create'], 'as' => 'college.store', 'uses' => 'CollegeController@store']);
        Route::get('/{college}', ['middleware' => ['permission:college-view'], 'as' => 'college.show', 'uses' => 'CollegeController@show']);
        Route::put('/{college}', ['middleware' => ['permission:college-update'], 'as' => 'college.update', 'uses' => 'CollegeController@update']);
        Route::delete('/{college}', ['middleware' => ['permission:college-delete'], 'as' => 'college.destroy', 'uses' => 'CollegeController@destroy']);
        Route::post('/{college}', ['middleware' => ['permission:college-delete'], 'as' => 'college.restore', 'uses' => 'CollegeController@restore']);
    });

    //ROOM
    Route::get('/room', ['as' => 'room', 'middleware' => ['permission:room-view|room-create|room-update|room-delete'], 'uses' => 'RouteController@showRoomPage']);
    Route::group(['prefix' => '/data/room', 'middleware' => []], function() {
        Route::get('', ['middleware' => ['permission:room-view'], 'as' => 'room.index', 'uses' => 'RoomController@index']);
        Route::post('', ['middleware' => ['permission:room-create'], 'as' => 'room.store', 'uses' => 'RoomController@store']);
        Route::get('/{room}', ['middleware' => ['permission:room-view'], 'as' => 'room.show', 'uses' => 'RoomController@show']);
        Route::put('/{room}', ['middleware' => ['permission:room-update'], 'as' => 'room.update', 'uses' => 'RoomController@update']);
        Route::delete('/{room}', ['middleware' => ['permission:room-delete'], 'as' => 'room.destroy', 'uses' => 'RoomController@destroy']);
        Route::post('/{room}', ['middleware' => ['permission:room-delete'], 'as' => 'room.restore', 'uses' => 'RoomController@restore']);
    });

    //SOURCE
    Route::get('/source', ['as' => 'source', 'middleware' => ['permission:source-view|source-create|source-update|source-delete'], 'uses' => 'RouteController@showSourcePage']);
    Route::group(['prefix' => '/data/source', 'middleware' => []], function() {
        Route::get('', ['middleware' => ['permission:source-view'], 'as' => 'source.index', 'uses' => 'SourceController@index']);
        Route::post('', ['middleware' => ['permission:source-create'], 'as' => 'source.store', 'uses' => 'SourceController@store']);
        Route::get('/{source}', ['middleware' => ['permission:source-view'], 'as' => 'source.show', 'uses' => 'SourceController@show']);
        Route::put('/{source}', ['middleware' => ['permission:source-update'], 'as' => 'source.update', 'uses' => 'SourceController@update']);
        Route::delete('/{source}', ['middleware' => ['permission:source-delete'], 'as' => 'source.destroy', 'uses' => 'SourceController@destroy']);
        Route::post('/{source}', ['middleware' => ['permission:source-delete'], 'as' => 'source.restore', 'uses' => 'SourceController@restore']);
    });

    //COURSE
    Route::get('/course', ['as' => 'course', 'middleware' => ['permission:course-view|course-create|course-update|course-delete'], 'uses' => 'RouteController@showCoursePage']);
    Route::group(['prefix' => '/data/course', 'middleware' => []], function() {
        Route::get('', ['middleware' => ['permission:course-view'], 'as' => 'course.index', 'uses' => 'CourseController@index']);
        Route::post('', ['middleware' => ['permission:course-create'], 'as' => 'course.store', 'uses' => 'CourseController@store']);
        Route::get('/{course}', ['middleware' => ['permission:course-view'], 'as' => 'course.show', 'uses' => 'CourseController@show']);
        Route::put('/{course}', ['middleware' => ['permission:course-delete'], 'as' => 'course.update', 'uses' => 'CourseController@update']);
        Route::delete('/{course}', ['middleware' => ['permission:course-delete'], 'as' => 'course.destroy', 'uses' => 'CourseController@destroy']);
        Route::post('/{course}', ['middleware' => ['permission:course-delete'], 'as' => 'course.restore', 'uses' => 'CourseController@restore']);
    
    });
    
    //REPORT
    Route::group(['prefix' => '/report', 'middleware' => []], function() {
        Route::get('', ['as' => 'report', 'uses' => 'RouteController@showReportPage']);
    });

    //TRANSACTION
    Route::group(['prefix' => '/transaction', 'middleware' => []], function() {
        Route::get('', ['as' => 'transaction', 'uses' => 'RouteController@showTransactionPage']);
    });

    //BARCODE
    Route::group(['prefix' => '/barcodes', 'middleware' => []], function() {
        Route::get('', ['as' => 'barcodes', 'uses' => 'RouteController@showBarcodePage']);
    });

    //CATEGORY
    Route::group(['prefix' => '/category', 'middleware' => []], function() {
        Route::get('/role', ['as' => 'category.role', 'uses' => 'CategoryController@getRole']);
        Route::get('/college', ['as' => 'category.college', 'uses' => 'CategoryController@getCollege']);
        Route::get('/room', ['as' => 'category.room', 'uses' => 'CategoryController@getRoom']);
        Route::get('/source', ['as' => 'category.source', 'uses' => 'CategoryController@getSource']);
        Route::get('/collegeuser/{college}', ['as' => 'category.collegeuser', 'uses' => 'CategoryController@getCollegeUser']);
        Route::get('/course/{course}', ['as' => 'category.course', 'uses' => 'CategoryController@getCourse']);
        Route::get('/toolname/{toolname}', ['as' => 'category.toolname', 'uses' => 'CategoryController@getToolName']);
        Route::get('/tooldesc/{tooldesc}', ['as' => 'category.tooldesc', 'uses' => 'CategoryController@getToolDesc']);
        Route::get('/borrower/{borrower}', ['as' => 'category.borrower', 'uses' => 'CategoryController@getBorrower']);
        Route::get('/courseuser/{course}', ['as' => 'category.courseuser', 'uses' => 'CategoryController@getCourseUser']);
        Route::get('/toolcategories', ['as' => 'category.toolcategories', 'uses' => 'CategoryController@getToolCategories']);
        Route::get('/toolcategory/{toolcategory}', ['as' => 'category.toolcategory', 'uses' => 'CategoryController@toolCategory']);
        Route::get('/alltools', ['as' => 'category.alltools', 'uses' => 'CategoryController@getAllTools']);
        Route::get('/reported', ['as' => 'tools.reported', 'uses' => 'CategoryController@getReportedTools']);
        Route::get('/lastid/{lastid}', ['as' => 'category.lastid', 'uses' => 'CategoryController@getLastId']);
        Route::get('/sortcategory', ['as' => 'tools.sortcategory', 'uses' => 'CategoryController@sortCategory']);
        Route::get('/sortitemname', ['as' => 'tools.sortitemname', 'uses' => 'CategoryController@sortItemName']);
        Route::get('/itemname', ['as' => 'tools.itemname', 'uses' => 'CategoryController@itemName']);
        Route::get('/countactive', ['as' => 'dashboard.countactive', 'uses' => 'CategoryController@countActiveBorrower']);
        Route::get('/activeborrower', ['as' => 'dashboard.activeborrower', 'uses' => 'CategoryController@activeBorrower']);
        Route::get('/activeitem', ['as' => 'dashboard.activeitem', 'uses' => 'CategoryController@activeItem']);
        Route::get('/reporteditem', ['as' => 'dashboard.reporteditem', 'uses' => 'CategoryController@reportedItem']);
        Route::get('/useditem', ['as' => 'dashboard.useditem', 'uses' => 'CategoryController@getUsageCount']);
        Route::get('/bannedborrower', ['as' => 'dashboard.bannedborrower', 'uses' => 'CategoryController@bannedBorrower']);
        Route::get('/countbanned', ['as' => 'dashboard.countbanned', 'uses' => 'CategoryController@countBannedBorrower']);
        Route::get('/counttools', ['as' => 'dashboard.counttools', 'uses' => 'CategoryController@countServiceableItems']);
        Route::get('/countonhand', ['as' => 'dashboard.countonhand', 'uses' => 'CategoryController@countOnHandItems']);
        Route::get('/inventorycount', ['as' => 'dashboard.inventorycount', 'uses' => 'CategoryController@inventoryItem']);
        Route::get('/countborrowed', ['as' => 'dashboard.countborrowed', 'uses' => 'CategoryController@countBorrowed']);
        Route::get('/countreported', ['as' => 'dashboard.countreported', 'uses' => 'CategoryController@countReportedItem']);
        Route::get('/lastlhof', ['as' => 'dashboard.lastlhof', 'uses' => 'CategoryController@getLastLHOF']);
        Route::get('/lhofid', ['as' => 'dashboard.lhofid', 'uses' => 'CategoryController@getLastIdLhof']);
        Route::get('/barcode/{barcode}', ['as' => 'dashboard.barcode', 'uses' => 'CategoryController@toolBarcode']);
        Route::get('/borroweditem', ['as' => 'dashboard.borroweditem', 'uses' => 'RequestController@BorrowedItem']);
        Route::get('/returnitem/{item}/borrower/{borrower}/admin/{admin}', ['as' => 'dashboard.return', 'uses' => 'RequestController@getRequestLog']);
        Route::get('/userlhof', ['as' => 'dashboard.userlhof', 'uses' => 'RequestController@lhofDataGetUser']);
        Route::get('/itemlhof/{dat}', ['as' => 'dashboard.itemlhof', 'uses' => 'RequestController@itemLhof']);
    });

    //REPORT
    Route::group(['prefix' => '/report', 'middleware' => []], function() {
        Route::get('/activeborrower', ['as' => 'report.activeborrower', 'uses' => 'ReportController@activeBorrower']);
        Route::get('/bannedborrower', ['as' => 'report.bannedborrower', 'uses' => 'ReportController@bannedBorrower']);
        Route::get('/usageitem/start/{startdate}/end/{enddate}', ['as' => 'report.usageitem', 'uses' => 'ReportController@usageItem']);
        Route::get('/inventory/start/{startdate}/end/{enddate}', ['as' => 'report.inventory', 'uses' => 'ReportController@inventory']);
        Route::get('/reporteditem', ['as' => 'report.reporteditem', 'uses' => 'ReportController@reportedItem']);
        Route::get('/serviceableitem', ['as' => 'report.serviceableitem', 'uses' => 'ReportController@serviceItem']);
        Route::get('/lhofborrower/{dat}', ['as' => 'report.lhofborrower', 'uses' => 'ReportController@lhofBorrower']);
        Route::get('/barcodeitem/{id}', ['as' => 'report.barcodeitem', 'uses' => 'ReportController@barcodeItem']);
        Route::get('/barcodeall', ['as' => 'report.barcodeall', 'uses' => 'ReportController@allBarcode']);
    });

    //LOGOUT
    Route::post('/logout', ['as' => 'logout', 'uses' => 'Auth\LoginController@logout']);
    
});