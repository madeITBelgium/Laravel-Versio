<?php

namespace MadeITBelgium\Versio\Exceptions;

use Exception;

/**
 * Offrea PHP SDK.
 *
 * @version    1.0.0
 *
 * @copyright  Copyright (c) 2018 Offrea (http://www.offrea.be)
 * @author     Tjebbe Lievens <tjebbe@offrea.be>
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-3.txt    LGPL
 */
class ContactNotFoundException extends Exception
{
    public function __construct(Exception $previous = null)
    {
        parent::__construct('Contact not found.', 401, $previous);
    }
}
