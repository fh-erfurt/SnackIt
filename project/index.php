<?php

// load needed variables/defines/configs
require_once 'config/init.php';
require_once 'config/database.php';

// load core stuff
require_once COREPATH.'functions.php';
require_once COREPATH.'controller.class.php';
require_once COREPATH.'model.class.php';


// TODO: load all created models


// start session to handle login
session_start();

// check which controller should be loaded
$controllerName = 'pages'; // default controller if noting is set
$actionName = 'startseite'; // default action if nothing is set

// check a controller is given
if(isset($_GET['c']))
{
    $controllerName = $_GET['c'];
	echo $controllerName;
}

// check an action is given
if(isset($_GET['a']))
{
    $actionName = $_GET['a'];
	echo $actionName;
}

// check controller/class and method exists
if(file_exists(CONTROLLERSPATH.$controllerName.'_controller.php'))
{
    // include the controller file
    require_once CONTROLLERSPATH.$controllerName.'_controller.php';

    // generate the class name of the controller using the name extended by Controller
    // also add the namespace in front
    $className = 'dwp\\controller\\'.ucfirst($controllerName).'Controller';

    // generate an instace of the controller using the name, stored in $className
    // it is the same like calling for example: new \dwp\controller\PagesController()
    $controller = new $className($controllerName, $actionName);

    // checking the method is available in the controller class
    // the method looks like: actionIndex()
    $actionMethod = 'action'.ucfirst($actionName);
    if(!method_exists($controller, $actionMethod))
    {
        // TODO: Handle better errors with an Redirect to an error page
        die('404 Method you call does not exists');
    }
    else
    {
        // call the action method to do the job
        // so the action cann fill the params for the view which will be used 
        // in the render process later
        $controller->{$actionMethod}();
    }
}
else
{
    // TODO: Handle better errors with an Redirect to an error page
    die('404 Controller you call does not exist');
}


?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/styles/style.css">
    <title>Notenspiegel</title>
</head>
<body>
    <?php
		require_once VIEWSPATH.'layout.php';

        // this method will render the view of the called action
        // for this the the file in the views directory will be included
        //$controller->render();
    ?>
</body>
</html>
