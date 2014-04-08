<?php

require_once "system/view.php";

/* 
 * 
 */
$baseurl = dirname($_SERVER['PHP_SELF']);
$url = str_replace($baseurl . '/', '', $_SERVER['REQUEST_URI']);
if (strpos($url, "?") != false) {
	$url = explode("?", $url);
	$url = $url[0];
}

/* 
 * 
 */
$params = explode("/", $url);
$params_count = count($params);

/* 
 * extension
 */
$ext = explode('.', $params[$params_count - 1]);
if (count($ext) == 2 && $ext[1] == 'json') {
	$params[$params_count - 1] = $ext[0];
	$ext = $ext[1];
} else {
	$ext = 'html';
}

/* 
 * default url
 */
if ($params[0] == "" || !ctype_alnum($params[0])) {
	$params[0] = "news";
}

if (file_exists("./sritis/" . $params[0] . "/" . $params[0] . "_control.php")) {
	require_once("./sritis/" . $params[0] . "/" . $params[0] . "_control.php");
} else {
	require_once("./sritis/error/error_control.php");
	$params[0] = "error";
}
$name = $params[0] . "_control";
$sritis = new $name();
if (method_exists($sritis, 'setParams')) {
	$sritis->setParams(array_slice(array_map('rawurldecode', $params), 2));
}

// view pakurimas
$sritis->view = new system_view();
$sritis->view->dir = $params[0];
$sritis->view->setExt($ext);

if (!empty($params[1]) && preg_match('/^[a-zA-Z0-9_]+$/', $params[1]) && is_callable(array($sritis, $params[1]))) {
	$sritis->$params[1]();
} else {
	$sritis->rodyk();
}
