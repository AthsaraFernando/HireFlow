<?php

class Viewdata extends Controller 
{
    public function index()
    {
        $URL['view'] = 'viewdata';
        $this->view('systemadmin', $URL);
    }
}