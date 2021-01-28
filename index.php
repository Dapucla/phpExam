<?php
include 'engine/route.php';
include 'engine/source.php';

$route = new route(false);

#libs::add_lib("rb", $route);
libs::add_lib("bootstrap", $route);
libs::add_lib("web_components", $route);

switch ($route->parse_uri()) {
	case '/':
		controller::init_model("main", $route, "guest");
		break;
	default:
		$route->err_code = 404;
		controller::init_model("errors", $route, "public");
		break;
}
?>