<?php

function breadcrumbs($main_page, $back_page, $this_page){
	if ($back_page == ""){
		return '<li class="breadcrumb-item"><a href="/">'.$main_page.'</a></li>'.'<li class="breadcrumb-item active"><a href="/">'.$this_page.'</a></li>';
	}else {
		return '<li class="breadcrumb-item"><a href="/">'.$main_page.'</a></li>'.'<li class="breadcrumb-item"><a href="/">'.$back_page.'</a></li>'.'<li class="breadcrumb-item active"><a href="/">'.$this_page.'</a></li>';
	}
}
?>