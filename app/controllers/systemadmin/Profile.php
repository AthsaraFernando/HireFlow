<?php

class Profile extends Controller
{
  public function index()
  {
    $URL['view'] = 'profile';
    $this->view('systemadmin', $URL);
  }
}