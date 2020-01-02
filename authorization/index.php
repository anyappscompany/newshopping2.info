<?php
	/**
	* Главный файл (переключатель)
	* Site: http://bezramok-tlt.ru
	* Регистрация пользователя письмом
	*/

	//Запускаем сессию
	session_start();

	//Устанавливаем кодировку и вывод всех ошибок
	header('Content-Type: text/html; charset=UTF8');
	error_reporting(E_ALL);

	//Включаем буферизацию содержимого
	ob_start();

	//Определяем переменную для переключателя
	$mode = isset($_GET['mode'])  ? $_GET['mode'] : false;
	$user = isset($_SESSION['user']) ? $_SESSION['user'] : false;
	$err = array();

	//Устанавливаем ключ защиты
	define('BEZ_KEY', true);
	 
	//Подключаем конфигурационный файл
	include_once('../authorization/config.php');

	//Подключаем скрипт с функциями
	include_once('../authorization/func/funct.php');

	//подключаем MySQL
	include_once('../authorization/bd/bd.php');

	switch($mode)
	{
		//Подключаем обработчик с формой регистрации
		case 'reg':
			include_once('../authorization/scripts/reg/reg.php');
			include_once('../authorization/scripts/reg/reg_form.html');
		break;
		
		//Подключаем обработчик с формой авторизации
		case 'auth':
			include_once('../authorization/scripts/auth/auth.php');
			include_once('../authorization/scripts/auth/auth_form.html');
			include_once('../authorization/scripts/auth/show.php');
		break;
    
	}
    
	//Получаем данные с буфера
	$content = ob_get_contents();
	ob_end_clean();

	//Подключаем наш шаблон
	include_once('../authorization/html/index.html');
?>			