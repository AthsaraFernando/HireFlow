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

    private function resolveControllerFile($directory, $expectedClassName)
    {
        $directory = rtrim($directory, '/');
        $exactFile = $directory . '/' . $expectedClassName . '.php';

        if (file_exists($exactFile)) {
            return [$exactFile, $expectedClassName];
        }

        if (!is_dir($directory)) {
            return [null, null];
        }

        foreach (scandir($directory) as $file) {
            if ($file === '.' || $file === '..') {
                continue;
            }

            if (strtolower(pathinfo($file, PATHINFO_EXTENSION)) !== 'php') {
                continue;
            }

            $stem = pathinfo($file, PATHINFO_FILENAME);
            if (strtolower($stem) === strtolower($expectedClassName)) {
                return [$directory . '/' . $file, $stem];
            }
        }

        return [null, null];
    }
    
    public function loadController()
    {
        $URL = $this->splitURL();
        
        // Global authentication check
        $this->checkGlobalAuth($URL);
        
        // show($URL);
        
        // First check for direct controller files (e.g., Home.php, Signin.php)
        list($fileName, $controllerName) = $this->resolveControllerFile("../app/controllers", ucfirst($URL[0]));
        if ($fileName) {
            require $fileName;
            $this->controller = $controllerName;
            unset($URL[0]);
        } else {
            // Check for folder-based controllers (e.g., systemadmin/Dashboard.php, applicant/Applicant.php)
            
            // Special handling for applicant routes - all go to main Applicant controller
            if ($URL[0] === 'applicant') {
                list($fileName, $controllerName) = $this->resolveControllerFile("../app/controllers/applicant", 'Applicant');
                if ($fileName) {
                    require $fileName;
                    $this->controller = $controllerName;
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
                    list($fileName, $matchedControllerName) = $this->resolveControllerFile("../app/controllers/" . $URL[0], $controllerName);
                    if ($fileName) {
                        require $fileName;
                        $this->controller = $matchedControllerName;
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
                    list($fileName, $matchedFolderControllerName) = $this->resolveControllerFile("../app/controllers/" . $URL[0], $folderControllerName);
                    if ($fileName) {
                        require $fileName;
                        $this->controller = $matchedFolderControllerName;
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
    
    /**
     * Global authentication check for protected areas
     */
    private function checkGlobalAuth($URL)
    {
        // Define public pages that don't require authentication
        $publicPages = [
            'home', 'signin', 'signup', 'signout', '_404','passwordreset',
            'password-reset', 'admin-setup'
        ];
        
        // Check if accessing a public page
        if (empty($URL[0]) || in_array(strtolower($URL[0]), $publicPages)) {
            return; // Allow access to public pages
        }
        
        // Check for special public files (robots.txt, favicon.ico, etc.)
        if (isset($URL[0]) && preg_match('/\.(txt|ico|png|jpg|jpeg|gif|css|js)$/i', $URL[0])) {
            return; // Allow access to static files
        }
        
        // All other pages require authentication
        if (!Auth::logged_in()) {
            // Store the requested URL for redirect after login
            $_SESSION['redirect_after_login'] = $_SERVER['REQUEST_URI'] ?? '';
            redirect('signin?required=1');
            exit();
        }
        
        // Additional role-based checks can be added here
        // For now, basic login is sufficient as controllers handle specific role checks
    }
}





