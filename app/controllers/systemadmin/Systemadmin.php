<?php

class Systemadmin extends Controller
{
    public function index()
    {
        // $data['username'] = empty($_SESSION['USER']) ? 'User' : $_SESSION['USER']['email'];
        echo 'System Admin Controller';
        $this->view('systemadmin');

    }

    public function dashboard()
    {

        if (!empty($URL)) {
            extract($URL);
        }

        $URL['param0'] = 'dashboard';

        $this->view('systemadmin', $URL);
    }

    public function usermanage()
    {

        if (!empty($URL)) {
            extract($URL);
        }

        $URL['param0'] = 'usermanage';

        $this->view('systemadmin', $URL);
    }

    public function viewdata()
    {

        if (!empty($URL)) {
            extract($URL);
        }

        $URL['param0'] = 'viewdata';

        $this->view('systemadmin', $URL);
    }

    public function accesslogs()
    {

        if (!empty($URL)) {
            extract($URL);
        }

        $URL['param0'] = 'accesslogs';

        $this->view('systemadmin', $URL);
    }

}
