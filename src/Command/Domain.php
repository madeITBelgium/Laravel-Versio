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
class Domain
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

    public function check($domainname)
    {
        return $this->versio->get('/domains/'.$domainname.'/availability');
    }

    public function delete($domainname)
    {
        return $this->versio->delete('/domains/'.$domainname);
    }

    public function get($domainname)
    {
        return $this->versio->get('/domains/'.$domainname);
    }

    public function all($status = null)
    {
        return $this->versio->get('/domains'.($status != null ? '?status='.$status : ''));
    }

    public function register($domain, $contactID, $years = 1, $auto_renew = true, $ns = [])
    {
        return $this->versio->post('/domains/'.$domain, [
            'contact_id' => $contactID,
            'years'      => $years,
            'auto_renew' => $auto_renew,
            'ns'         => $ns,
        ]);
    }

    public function renew($domain, $years)
    {
        return $this->versio->post('/domains/'.$domain.'/renew', [
            'years' => $years,
        ]);
    }

    public function transfer($domain, $contactID, $auth_code, $years = 1, $auto_renew = true, $ns = [])
    {
        return $this->versio->post('/domains/'.$domain.'/transfer', [
            'contact_id' => $contactID,
            'years'      => $years,
            'auth_code'  => $auth_code,
            'auto_renew' => $auto_renew,
            'ns'         => $ns,
        ]);
    }

    public function transferOut($domain, $tag)
    {
        return $this->versio->post('/domains/'.$domain.'/update/nominettag', [
            'tag' => $tag,
        ]);
    }

    public function transferStatus($domain, $process_id)
    {
        return $this->versio->get('/domains/'.$domain.'/transfer/'.$process_id);
    }

    public function update($domain, $data)
    {
        return $this->versio->post('/domains/'.$domain.'/update', $data);
    }
}
