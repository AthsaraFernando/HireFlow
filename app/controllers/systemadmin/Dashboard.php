<?php

class Dashboard extends Controller
{

    public function index()
    {
        $URL['view'] = 'dashboard';

        // $user = new User;
        // $rows = $user->findAll();
        // $URL['users'] = is_array($rows) && count($rows) > 0 ? $rows : [];
        $role = new Role;
        $rows = $role->findAll();
        $URL['roles'] = is_array($rows) && count($rows) > 0 ? $rows : [];

        // show($URL);

        $this->view('systemadmin', $URL);
    }
}