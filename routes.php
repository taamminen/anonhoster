<?php

$w->route("^/register$", function($url) {include "engine/register.php";});
$w->route("^/login$", function($url) {include "engine/login.php";});
$w->route("^/file/(\w+)$", function($url) {include "engine/file.php";});
$w->route("^/editfile/(\w+)$", function($url, $username) {include "engine/filedit.php";});
$w->route("^/user/(\w+)$", function($url, $username) {include "engine/user.php";});
$w->route("^/editme/(\w+)$", function($url, $username) {include "engine/useredit.php";});
$w->route("^/upload$", function($url) {include "engine/upload.php";});
$w->route("^/logot", function($url) {include "engine/logout.php";});

?>
