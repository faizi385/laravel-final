<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReservationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $reservationData;

    public function __construct($reservationData)
    {
        $this->reservationData = $reservationData;
    }

    public function build()
    {
        return $this->view('emails.reservation')
                    ->with([
                        'name' => $this->reservationData['name'] ?? '',
                        'email' => $this->reservationData['email'] ?? '',
                        'phone_number' => $this->reservationData['phone_number'] ?? '',
                        'location_to_visit' => $this->reservationData['location_to_visit'] ?? '',
                        'check_in_date' => $this->reservationData['check_in_date'] ?? '',
                        'check_out_date' => $this->reservationData['check_out_date'] ?? '',
                        'number_of_guests' => $this->reservationData['number_of_guests'] ?? '',
                        'any_kids' => $this->reservationData['any_kids'] ?? '',
                        'message' => $this->reservationData['message'] ?? '',
                    ]);
    }
}
