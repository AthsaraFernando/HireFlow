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
        // show($URL);
        $fileName = "../app/controllers/" . ucfirst($URL[0]) . ".php";
        if (file_exists($fileName)) {
            require $fileName;
            $this->controller = ucfirst($URL[0]);
            unset($URL[0]);
        } else {
            // Check for subdirectory controllers (like hradmin/Jobposting.php)
            $fileName = "../app/controllers/" . $URL[0] . "/" . ucfirst($URL[1]) . ".php";
            if (file_exists($fileName)) {
                require $fileName;
                $this->controller = ucfirst($URL[1]);
                unset($URL[0]);
                unset($URL[1]);
            } else {
                $fileName = "../app/controllers/_404.php";
                require $fileName;
                $this->controller = '_404';
            }
        }

        $controller = new $this->controller;
        
        // Selecting the controller's method based on the URL
        // After unset operations, the method is now at index 0 (reindexed)
        $URL = array_values($URL); // Reindex the array after unset operations
        if (!empty($URL[0])) {
            if (method_exists($controller, $URL[0])) {
                $this->method = $URL[0];
                unset($URL[0]);
            }
        }
        
        // Reindex again for parameters
        $URL = array_values($URL);
        call_user_func_array([$controller, $this->method], $URL);
    }
}





