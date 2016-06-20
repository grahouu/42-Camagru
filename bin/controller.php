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

    public function render($view, $variables = array()) {
        ob_start();
        extract($variables);
        include("views/" . $view);
        $this->content = ob_get_clean();

        $route = $this->application->getRoute();

        if ($route->getRoute("layout"))
            include("views/layout.php");
        else
            echo $this->content;
    }

    public function getService($name) {
        return $this->application->getService($name);
    }
}
 ?>
