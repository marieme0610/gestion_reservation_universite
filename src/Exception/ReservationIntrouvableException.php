<?php

namespace App\Exception;

use Throwable;

class ReservationIntrouvableException extends \Exception{

    public function __construct(string $message = "La réservation demandée est introuvable.")
    {
        return parent::__construct($message);
    }
}