<?php

class Controller
{

    private $application;

    function __construct(App $app)
    {
        $this->application = $app;
        $this->title = "";
        $this->content = "";
    }

    public function render($view) {
        $this->content = file_get_contents("views/" . $view);
        include("views/layout.php");
        exit();
    }

    public function getService($name) {
        return $this->application->getService($name);
    }
}
 ?>
