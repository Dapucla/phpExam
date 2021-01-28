<?php

function error($code)
{
	$errors = [
		400 => 'Bad Request',
		403 => 'Forbidden',
		404 => 'Not Found',
		500 => 'Internal Server Error',
	];
	
	header("Status: $code {$errors[$code]}");
	echo "<h1>$code - {$errors[$code]}</h1>";
	exit;
}

function redirect($page, $params = null)
{
	$param = ( ! empty($params)) ? '&' . http_build_query($params) : '';
	header("Location: ./?page=$page$param");
	exit;
}

function get_var($name, $default = '')
{
	return isset($_REQUEST[$name]) ? $_REQUEST[$name] : $default;
}

function check_fields($fields)
{
	foreach ($fields as $field)
	{
		if ( ! isset($_REQUEST[$field]))
		{
			error(400);
		}
	}
}