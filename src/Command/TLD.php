<?php

namespace MadeITBelgium\Versio\Command;

/**
 * Versio API.
 *
 * @version    1.0.0
 *
 * @copyright  Copyright (c) 2018 Made I.T. (http://www.madeit.be)
 * @author     Made I.T. <info@madeit.be>
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-3.txt    LGPL
 */
class TLD
{
    private $versio;

    /**
     * set Versio.
     *
     * @param $versio
     */
    public function setVersio($versio)
    {
        $this->versio = $versio;
    }

    /**
     * get Versio.
     *
     * @param $versio
     */
    public function getVersio()
    {
        return $this->versio;
    }

    public function get($tld)
    {
        return $this->versio->get('/tld/info/'.$tld);
    }

    public function info()
    {
        return $this->versio->get('/tld/info');
    }
}
