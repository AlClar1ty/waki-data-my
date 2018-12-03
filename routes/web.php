<?php

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

Auth::routes();

// url -> waki-data.com/
// if admin, go to /dashboard
// if not admin, go to /data
// if not authenticated go to /login
Route::get('/', function () {
    if(Auth::check())
    {
    	if(Auth::user()->roles->first()->slug == 'admin')
    	{
    		return redirect()->route('dashboard');
    	}
    	else
    	{
    		return redirect()->route('data');
    	}
    }
    else
    {
    	return redirect()->route('login');
    }
});

//-- DASHBOARD --//
Route::get('/dashboard', 'DashboardController@index')
	->name('dashboard')
	->middleware('can:dashboard');

//-- MASTER DATA --//
Route::group(['prefix' => 'data'], function () {
    //Browser
    Route::get('/', 'DataController@index')
    	->name('data')
    	->middleware('auth');

        
    //Add Data Undangan
    Route::post('/adddataundangan', 'DataController@storeDataUndangan')
        ->name('store_dataundangan')
        ->middleware('can:add-data-undangan');
    //Add Data Outsite
    Route::post('/adddataoutsite', 'DataController@storeDataOutsite')
        ->name('store_dataoutsite')
        ->middleware('can:add-data-outsite');
    //Add Data Therapy
    Route::post('/adddatatherapy', 'DataController@storeDataTherapy')
        ->name('store_datatherapy')
        ->middleware('can:add-data-therapy');
    //Add Data MPC
    Route::post('/addmpc', 'DataController@storeMpc')
        ->name('store_mpc')
        ->middleware('can:add-mpc');


    //Edit Data Outsite
    Route::post('/editdataoutsite', 'DataController@updateDataOutsite')
        ->name('update_dataoutsite')
        ->middleware('can:edit-data-outsite');
    //Edit Data Undangan
    Route::post('/editdataundangan', 'DataController@updateDataUndangan')
        ->name('update_dataundangan')
        ->middleware('can:edit-data-undangan');
    //Edit Data Therapy
    Route::post('/editdatatherapy', 'DataController@updateDataTherapy')
        ->name('update_datatherapy')
        ->middleware('can:edit-data-therapy');
    //Edit Mpc
    Route::post('/editmpc', 'DataController@updateMpc')
        ->name('update_mpc')
        ->middleware('can:edit-mpc');


    //Find Mpc
    Route::post('/findmpc', 'DataController@findMpc')
        ->name('find_mpc')
        ->middleware('can:find-mpc');
    //Find Data Outsite
    Route::post('/finddataoutsite', 'DataController@findDataOutsite')
        ->name('find_dataoutsite')
        ->middleware('can:find-data-outsite');

    //Delete Data Outsite
    Route::post('/deletedataoutsite', 'DataController@deleteDataOutsite')
        ->name('delete_dataoutsite')
        ->middleware('can:delete-data-outsite');
});

//-- MASTER DATA TYPE --//
Route::group(['prefix' => 'datatype'], function () {
	//Browse
	Route::get('/', 'TypeCustController@index')
		->name('type_cust')
		->middleware('can:browse-type-cust,add-type-cust');
	//Add
	Route::post('/', 'TypeCustController@store')
		->name('store_type_cust')
		->middleware('can:add-type-cust');
	//Edit
	Route::post('/edit/', 'TypeCustController@update')
        ->name('update_type_cust')
        ->middleware('can:edit-branch');
    //Delete
	Route::post('/{typecust}', 'TypeCustController@delete')
		->name('delete_type_cust')
		->middleware('can:delete-type-cust,typecust');
});

//-- MASTER BRANCH --//
Route::group(['prefix' => 'branch'], function () {
	//Browse
	Route::get('/', 'BranchController@index')
		->name('branch')
		->middleware('can:browse-branch,add-branch');
	//Add
	Route::post('/', 'BranchController@store')
		->name('store_branch')
		->middleware('can:add-branch');
	//Edit
	Route::post('/edit/', 'BranchController@update')
        ->name('update_branch')
        ->middleware('can:edit-branch');
    //Delete
	Route::post('/{branch}', 'BranchController@delete')
		->name('delete_branch')
		->middleware('can:delete-branch,branch');
});

//-- MASTER CSO --//
Route::group(['prefix' => 'cso'], function () {
	//Browse
	Route::get('/', 'CsoController@index')
		->name('cso')
		->middleware('can:browse-cso,add-cso');
	//Add
	Route::post('/', 'CsoController@store')
		->name('store_cso')
		->middleware('can:add-cso');
	//Edit
	Route::post('/edit/', 'CsoController@update')
        ->name('update_cso')
        ->middleware('can:edit-cso');
    //Delete
	Route::post('/{cso}', 'CsoController@delete')
		->name('delete_cso')
		->middleware('can:delete-cso,cso');
});

//-- MASTER USER --//
Route::group(['prefix' => 'user'], function () {
	//Browse
	Route::get('/', 'UserController@index')
		->name('user')
		->middleware('can:browse-user,add-user');
	//Add
	Route::post('/', 'UserController@store')
		->name('store_user')
		->middleware('can:add-user');
	//Edit
	Route::post('/edit/', 'UserController@update')
        ->name('update_user')
        ->middleware('can:edit-user');
    //Delete
	Route::post('/{user}', 'UserController@delete')
		->name('delete_user')
		->middleware('can:delete-user,user');
});

//-- PASSWORD --//
Route::post('/changePassword','AjaxController@changePassword')->name('changePassword');

//-- AJAX --//
Route::post('/selectCountry', 'AjaxController@selectCountry')
    ->name('select-country');

Route::post('/selectBranch', 'AjaxController@selectBranch')
    ->name('select-branch');

Route::post('/checkBranchCode', 'AjaxController@checkBranchCode')
    ->name('check-branch-code');

Route::post('/checkChangePassword', 'AjaxController@checkChangePassword')
    ->name('check-change-password');

Route::post('/selectCity', 'AjaxController@selectCity')
    ->name('select-city');

Route::post('/selectPostcode', 'AjaxController@selectPostcode')
    ->name('select-postcode');

// Route::get('/home', 'HomeController@index')->name('home');

// Route::get('/', 'MemberController@index')->middleware('auth');

// Route::get('/', function () {
//     return view('welcome');
// });
