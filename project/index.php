<?php

// load needed variables/defines/configs

require_once 'config/database.php';
require_once 'helper/functions.php';

// load core stuff

require_once 'core/controller.class.php';



// TODO: load all created models


// start session to handle login
session_start();

// check which controller should be loaded
$controllerName = 'pages'; // default controller if noting is set
$actionName = 'startseite'; // default action if nothing is set

// check a controller is given
if (isset($_GET['c'])) {
    $controllerName = $_GET['c'];
}

// check an action is given
if (isset($_GET['a'])) {
    $actionName = $_GET['a'];
}

// check controller/class and method exists
if (file_exists('controller/' . $controllerName . '_controller.php')) {
    // include the controller file
    include_once 'controller/' . $controllerName . '_controller.php';

    // generate the class name of the controller using the name extended by Controller
    // also add the namespace in front
    $className = ucfirst($controllerName) . 'Controller';

    // generate an instace of the controller using the name, stored in $className
    // it is the same like calling for example: new \dwp\controller\PagesController()
    $controller = new $className($controllerName, $actionName);

    // checking the method is available in the controller class
    // the method looks like: actionIndex()
    $actionMethod = 'action' . ucfirst($actionName);
    if (!method_exists($controller, $actionMethod)) {
        // TODO: Handle better errors with an Redirect to an error page
        header('Location: index.php?c=pages&a=error404');
    } else {
        // call the action method to do the job
        // so the action cann fill the params for the view which will be used 
        // in the render process later

        $controller->{$actionMethod}();
    }
} else {
    // TODO: Handle better errors with an Redirect to an error page
    header('Location: index.php?c=pages&a=error404');
}



?>


<!DOCTYPE html>
<html>

<head>
    <link rel="icon" type="image/png" href="assets/pictures/favicon-32x32.png" sizes="32x32" />
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


</head>

<body>
    <?php
    include 'views/' . 'layout.php';

    // this method will render the view of the called action
    // for this the the file in the views directory will be included
    //$controller->render();
    ?>
</body>

</html>