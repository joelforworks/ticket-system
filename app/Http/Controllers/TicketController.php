<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Ticket;

class TicketController extends Controller
{
    /**
     * Show all Tickets
     *
     * @return json 
     */
    public function show(Request $request){
        // Create Ticket
        $tickets = Ticket::all();

        // Return response 
        return response()->json([
            'success' => true,
            'tickets' => $tickets
        ], Response::HTTP_OK);

    }
    /**
     * find by ticket id
     *
     * @return json 
     */
    public function find(Request $request){
        // validate Ticket
        $validator = new ValidatorCustom($request);
        $ticket = $validator->validateTicket();

        // Return response 
        return response()->json([
            'success' => true,
            'ticket' => $ticket
        ], Response::HTTP_OK);

    }
    /**
     * create a Ticket
     *
     * @return json 
     */
    public function create(Request $request){
        // validate data and throw errors
        $validator = new ValidatorCustom($request);
        $data = $validator->validateStoreTicketData();
        // Create Ticket
        $ticket = Ticket::create($data);

        // Return response 
        return response()->json([
            'message' => 'Ticket created',
            'ticket' => $ticket
        ], Response::HTTP_CREATED);

    }
    /**
    * create a Ticket
    *
    * @return json 
    */
    public function update(Request $request,$id){
        // validate data and throw errors
        $validator = new ValidatorCustom($request);
        $validator->validateTicket();
        $data = $validator->validateUpdateTicketData();

        // update Ticket
        $ticket = Ticket::find($id);
        $ticket->update($data);

        // Return response 
        return response()->json([
            'message' => 'Ticket updated',
            'ticket' => $ticket
        ], Response::HTTP_CREATED);

    }
    /**
     * delete ticket 
     *
     * @return json
     */
    public function delete(Request $request){
        // validate Ticket
        $validator = new ValidatorCustom($request);
        $ticket = $validator->validateTicket();

        $ticket->delete();
        // Return response
        return response()->json([
            'success'=>true,
            'message' => 'Ticket deleted',
        ], Response::HTTP_OK);

    }

}
