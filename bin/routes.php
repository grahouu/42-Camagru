<?php

/**
 *
 */
class Routes
{

    function __construct()
    {
        $this->routes = json_decode(file_get_contents("init/routes.json"), true);
        $this->route = null;
        $this->url = $this->getPathInfos();
        $this->urlExist = $this->urlExist();
        $this->urlAuth = $this->urlAuth();
        $this->args = $this->getArguments();
    }

    private function getPathInfos() {
        if (!array_key_exists('PATH_INFO', $_SERVER)) {
            if (!$_SERVER['QUERY_STRING'])
            return "";
            $pos = strpos($_SERVER['REQUEST_URI'], $_SERVER['QUERY_STRING']);

            $asd = substr($_SERVER['REQUEST_URI'], 0, $pos - 2);
            $asd = substr($asd, strlen($_SERVER['SCRIPT_NAME']) + 1);

            return $asd;
        } else {
            return trim($_SERVER['PATH_INFO'], '/');
        }
    }

    private function urlExist() {
        foreach ($this->routes as $route) {
            if ($route["name"] == $this->url) {
                $this->$route = $route;
                return true;
                // require "controller/" . $route["controller"] . "Controller.php";
                // $functionName = $route["action"];
                // $functionName();
                // $enterRoute = true;
            }
        }
        return false;
    }

    private function getArguments() {
        if ($this->urlExist) {
            return array();
        }else{
            return array();
        }
    }

    private function urlAuth() {
        if ($this->urlExist) {
            return true;
        } else {
            return false;
        }
    }
}



?>
