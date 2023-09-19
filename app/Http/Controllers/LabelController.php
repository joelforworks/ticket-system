<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Label;
use Symfony\Component\HttpFoundation\Response;

class LabelController extends Controller
{
    /**
     * return all labels
     *
     * @return json 
     */
    public function show(Request $request){
        // gel all labels
        $labels = Label::all();

        // Return response 
        return response()->json([
            'message' => 'Label created',
            'labels' => $labels
        ], Response::HTTP_OK);
    }

    /**
     * return label by id
     *
     * @return json
     */
    public function find(Request $request){
        // validate id
        $validator = new ValidatorCustom($request);
        $validator->validateLabel();

        // Response
        return response()->json([
            'success' => true,
            'label' => Label::find($request->id)
        ], Response::HTTP_OK);

    }
    /**
     * Create  a label 
     *
     * @return json 
     */
    public function create(Request $request) {
        // Validate data and throw errors
        $validator = new ValidatorCustom($request);
        $data = $validator->validateLabelData();

        // Create label
        $label = Label::create($data);

        // Return response 
        return response()->json([
            'message' => 'Label created',
            'label' => $label
        ], Response::HTTP_CREATED);

    }
    /**
     * update  a label 
     *
     * @return json 
     */
    public function update(Request $request) {
        // Validate data and throw errors
        $validator = new ValidatorCustom($request);
        $validator->validateLabel();
        $data = $validator->validateLabelData();

        // Create label
        $label = Label::find($request->id);
        $label->update($data);
        

        // Return response 
        return response()->json([
            'message' => 'Label updated.',
            'label' => $label
        ], Response::HTTP_CREATED);

    }
    /**
     * delete  a label 
     *
     * @return json 
     */
    public function delete(Request $request) {
        // Validate data and throw errors
        $validator = new ValidatorCustom($request);
        $validator->validateLabel();

        // Create label
        $label = Label::find($request->id);
        $label->delete();
        

        // Return response 
        return response()->json([
            'message' => 'Label delete.',
        ], Response::HTTP_OK);

    }
}
