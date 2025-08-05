<?php

class Home extends Controller
{
    public function index()
    {
        // $data['username'] = empty($_SESSION['USER']) ? 'User' : $_SESSION['USER']['email'];
        echo 'Called the home controller';
        $this->view('home');
    }


}
