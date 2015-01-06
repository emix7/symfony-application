<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace AppBundle\Exception;

use Exception;

class InvalidTypeException extends Exception
{
    public function __construct($expectedType, $type, $code = 0, Exception $previous = null)
    {
        $message = sprintf('Invalid type: expected %s, but got %s', $expectedType, $type);

        parent::__construct($message, $code, $previous);
    }
}
