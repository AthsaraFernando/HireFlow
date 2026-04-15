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

    private function convertUrlToClassName($url)
    {
        return str_replace(' ', '', ucwords(str_replace('-', ' ', $url)));
    }

    private function normalizeControllerToken($value)
    {
        return strtolower(preg_replace('/[^a-z0-9]/i', '', (string)$value));
    }

    /**
     * Robust root-level controller resolver (case-insensitive fallback)
     */
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

    /**
     * Flexible folder controller resolver
     */
    private function resolveFolderController($folder, $segment)
    {
        $controllerDir = "../app/controllers/" . $folder;

        if (!is_dir($controllerDir)) {
            return null;
        }

        $controllerName = $this->convertUrlToClassName($segment);
        $directPath = $controllerDir . "/" . $controllerName . ".php";

        if (file_exists($directPath)) {
            return [
                'controller' => $controllerName,
                'file' => $directPath,
            ];
        }

        $targetToken = $this->normalizeControllerToken($segment);

        foreach (glob($controllerDir . "/*.php") as $candidatePath) {
            $candidateController = pathinfo($candidatePath, PATHINFO_FILENAME);

            if ($this->normalizeControllerToken($candidateController) === $targetToken) {
                return [
                    'controller' => $candidateController,
                    'file' => $candidatePath,
                ];
            }
        }

        return null;
    }

    public function loadController()
    {
        $URL = $this->splitURL();

        // Global authentication check
        $this->checkGlobalAuth($URL);

        /**
         * STEP 1: Root-level controllers (robust)
         */
        list($fileName, $controllerName) = $this->resolveControllerFile(
            "../app/controllers",
            ucfirst($URL[0])
        );

        if ($fileName) {
            require $fileName;
            $this->controller = $controllerName;
            unset($URL[0]);
        } else {

            /**
             * STEP 2: Folder-based controllers (including applicant)
             */
            if (isset($URL[1])) {

                $resolvedController = $this->resolveFolderController($URL[0], $URL[1]);

                if ($resolvedController) {
                    require $resolvedController['file'];
                    $this->controller = $resolvedController['controller'];

                    unset($URL[0]);
                    unset($URL[1]);
                } else {
                    require "../app/controllers/_404.php";
                    $this->controller = '_404';
                }

            } else {

                /**
                 * STEP 3: Default controller inside folder
                 */
                list($fileName, $controllerName) = $this->resolveControllerFile(
                    "../app/controllers/" . $URL[0],
                    ucfirst($URL[0])
                );

                if ($fileName) {
                    require $fileName;
                    $this->controller = $controllerName;
                    unset($URL[0]);
                } else {
                    require "../app/controllers/_404.php";
                    $this->controller = '_404';
                }
            }
        }

        $controller = new $this->controller;

        /**
         * METHOD RESOLUTION
         */
        $remainingURL = array_values($URL);

        if (!empty($remainingURL[0])) {
            if (method_exists($controller, $remainingURL[0])) {
                $this->method = $remainingURL[0];
                unset($remainingURL[0]);
            }
        }

        call_user_func_array([$controller, $this->method], array_values($remainingURL));
    }

    /**
     * Global authentication check
     */
    private function checkGlobalAuth($URL)
    {
        $publicPages = [
            'home', 'signin', 'signup', 'signout', '_404',
            'passwordreset', 'password-reset', 'admin-setup'
        ];

        if (empty($URL[0]) || in_array(strtolower($URL[0]), $publicPages)) {
            return;
        }

        if (isset($URL[0]) && preg_match('/\.(txt|ico|png|jpg|jpeg|gif|css|js)$/i', $URL[0])) {
            return;
        }

        if (!Auth::logged_in()) {
            $_SESSION['redirect_after_login'] = $_SERVER['REQUEST_URI'] ?? '';
            redirect('signin?required=1');
            exit();
        }
    }
}