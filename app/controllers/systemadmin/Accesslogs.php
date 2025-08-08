<?php

class Accesslogs extends Controller 
{

    public function index()
    {
        $URL['view'] = 'accesslogs';
        $this->view('systemadmin', $URL);
    }
}
