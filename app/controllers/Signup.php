<?php

class Signup extends Controller
{

    public function index()
    {
        $data = [];
        $user = new User;
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($user->signUpValidate($_POST)) {
                $arr['full_name'] = $_POST['first_name'] . $_POST['last_name'];
                $arr['email'] = $_POST['email'];
                $arr['password'] = $_POST['password'];
                $arr['role_id'] = 4;
                $user->insert($arr);
                redirect('signin');
            }
        }

        $data['errors'] = $user->errors;
        $this->view('signup', $data);
    }
}