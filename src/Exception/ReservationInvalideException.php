<?php

namespace App\Exception;

class ReservationInvalideException extends \Exception
{
    public function __construct(string $message = "Les données de la réservation sont invalides.")
    {
        parent::__construct($message);
    }
}