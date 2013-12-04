<?php
namespace Marker;

/**
 * Description of NotAForeignFieldException
 *
 * @author ahmad
 */
class NotAPointerFieldException extends \Exception{
    public function __construct($message = 'Accessing parent list for a none foreign field', $code = 10000, $previous = null) {
        parent::__construct($message, $code, $previous);
    }

}
