<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use App\Exceptions\ValidationException;
use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class ValidatorCustom {

	protected Request $request;

	public function __construct(Request $request){
		$this->request = $request;
	}

	/**
	 * Validate  storage user
	 *
	 * @return ValidationException | null 
	 */
	public function validateRegisterData(){
		$data = $this->request->only([
			'email',
			'password',
		]);
		$rules = [
			'email'=>'required|email|unique:users',
			'password'=>'required|alpha_num|min:9|max:50'
		];
		$validator = Validator::make($data,$rules);

		if($validator->fails()){
			throw new ValidationException([$validator->errors()]);
		}
	}
	/**
	 * Validate data and if exists admin
	 *
	 * @return ValidationException | null 
	 */
	public function validateRegisterAdminData(){
		$admin = User::where('role','admin')->get();
		$data = $this->request->only([
			'email',
			'password',
		]);
		$rules = [
			'email'=>'required|email|unique:users',
			'password'=>'required|alpha_num|min:9|max:50'
		];
		$validator = Validator::make($data,$rules);

		if($validator->fails()){
			throw new ValidationException([$validator->errors()]);
		}
		if(sizeof($admin)){
			throw new ValidationException(['An administrator already exists']);
		}
	}
	/**
	 * Validate  storage user
	 *
	 * @return ValidationException | null
	 */
	public function validateLoginData(){
		$data = $this->request->only([
			'email',
			'password',
		]);
		$rules = [
			'email'=>'required|email|exists:users',
			'password'=>'required|alpha_num|min:9|max:50'
		];
		$validator = Validator::make($data,$rules);

		if($validator->fails()){
			throw new ValidationException([$validator->errors()]);
		}
	}
		/**
	 * Validate category
	 *
	 * @return ValidationException | category data
	 */
	public function validateCategoryData(){
		$data = $this->request->only([
			'name'
		]);
		$rules = [
			'name'=>'required|string',
		];
		$validator = Validator::make($data,$rules);

		if($validator->fails()){
			throw new ValidationException([$validator->errors()]);
		}
	}
	/**
	 * Validate if category exists
	 *
	 * @return ValidationException | null
	 */
	public function validateCategory(){
		//data 
		$data = $this->request->id;
		$category = Category::find($data);
		if(!$category){
			throw new ValidationException(["Category not found."]);
		}

	}	/**
	 * Validate update category and update
	 *
	 * @return ValidationException | null
	 */
	public function validateUpdateCategoryData(){
		// find category
		$category = Category::find($this->request->id);
		//data
		$data = $this->request->only([
			'name'
		]);
		$category->update($data);
	}
	/**
	 * Validate label
	 *
	 * @return ValidationException | category data
	 */
	public function validateLabelData(){
		$data = $this->request->only([
			'name',
			'color'
		]);
		$rules = [
			'name'=>'required|string',
			'color'=>'required|string',
		];
		$validator = Validator::make($data,$rules);

		// Regular expression pattern for a valid hexadecimal color code.
    $pattern = '/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/';

    // Use preg_match to check if the color code matches the pattern.
    if (!preg_match($pattern, $this->request->color)) {
			throw new ValidationException(['Invalid hexadecimal color code']);
    }

		if($validator->fails()){
			throw new ValidationException([$validator->errors()]);
		}

		return $data;
	}

}
