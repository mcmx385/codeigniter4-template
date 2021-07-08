<?php

namespace App\Libraries\AjaxTokens;

class Token
{
    // Cleaning frequency
    protected $expire_sec = 30 * 60;
    protected $trash_sec = 24 * 60 * 60;
    // protected $trash_sec = 5 * 60;

    public function __construct()
    {
        $this->model = new \App\Models\AjaxToken();
        $this->stringL = new \App\Libraries\stringLib();
        $this->dtL = new \App\Libraries\datetimeLib();
        // $this->clean();
    }

    // Generates md5 encrypted (letter + symbol generated string)
    public function generate()
    {
        return md5($this->stringL->generateRandomString());
    }


    // Soft delete ID too long time ago, defined above
    public function clean()
    {
        $this->model->remove(['created_at <' => $this->dtL->pastDT($this->dtL->currentDT(), $this->expire_sec), 'deleted_at' => '0000-00-00 00:00:00']);
        $this->model->destroy(['deleted_at <' => $this->dtL->pastDT($this->dtL->currentDT(), $this->trash_sec)]);
    }


    // Get ID using params, if still active, return ID, if deleted, renew with new ID, if new action, create new
    public function ID($params)
    {
        if ($id = $this->model->getId($params)) :
            return $id;
        else :
            if ($id = $this->model->getDeletedId($params)) :
                return $this->model->renew($id, $this->generate());
            else :
                return $this->model->create($this->generate(), $params);
            endif;
        endif;
    }


    // Get action info with existing ID
    public function info($id)
    {
        return (object) json_decode($this->model->getInfo($id));
    }
}
