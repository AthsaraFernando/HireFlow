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
    private function convertUrlToClassName($url) {
        // Convert hyphenated URL segments to PascalCase class names
        // e.g., "job-posts" -> "JobPosts", "create-job" -> "CreateJob"
        return str_replace(' ', '', ucwords(str_replace('-', ' ', $url)));
    }
    
    public function loadController()
    {
        $URL = $this->splitURL();
        // show($URL);
        
        // First check for direct controller files (e.g., Home.php, Signin.php)
        $fileName = "../app/controllers/" . ucfirst($URL[0]) . ".php";
        if (file_exists($fileName)) {
            require $fileName;
            $this->controller = ucfirst($URL[0]);
            unset($URL[0]);
        } else {
            // Check for folder-based controllers (e.g., systemadmin/Dashboard.php, applicant/Applicant.php)
            
            // Special handling for applicant routes - all go to main Applicant controller
            if ($URL[0] === 'applicant') {
                $fileName = "../app/controllers/applicant/Applicant.php";
                if (file_exists($fileName)) {
                    require $fileName;
                    $this->controller = 'Applicant';
                    unset($URL[0]); // Remove 'applicant' from URL array
                } else {
                    $fileName = "../app/controllers/_404.php";
                    require $fileName;
                    $this->controller = '_404';
                }
            } else {
                // For other folder-based controllers, convert URL to class name
                $controllerName = $this->convertUrlToClassName($URL[1]);
                $fileName = "../app/controllers/" . $URL[0] . "/" . $controllerName . ".php";
                if (file_exists($fileName)) {
                    require $fileName;
                    $this->controller = $controllerName;
                } else {
                    $fileName = "../app/controllers/_404.php";
                    require $fileName;
                    $this->controller = '_404';
                }
            }
        }

        $controller = new $this->controller;
        
        // Selecting the controller's method based on the URL
        if (!empty($URL[1])) {
            if (method_exists($controller, $URL[1])) {
                $this->method = $URL[1];
                unset($URL[1]);
            }
        }
        
        call_user_func_array([$controller, $this->method], $URL);

    }
}





