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
class Contact
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

    public function create($data)
    {
        return $this->versio->post('/contacts', $data);
    }

    public function delete($contactID)
    {
        return $this->versio->delete('/contacts/'.$contactID);
    }

    public function all()
    {
        return $this->versio->get('/contacts');
    }

    public function get($contactID)
    {
        return $this->versio->get('/contacts/'.$contactID);
    }

    public function resendvalidation($contactID)
    {
        return $this->versio->post('/contacts/'.$contactID.'/resendvalidation');
    }
}
