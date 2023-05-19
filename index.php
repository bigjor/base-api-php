<?php
  error_reporting(E_ERROR | E_PARSE);

  function sendNotFound() {
    header("HTTP/1.1 404 Not Found");
    exit();
  }

  try {


    $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $uri = explode( '/', $uri );

    $controllerName = ucfirst($uri[3]);
    $controllerClass = $controllerName . "Controller";

    $controllerLocation = __DIR__ . "/Controller/Api/". $controllerClass . ".php";

    if (!file_exists($controllerLocation))
      throw new Exception("$controllerName does not exist");
    else
      require_once($controllerLocation);

    $controller = new $controllerClass();

    $methodName = $uri[4] . "Action";

    $controller->{$methodName}();
  } catch (Exception $e) {
    sendNotFound();
  }

  

  // $objFeedController = new UserController();
  // $strMethodName = $uri[3] . 'Action';
  // $objFeedController->{$strMethodName}();
?>