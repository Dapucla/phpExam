<?php
$text_result = "";
switch ($route->err_code) {
	case 404:
		$text_result = "Ошибка: Страница не найдена, 404";
		break;
	case 403:
		$text_result = "Ошибка: Доступ запрещён! 401";
		break;
	default:
		$text_result = "Неизвестная ошибка.";
		break;
}

controller::init_view($route, "error", false, null);
?>