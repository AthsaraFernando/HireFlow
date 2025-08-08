<?php

class Controller
{
    public function view($name, $data = [])
    {
        if (!empty($data)) {
            extract($data);
        }

        if (!isset($data['view'])) {
            $data['view'] = $name;
        }

        $fileName = "../app/views/" . $name . ".view.php";
        if (file_exists($fileName)) {
            require $fileName;
        } else {
            $fileName = "../app/views/" . $name . "/" . $data['view'] . ".view.php";
            if (file_exists($fileName)) {
                require $fileName;
            } else {

                $fileName = "../app/views/" . $name . "/" . $name . ".view.php";
                if (file_exists($fileName)) {
                    require $fileName;
                } else {
                    $fileName = "../app/views/404.view.php";
                    require $fileName;
                }
            }
        }
    }
}

