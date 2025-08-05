<?php

class _404 extends Controller
{
    public function index()
    {
        echo 'Called the 404 controller';
        $this->view('404');

    }

}