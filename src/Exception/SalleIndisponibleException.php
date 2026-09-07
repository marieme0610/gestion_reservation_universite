<?php

namespace App\Exception;

use Throwable;

class SalleIndisponibleException extends \Exception{

    public function __construct(string $message = "Reservation indisponible")
    {
        return parent::__construct($message);
    }
}