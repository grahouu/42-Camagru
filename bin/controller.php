<?php /**
 *
 */
class Controller
{

    function __construct()
    {
    }

    public function render() {
        global $content;
        $content = file_get_contents("views/" . $view);
        include("views/layout.php");
    }
}
 ?>
