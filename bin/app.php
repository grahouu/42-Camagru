<?php


class App {

    private $objRoute;
    private $controller;
    private $action;
    private $confService = [];
    private $services = [];


    function __construct()
    {
        session_start();
        $files = array();
        $files = array_merge($files, glob('bin/[!app]*.php'));
        $files = array_merge($files, glob("controller/*.php"));
        foreach ($files as $file) {
            include $file;
        }
    }

    function getRoute(){
        return $this->objRoute;
    }

    function getController(){
        return $this->controller;
    }

    function getConfigService($name){
        if (isset($this->confService[$name]))
            return $this->confService[$name];
        else
            return null;
    }

    function setConfService($serviceName, $arrayConf){
        $this->confService[$serviceName] = $arrayConf;
    }

    function getService($name) {
        if (array_key_exists($name, $this->services))
            return $this->services[$name];
        $ClassService = $name . 'Service';
        if (!is_subclass_of($ClassService, 'Service')) {
            return null;
        }
        $config = $this->getConfigService($name);
        if (!$config)
            $config = [];
        return $this->services[$name] = new $ClassService($config);
    }

    private function runService() {
        $config = file_get_contents("init/Service.json");
        $config = json_decode($config, true);

        foreach ($config as $key => $value) {
            $this->setConfService($key, $value);
        }
        return true;
    }

    private function runRoute() {
        $this->objRoute = new Routes();
        if ($this->objRoute->routeAccess()){
            $controller = $this->objRoute->getRoute('controller') . "Controller";
            $this->controller = new $controller($this);
            $this->action = $this->objRoute->getRoute("action");
            return true;
        }
        return false;
    }

    function run() {
        //var_dump($_SERVER);
        //exit();
        if ($this->runService() && $this->runRoute())
            call_user_func(array($this->controller, $this->action));
        else
            header('Location: /camagru/signin');
    }

}




?>
