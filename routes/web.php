<?php /*
|--------------------------------------------------------------------------
| Web Routes --------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These routes are loaded by the RouteServiceProvider within a group which contains the "web" middleware group. Now create something great!
|
*/
use Feladat\Http\Controllers\EmployeesController;
use Feladat\Http\Controllers\CompaniesController;

Route::get('/', function () {
	$employees = EmployeesController::index();
	
    return view('welcome')->with('Employees',$employees);
});

Route::get('/companie', function () {
    $companies = CompaniesController::index();
	
    return view('companies')->with('Companies',$companies);
});

Route::get('/employee', function () {
    $employees = EmployeesController::index();
	$companies = CompaniesController::get_list_name_id();
	
    return view('employees')->with('Employees',$employees)->with('Companies',$companies);
});

Route::get('login', function () {
    return view('auth/login');
});

Route::get('storage/{filename}', function ($filename)
{
    return Image::make(storage_path('public/' . $filename))->response();
});

Auth::routes();

Route::post("/add_employee", "EmployeesController@create");

Route::post("/add_companie", "CompaniesController@create");

Route::post("/update_employee", "EmployeesController@edit");

Route::post("/update_companie", "CompaniesController@edit");

Route::get('/delete_employee', "EmployeesController@destroy");

Route::get('/delete_companie', "CompaniesController@destroy");

Route::get('/home', 'HomeController@index')->name('home');
