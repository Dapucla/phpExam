<?php
/**
 * Route
 */
class route
{
	public $debug;
	public $uri;
	function __construct($debug_status)
	{
		$this->debug = $debug_status;
		$this->uri = $_SERVER['REQUEST_URI'];
	}

	function parse_uri(){
		if ($this->uri{-1} != '/') {
			$this->uri = $this->uri.'/';
			//echo '<h1>'.$page_uri.'</h1>';
		}
		return $this->uri;
	}
}
?>