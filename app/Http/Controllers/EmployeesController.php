<?php

namespace Feladat\Http\Controllers;

use Illuminate\Http\Request;
use Feladat\employees;
use Illuminate\Support\Facades\Input;
use Redirect;
use Illuminate\Support\Facades\Validator;
use Auth;

class EmployeesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public static function index()
    {
        $employees = employees::join('companies', 'Company', '=', 'companies.id')
		->select('employees.First_name','employees.Last_name','companies.Name as Companie','employees.Email','employees.Phone','employees.id')
		->get();
		
		return $employees;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
		if(Auth::guest()){
			return redirect('/');
		}
		if ($this->store()->fails()){
		    return redirect('employee');
		}
		try {
			$employee = new employees;
			$employee->First_name = Input::get("first_name");
			$employee->Last_name = Input::get("last_name");
			$employee->Company = Input::get("companie");
			$employee->Email = Input::get("email");
			$employee->Phone = Input::get("phone");
			$employee->save();
		} catch(\Illuminate\Database\QueryException $ex){ 
			return redirect('employee'); 
		}
		
		return Redirect::back();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $rules = array(
            'first_name' => 'required|min:2|max:30',
			'last_name' => 'required|min:2|max:30',
			'companie' => 'required|numeric',
			'email' => 'required|email',
			'phone' => 'required|numeric',
			
        );
        return Validator::make(Input::all(), $rules);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\employees  $employees
     * @return \Illuminate\Http\Response
     */
    public function show(employees $employees)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\employees  $employees
     * @return \Illuminate\Http\Response
     */
    public function edit(employees $employees)
    {
		if(Auth::guest()){
			return redirect('/');
		}
		if ($this->store()->fails()){
		    return redirect('employee');
		}
		$id = Input::get("id");
		$id=(int)$id;
		if($id==0) return redirect('employee');
		$first_name = Input::get("first_name");
		$last_name = Input::get("last_name");
		$company = Input::get("companie");
		$email = Input::get("email");
		$phone = Input::get("phone");
		
		try {
			employees::where('id',$id)->update(array(
				'First_name'=>$first_name,
				'Last_name'=>$last_name,
				'Company'=>$company,
				'Email'=>$email,
				'Phone'=>$phone,
			));
		} catch(\Illuminate\Database\QueryException $ex){ 
			return redirect('employee'); 
		}
		
		return Redirect::back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\employees  $employees
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, employees $employees)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\employees  $employees
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
		if(Auth::guest()){
			return redirect('/');
		}
		$employee= Input::get("id");  
		$employee=(int)$employee;
		if($employee==0) return redirect('employee');
		try {
			$rsltDelRec = employees::find($employee);
			$rsltDelRec->delete();
		} catch(\Illuminate\Database\QueryException $ex){ 
			return redirect('employee'); 
		}
		return Redirect::back();
    }
}
