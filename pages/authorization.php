<?php

if(!preg_match("/^\/newshopping.info\/authorization.php\?mode=(reg$|auth$|reg&status=ok$|reg&key=[a-z0-9]+$|reg&active=ok$|auth&exit=true$)/i", $_SERVER['REQUEST_URI'])){
        //header('Location:'. 'http://'.$_SERVER['SERVER_NAME'].'/' .'404.php');
		//exit;
}

$content = "";
	//Определяем переменную для переключателя
	$mode = isset($_GET['mode'])  ? $_GET['mode'] : false;
	$user = isset($_SESSION['user']) ? $_SESSION['user'] : false;
	$err = array();

	//Устанавливаем ключ защиты
	define('BEZ_KEY', true);

	//Подключаем конфигурационный файл
	include_once('/authorization/config.php');

	//Подключаем скрипт с функциями
	include_once('/authorization/func/funct.php');
                                           //echo __FILE__;

	//подключаем MySQL
	include_once('/authorization/bd/bd.php');

	switch($mode)
	{
		//Подключаем обработчик с формой регистрации
		case 'reg':
			include_once('/authorization/scripts/reg/reg.php');
            $reg_form = file_get_contents("./authorization/scripts/reg/reg_form.html");
			//include_once('/authorization/scripts/reg/reg_form.html');
                                           // успешная регистрация
            if(isset($_GET['status']) && mb_strtolower ($_GET['status']) == "ok"){
            $page_template = str_replace("[CONTENT]", $auth_message, $page_template);
            $page_template = str_replace("[TITLE]", $successful_registration_title, $page_template);
            $page_template = str_replace("[H-TITLE]", $successful_registration_h_title, $page_template);
            break;
            }

             if(isset($_GET['active']) and $_GET['active'] == 'ok'){
             $page_template = str_replace("[CONTENT]", $auth_message, $page_template);
            $page_template = str_replace("[TITLE]", $successful_activation_title, $page_template);
            $page_template = str_replace("[H-TITLE]", $successful_activation_h_title, $page_template);
             break;
             }

            //[REG-FORM-MAIL] [REG-FORM-PASS] [REG-FORM-REP-PASS]
            $reg_form = str_replace("[REG-FORM-MAIL]", $reg_form_mail, $reg_form);
             $reg_form = str_replace("[REG-FORM-PASS]", $reg_form_pass, $reg_form);
              $reg_form = str_replace("[REG-FORM-REP-PASS]", $reg_form_rep_pass, $reg_form);
              $reg_form = str_replace("[REG-SUBMIT]", $reg_submit_button_text, $reg_form);
              $reg_form = str_replace("[SERVER-NAME]", $_SERVER['SERVER_NAME'], $reg_form);
              $reg_form = str_replace("[REG-FORM-RECOMMENDATION]", $reg_form_recommendation, $reg_form);


            $page_template = str_replace("[CONTENT]", $reg_form, $page_template);

            $page_template = str_replace("[TITLE]", $new_member_registration_title, $page_template);
            $page_template = str_replace("[H-TITLE]", $new_member_registration_title_h, $page_template);

		break;

		//Подключаем обработчик с формой авторизации
		case 'auth':
			include_once('/authorization/scripts/auth/auth.php');
			//include_once('/authorization/scripts/auth/auth_form.html');
			include_once('/authorization/scripts/auth/show.php');
            $auth_form = file_get_contents("./authorization/scripts/auth/auth_form.html");

            if($user === true){
                //$auth_form = str_replace("[AUTH-INFO]", $auth_errors.$auth_info, $auth_form);

                $page_template = str_replace("[CONTENT]", $auth_errors.$auth_info, $page_template);

            $page_template = str_replace("[TITLE]", $login_member_title, $page_template);
            $page_template = str_replace("[H-TITLE]", $login_member_title_h, $page_template);
            //break;
            }else{
                $auth_form = str_replace("[AUTH-FORM-MAIL]", $auth_form_mail, $auth_form);
             $auth_form = str_replace("[AUTH-FORM-MAIL-PLACEHOLDER]", $auth_form_mail_placeholder, $auth_form);
              $auth_form = str_replace("[LOGIN-MEMBER-RECOMMENDATION]", $login_member_recommendation, $auth_form);
              $auth_form = str_replace("[LOGIN-MEMBER-RECOMMENDATION2]", $login_member_recommendation2, $auth_form);
              $auth_form = str_replace("[AUTH-FORM-PASS]", $auth_form_pass, $auth_form);
              $auth_form = str_replace("[LOGIN-SUBMIT]", $login_submit_button_text, $auth_form);
              //$auth_form = str_replace("[SERVER-NAME]", $_SERVER['SERVER_NAME'], $auth_form);
              $auth_form = str_replace("[AUTH-INFO]", $auth_errors.$auth_info, $auth_form);


            $page_template = str_replace("[CONTENT]", $auth_form, $page_template);

            $page_template = str_replace("[TITLE]", $login_member_title, $page_template);
            $page_template = str_replace("[H-TITLE]", $login_member_title_h, $page_template);

            }
            //echo $user;
                                                                                        //$auth_info.

		break;

        default:
        header('Location:'. 'http://'.$_SERVER['SERVER_NAME'].'/' .'404.php');
		exit;
        break;

	}


$page_template = str_replace("[META]", '<meta name="robots" content="noindex,nofollow" />', $page_template);

$page_template = str_replace("[SERVER-NAME]", $_SERVER['SERVER_NAME'], $page_template);
$page_template = str_replace("[PAGINATION]", "", $page_template);
$page_template = str_replace("[CONTENT]", $content, $page_template);
$page_template = str_replace("[BOTTOM-ROW]", "", $page_template);

	//Подключаем наш шаблон
	//include_once('/authorization/html/index.html');
?>