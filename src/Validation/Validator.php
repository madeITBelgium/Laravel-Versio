<?php

namespace MadeITBelgium\Versio\Validation;

use MadeITBelgium\Versio\Versio;

class Validator
{
    public function isDomainAvailable($value)
    {
        $email = '';
        $password = '';
        $test = false;
        if (function_exists('config')) {
            $email = config('versio.email');
            $password = config('versio.password');
            $test = config('versio.test');
        }

        $version = new Versio($email, $password, null, $test);

        try {
            $version = $version->domain()->check($value);
            if (isset($version['available']) && $version['available']) {
                return true;
            }
        } catch (\Excpetion $e) {
        }

        return false;
    }
}
