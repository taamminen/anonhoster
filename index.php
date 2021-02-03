<?php

class Website
{
  public $routes = [];

  public function route($pattern, $callback)
  {
    $this->routes["{".$pattern."}"] = $callback;
    $this->routes["{".str_replace("$", "/$", $pattern)."}"] = $callback;
  }

  public function execute() {
    $this->route("^/(\w+)$", function($url) {header("Location: /");});
    foreach ($this->routes as $pattern => $callback)
      if (preg_match($pattern, $_SERVER["REQUEST_URI"], $params) === 1)
        return call_user_func_array($callback, array_values($params));
  }
}

$w = new Website();
require "routes.php";
$w->execute();

?>
