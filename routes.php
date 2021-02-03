<?php

$w->route("^/$", function($url) {include "engine/index.php";});
$w->route("^/register$", function($url) {include "engine/register.php";});
$w->route("^/login$", function($url) {include "engine/login.php";});
$w->route("^/upload$", function($url) {include "engine/upload.php";});
$w->route("^/file/(\w.+)$", function($url, $f) {include "engine/file.php";});
$w->route("^/delete/(\w.+)$", function($url, $f) {include "engine/delete.php";});
$w->route("^/logout$", function($url) {include "engine/logout.php";});

?>
