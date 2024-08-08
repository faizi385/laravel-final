<?php



namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\ReservationMail;
use Illuminate\Support\Facades\Mail;

class ReservationController extends Controller
{
    public function store(Request $request)
    {
        // Validate the request data
        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'phone_number' => 'required|string',
            'location_to_visit' => 'required|string',
            'check_in_date' => 'required|date',
            'check_out_date' => 'required|date',
            'number_of_guests' => 'required|integer',
            'any_kids' => 'required|boolean',
            'message' => 'nullable|string',
        ]);

        // Send the email
        Mail::to('faizannovatore@example.com')->send(new ReservationMail($validated));

        // Return a response
        return response()->json(['message' => 'Reservation request submitted successfully.']);
    }
}
