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
                // For systemadmin and other folder-based controllers
                if (isset($URL[1])) {
                    $controllerName = $this->convertUrlToClassName($URL[1]);
                    $fileName = "../app/controllers/" . $URL[0] . "/" . $controllerName . ".php";
                    if (file_exists($fileName)) {
                        require $fileName;
                        $this->controller = $controllerName;
                        unset($URL[0]); // Remove folder name from URL
                        unset($URL[1]); // Remove controller name from URL
                    } else {
                        $fileName = "../app/controllers/_404.php";
                        require $fileName;
                        $this->controller = '_404';
                    }
                } else {
                    // If no second segment, try the main controller for that folder
                    $folderControllerName = ucfirst($URL[0]);
                    $fileName = "../app/controllers/" . $URL[0] . "/" . $folderControllerName . ".php";
                    if (file_exists($fileName)) {
                        require $fileName;
                        $this->controller = $folderControllerName;
                        unset($URL[0]);
                    } else {
                        $fileName = "../app/controllers/_404.php";
                        require $fileName;
                        $this->controller = '_404';
                    }
                }
            }
        }

        $controller = new $this->controller;
        
        // Selecting the controller's method based on the URL
        // After removing folder and controller segments, check for method
        $remainingURL = array_values($URL); // Re-index array
        if (!empty($remainingURL[0])) {
            if (method_exists($controller, $remainingURL[0])) {
                $this->method = $remainingURL[0];
                unset($remainingURL[0]);
            }
        }
        
        call_user_func_array([$controller, $this->method], array_values($remainingURL));

    }
}





