<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Label;
use Symfony\Component\HttpFoundation\Response;

class LabelController extends Controller
{
    /**
     * Create  a label 
     *
     * @return json 
     */
    public function create(Request $request) {
        // Validate data and throw errors
        $validator = new ValidatorCustom($request);
        $data = $validator->validateLabelData();

        // Create category
        $label = Label::create($data);

        // Return response 
        return response()->json([
            'message' => 'Label created',
            'label' => $label
        ], Response::HTTP_CREATED);

    }
}
