<?php

class Usermanage extends Controller 
{
  public function index()
    {
        $URL['view'] = 'usermanage';
        $this->view('systemadmin', $URL);
    }
}