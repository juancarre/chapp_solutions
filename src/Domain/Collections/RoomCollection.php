<?php


namespace App\Domain\Collections;

use JsonSerializable;

class RoomCollection extends Collection implements JsonSerializable
{

    /**
     * RoomCollection constructor.
     * @param array $roomCollection
     */
    public function __construct(array $roomCollection = [])
    {
        parent::__construct($roomCollection, 'Room');
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