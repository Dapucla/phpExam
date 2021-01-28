<?php
/**
 * LIBS
 */
class libs
{
	function add_lib($lib_name, $route){
		if ($route->debug == true){
			print("Added lib: ".'libs/'.$lib_name.".php<br>");
		}
		require 'libs/'.$lib_name.".php";
	}
}
?>