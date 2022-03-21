<?php


namespace App\Domain\Collections;

use JsonSerializable;

class ReservationCollection extends Collection implements JsonSerializable
{

    /**
     * ReservationCollection constructor.
     * @param array $reservationCollection
     */
    public function __construct(array $reservationCollection = [])
    {
        parent::__construct($reservationCollection, 'Reservation');
    }

    function jsonSerialize()
    {
        $var = get_object_vars($this);
        foreach($var as &$value){
            if(is_object($value) && method_exists($value,'jsonSerialize')){
                $value = $value->jsonSerialize();
            }
        }
        return $var;
    }
}