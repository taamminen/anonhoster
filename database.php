<?php

$host = "127.0.0.1";
$db = "anonhost";
$user = "root";
$pswd = "";

$sql = "mysql:host=$host;dbname=$db;charset=utf8";

try {
  $conn = new PDO($sql, $user, $pswd, [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false]);
} catch (PDOException $e) {
  die("Connection failed: " . $e->getMessage());
}

$message = "";

class Funcs {

    public static function runSession() {
        if (!isset($_SESSION)) session_start();
    }

    public static function checkLoginState($conn) {
        Funcs::runSession();
        if (isset($_COOKIE['user_id']) && isset($_COOKIE['username']) && isset($_COOKIE['token']) && isset($_COOKIE['serial'])) {
            $query = "SELECT * FROM sessions WHERE user_id = ? AND token = ? AND `serial` = ?";

            $user_id = $_COOKIE['user_id'];
            $username = $_COOKIE['username'];
            $token = $_COOKIE['token'];
            $serial = $_COOKIE['serial'];

            $stmt = $conn->prepare($query);
            $stmt->execute(array($user_id, $token, $serial));

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($row['user_id'] > 0) {
                if ($row['user_id'] == $_COOKIE['user_id'] &&
                    $row['token'] == $_COOKIE['token'] &&
                    $row['serial'] == $_COOKIE['serial'] ) {
                    if ($row['user_id'] == $_SESSION['user_id'] &&
                        $row['token'] == $_SESSION['token'] &&
                        $row['serial'] == $_SESSION['serial']) {
                        return true;
                    } else {
                        Funcs::createSession($_COOKIE['user_id'], $_COOKIE['username'], $_COOKIE['token'], $_COOKIE['serial']);
                        return true;
                    }
                }
            }
        } else return false;
    }

    public static function createAccount($conn, $user_id, $username) {
        $delstmt = $conn->prepare("DELETE FROM sessions WHERE user_id = ?");
        $delstmt->execute(array($user_id));

        $query = "INSERT INTO sessions (user_id, token, `serial`, `date`) VALUES (?, ?, ?, ?)";

        $token = Funcs::generateToken(32);
        $serial = Funcs::generateToken(32);

        Funcs::createCookie($username, $user_id, $token, $serial);
        Funcs::createSession($username, $user_id, $token, $serial);

        $stmt = $conn->prepare($query);
        $stmt->execute(array($user_id, $token, $serial, date('Y-m-d H:i:s')));
    }

    public static function createCookie($username, $user_id, $token, $serial) {
        setcookie('username', $username, time() + (86400) * 30, '/');
        setcookie('user_id', $user_id, time() + (86400) * 30, '/');
        setcookie('token', $token, time() + (86400) * 30, '/');
        setcookie('serial', $serial, time() + (86400) * 30, '/');
    }

    public static function deleteCookie() {
        Funcs::runSession();
        setcookie('username', '', time() - 1, '/');
        setcookie('user_id', '', time() - 1, '/');
        setcookie('token', '', time() - 1, '/');
        setcookie('serial', '', time() - 1, '/');
        session_destroy();
    }

    public static function createSession($username, $user_id, $token, $serial) {
        Funcs::runSession();
        $_SESSION['username'] = $username;
        $_SESSION['user_id'] = $user_id;
        $_SESSION['token'] = $token;
        $_SESSION['serial'] = $serial;

    }

    function generateToken($length=9) {
      $string = ""; $chars = "qwertyuiopasdfghjklzxcvbnm";
    	for ($i = 0; $i < $length; $i++)
    		$string .= $chars[random_int(0, strlen($chars)-1)];
    	return $string;
    }

    function checkFilename($conn, $filename) {
    	$sql = "SELECT id FROM `files` WHERE filename = ?";
    	$stmt = $conn->prepare($sql);
    	$stmt->execute(array($filename));
    	$row = $stmt->fetchAll(PDO::FETCH_OBJ);
    	if (count($row) > 0) return false;
    	else return true;
    }
}


?>
