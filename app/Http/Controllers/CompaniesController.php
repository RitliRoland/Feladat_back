<?php

namespace Feladat\Http\Controllers;

use Feladat\companies;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Redirect;
use Illuminate\Support\Facades\Validator;
use Auth;
use Illuminate\Support\Facades\Storage;

class CompaniesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public static function index()
    {
        $companies = companies::all();
		
		return $companies;
    }
	
	public static function get_list_name_id(){
		$companies = companies::select('Name','id')->get();
		
		return $companies;
	}
	
	public function get_image($id){
		$companies = companies::select('Logo')->where('id', $id)->get();
		return $companies[0]->Logo;
	}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if(Auth::guest()){
			return redirect('/');
		}
		if ($this->store(1)->fails()){
		    return redirect('companie');
		}
		
			$image = $request->file('logo');
			$name = time().'.'.$image->getClientOriginalExtension();
			$destinationPath = public_path('../storage/app/public');
			$image->move($destinationPath, $name);



		try{
			$companies = new companies;
			$companies->Logo = $name;
			$companies->Name = Input::get("name");
			$companies->Email = Input::get("email");
			$companies->Website = Input::get("website");
			$companies->save();
		} catch(\Illuminate\Database\QueryException $ex){ 
			return redirect('companie'); 
		}
		
		return Redirect::back();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($id)
    {
		if($id==1){
			$rules = array(
				'logo' => 'required|image|mimes:jpeg,png,jpg|dimensions:min_width=100,min_height=100',
				'name' => 'required|min:2|max:30',
				'email' => 'required|email',
				'website' => 'required|url',
			);
		}
		else{
			$rules = array(
				'name' => 'required|min:2|max:30',
				'email' => 'required|email',
				'website' => 'required|url',
			);
		}
        return Validator::make(Input::all(), $rules);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\cr  $cr
     * @return \Illuminate\Http\Response
     */
    public function show(cr $cr)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\cr  $cr
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        if(Auth::guest()){
			return redirect('/');
		}
		if ($this->store(2)->fails()){
		    return redirect('companie');
		}
		$id = Input::get("id");
		$id=(int)$id;
		if($id==0) return redirect('companie');
		$name = Input::get("name");
		$email = Input::get("email");
		$website = Input::get("website");
		
		$image = $this->get_image($id);
		
		if ($request->hasFile('logo')) {
			if ($this->store(1)->fails()){
				return redirect('companie');
			}
			
			Storage::delete('/public/' . $image);
			
			$image = $request->file('logo');
			$name_image = time().'.'.$image->getClientOriginalExtension();
			$destinationPath = public_path('../storage/app/public');
			$image->move($destinationPath, $name_image);
		}
		else{
			$name_image=$image;
		}
		try{
			companies::where('id',$id)->update(array(
							 'Logo'=>$name_image,
							 'Name'=>$name,
							 'Website'=>$website,
							 'Email'=>$email,
			));
		} catch(\Illuminate\Database\QueryException $ex){ 
			return redirect('companie'); 
		}
		
		return Redirect::back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\cr  $cr
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, cr $cr)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\cr  $cr
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        if(Auth::guest()){
			return redirect('/');
		}
		$companie= Input::get("id");
		$companie=(int)$companie;
		if($companie==0) return redirect('companie');
		try{
			$rsltDelRec = companies::find($companie);
			$image = $this->get_image($companie);
			Storage::delete('/public/' . $image);
			$rsltDelRec->delete();
		} catch(\Illuminate\Database\QueryException $ex){ 
			return redirect('companie'); 
		}
		return Redirect::back();
    }
}
