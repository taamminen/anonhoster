<?php

require 'database.php';

class Website
{    
    private $routes = [];
    
    public function route($pattern, $callback)
    {
        $this->routes["{".$pattern."}"] = $callback;
    }
    
    public function execute()
    {
        foreach ($this->routes as $pattern => $callback)
        {
            if (preg_match($pattern, $_SERVER['REQUEST_URI'], $params) === 1)
            {
                array_shift($params);
                return call_user_func_array($callback, array_values($params));
            }
        }
    }
}


$anonhost = new Website();

$anonhost->route('^/register$', function() {include 'register.php';});

$anonhost->route('^/api/check.username/(\w+)$', function ($username) {
    header('Content-type: application/json');
    $sql = "SELECT COUNT(*) AS num FROM `users` WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute(array($username));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($row["num"] > 0)
        echo json_encode(["error" => "Username already taken."]);
    else echo json_encode(["error" => false]);
});

$anonhost->execute();

?>
