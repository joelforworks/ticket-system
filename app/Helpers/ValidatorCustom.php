<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class ValidatorCustom {

	protected Request $request;

	public function __construct(Request $request){
		$this->request = $request;
	}

	public function validateUserStoreData(){
		$data = $this->request->only([
			'email',
			'password',
		]);
		$rules = [
			'email'=>'required|email|users:unique',
			'password'=>'required|alpha_num|min:9|max:50'
		];
		$validator = Validator::make($data,$rules);

		if($validator->fails()){
		}
	}
}
