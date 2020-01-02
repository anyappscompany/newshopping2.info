<?php
 /**
 * Скрипт распределения ресурсов
 * Site: http://bezramok-tlt.ru
 * Проверяем права на чтение данных,
 * только для зарегистрированных пользователей
 */
$auth_info = "";
 //Проверяем зашел ли пользователь
 if($user === false){
 	//$auth_info .= '<div class="alert alert-warning" role="alert">'.$auth_access_closed.'</div>'."\n";
 }
 if($user === true) {
	//$auth_info .= '<div class="alert alert-success" role="alert">'.$auth_congratulations_logged.'</div>'."\n";
	//$auth_info .= '<a href="'.BEZ_HOST.'authorization.php?mode=auth&exit=true">ВЫЙТИ</a>';
    $auth_info .= '<div class="alert alert-success" role="alert">'.$auth_congratulations_logged.'</div>';

    //print_r($_SESSION);
 }
 ?>
	