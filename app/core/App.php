<?php

class App
{
    private $controller = 'Home';
    private $method = 'index';
    private function splitURL()
    {
        $URL = $_GET['url'] ?? 'home';
        $URL = explode("/", trim($URL, "/"));
        return $URL;
    }
    public function loadController()
    {
        $URL = $this->splitURL();
        
        // First check if it's a direct controller file (like Home.php, Signin.php)
        $fileName = "../app/controllers/" . ucfirst($URL[0]) . ".php";
        if (file_exists($fileName)) {
            require $fileName;
            $this->controller = ucfirst($URL[0]);
            unset($URL[0]);
        } else {
            // Check for folder-based controllers (systemadmin, applicant, etc.)
            if (isset($URL[1])) {
                $fileName = "../app/controllers/" . $URL[0] . "/" . ucfirst($URL[1]) . ".php";
                if (file_exists($fileName)) {
                    require $fileName;
                    $this->controller = ucfirst($URL[1]);
                    unset($URL[0]);
                    unset($URL[1]);
                } else {
                    // 404 error
                    $fileName = "../app/controllers/_404.php";
                    require $fileName;
                    $this->controller = '_404';
                }
            } else {
                // 404 error
                $fileName = "../app/controllers/_404.php";
                require $fileName;
                $this->controller = '_404';
            }
        }

        $controller = new $this->controller;
        
        // Handle method routing for folder-based controllers
        if (!empty($URL[2])) {
            if (method_exists($controller, $URL[2])) {
                $this->method = $URL[2];
                unset($URL[2]);
            }
        } else if (!empty($URL[1]) && $this->controller != '_404') {
            // For direct controllers, check if method exists in URL[1]
            if (method_exists($controller, $URL[1])) {
                $this->method = $URL[1];
                unset($URL[1]);
            }
        }
        
        call_user_func_array([$controller, $this->method], $URL);
    }
}





