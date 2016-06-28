<?php

/**
 *
 */
class Routes
{

    private $jsonRoutes = null;
    private $jsonRoute = null;
    private $url;
    private $urlExist = false;
    private $urlAuth = false;
    private $urlArgs = [];

    function __construct()
    {
        $this->jsonRoutes = json_decode(file_get_contents("init/routes.json"), true);
        $this->url = $this->getPathInfos();
        $this->urlExist = $this->urlExist();
        $this->urlAuth = $this->urlAuth();
        //$this->urlArgs = $this->getArguments();
    }

    private function urlCheckPattern($url, $urlFormat) {
        $urlFormatSplit = explode("/", $urlFormat);
        $urlPatternSplit = $urlFormatSplit;
        $urlSplit = explode("/", $url);
        $paramsValue = [];
        preg_match_all("#:[a-z]*#", $urlFormat, $params);

        foreach ($urlPatternSplit as $key => $value) {
            if (preg_match("#^:#", $value)) {
                $urlPatternSplit[$key] = preg_replace("#^:[a-z]*#", "", $value);
                if (!$urlPatternSplit[$key])
                    $urlPatternSplit[$key] = "([a-z0-9]+)";
            }
        }

        $params = substr_replace($params[0], "", 0, 1);
        $urlPattern = "#^" . implode("/", $urlPatternSplit) . "$#";

        if (preg_match($urlPattern, $url)) {
            $i = 0;
            foreach ($urlFormatSplit as $key => $value) {
                if (preg_match("#^:#", $value)) {
                    $this->urlArgs[$params[$i]] = $urlSplit[$key];
                    $i++;
                }
            }
            return true;
        }
        return false;
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
        foreach ($this->jsonRoutes as $route) {
            if ($this->urlCheckPattern($this->url, $route["name"])) {
                $this->jsonRoute = $route;
                return true;
            }
        }
        return false;
    }

    public function getArguments() {
        return $this->urlArgs;
    }

    private function urlAuth() {
        if ($this->urlExist) {
            if (!$this->jsonRoute["auth"])
                return true;
            else if (isset($_SESSION["user"])) {
                return true;
            }else{
                return false;
            }
        } else {
            return false;
        }
    }

    public function getRoute($element = null) {
        if ($element){
            if (isset($this->jsonRoute[$element])){
                return $this->jsonRoute[$element];
            }elseif(!isset($this->jsonRoute[$element]) && $element == "layout"){
                return true;
            }else{
                return false;
            }
        }else
            return $this->jsonRoute;
    }

    public function getUrlExist() {
        return $this->urlExist;
    }

    public function routeAccess() {
        if ($this->urlExist && $this->urlAuth)
            return true;
        return false;
    }
}



?>
