<?php

namespace App\Exceptions;

use Exception;

class ResourceNotFoundException extends Exception{
    // Redefine the exception so message isn't optional
    public function __construct() {
        // some code

        // make sure everything is assigned properly
        parent::__construct();
    }

    // custom string representation of object
    public function __toString() {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }
}
?>