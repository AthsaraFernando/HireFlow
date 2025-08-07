<?php

class Signin extends Controller
{
    public function index()
    {
        $data = [];
        $user = new User;
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($user->signInValidate($_POST, $user)) {
                $user_role = (int) $_SESSION['USER']['role_id'];
                switch ($user_role) {
                    case 1:
                        redirect('systemadmin/systemadmin');
                        exit(); 
                    case 2:
                        redirect('hradmin/hradmin');
                        exit();
                    case 3:
                        redirect('recruitmanager/recruitmanager');
                        exit();
                    case 4:
                        redirect('applicant/applicant');
                        exit();
                    default:
                        redirect('404');
                        exit();
                }
            }
        }

        $data['errors'] = $user->errors;
        $this->view('home', $data);
    }

}