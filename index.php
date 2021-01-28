<?php

error_reporting(E_ALL);
ini_set('display_errors', true);

require_once 'config.php';
require_once 'includes/db.php';
require_once 'includes/functions.php';

session_start();

define('IS_LOGGED', ! empty($_SESSION['is_logged']));

define('IS_POST', $_SERVER['REQUEST_METHOD'] == 'POST');

$titles = [ 'Опросы' ];

$db = new DB;

$page = preg_replace('/[^a-z0-9_]/', '', get_var('page', 'index'));

$action_file   = "actions/$page.php";
$template_file = __DIR__ . "/templates/$page.phtml";

if ( ! file_exists($action_file) && ! file_exists($template_file))
{
	error(404);
}

if (file_exists($action_file)) require_once $action_file;

if (file_exists($template_file)) include_once 'templates/layout.phtml';

	