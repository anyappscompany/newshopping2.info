<?php
 /**
 * Обработчик формы регистрации
 * Site: http://bezramok-tlt.ru
 * Регистрация пользователя письмом
 */
 
 //Выводим сообщение об удачной регистрации
 if(isset($_GET['status']) and $_GET['status'] == 'ok')
	$auth_message .= '<div class="alert alert-success" role="alert">'.$successful_registration_message.'</div>';

 //Выводим сообщение об удачной регистрации
 if(isset($_GET['active']) and $_GET['active'] == 'ok') 
	$auth_message .= '<div class="alert alert-success" role="alert">'.$thanks_your_acc_activated.'</div>';
	
 //Производим активацию аккаунта
 if(isset($_GET['key']))
 {
	//Проверяем ключ
	$sql = 'SELECT * 
			FROM `reg`
			WHERE `active_hex` = :key';
	//Подготавливаем PDO выражение для SQL запроса
	$stmt = $db->prepare($sql);
	$stmt->bindValue(':key', $_GET['key'], PDO::PARAM_STR);
	$stmt->execute();
	$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

	if(count($rows) == 0)
		$err[] = $activation_key_failed;
	
	//Проверяем наличие ошибок и выводим пользователю
	if(count($err) > 0)
		echo showErrorMessage($err);
	else
	{
		//Получаем адрес пользователя
		$email = $rows[0]['login'];
	
		//Активируем аккаунт пользователя
		$sql = 'UPDATE `reg`
				SET `status` = 1
				WHERE `login` = :email';
		//Подготавливаем PDO выражение для SQL запроса
		$stmt = $db->prepare($sql);
		$stmt->bindValue(':email', $email, PDO::PARAM_STR);
		$stmt->execute();
		
		//Отправляем письмо для активации
		$title = $mail_message_title_congr_act;
		$message = $mail_message_body_congr_act;
			
		sendMessageMail($email, BEZ_MAIL_AUTOR, $title, $message);

		/*Перенаправляем пользователя на 
		нужную нам страницу*/
		header('Location:'. BEZ_HOST .'authorization.php?mode=reg&active=ok');
		exit;
	}
 }
 /*Если нажата кнопка на регистрацию,
 начинаем проверку*/
 if(isset($_POST['submit']))
 {
	//Утюжим пришедшие данные
	if(empty($_POST['email']))
		$err[] = $auth_errors_empty_mail;
	else
	{
		if(emailValid($_POST['email']) === false)
           $err[] = $auth_errors_not_correctly_email."\n";
	}
	
	if(empty($_POST['pass']))
		$err[] = $auth_errors_pass_can_not_be_empty;
	
	if(empty($_POST['pass2']))
		$err[] = $auth_errors_repeat_pass_can_not_be_empty;
	
	//Проверяем наличие ошибок и выводим пользователю
	if(count($err) > 0)
		echo showErrorMessage($err);
	else
	{
		/*Продолжаем проверять введеные данные
		Проверяем на совподение пароли*/
		if($_POST['pass'] != $_POST['pass2'])
			$err[] = $auth_errors_pass_not_match;
			
		//Проверяем наличие ошибок и выводим пользователю
	    if(count($err) > 0)
			echo showErrorMessage($err);
		else
		{
			/*Проверяем существует ли у нас 
			такой пользователь в БД*/
			$sql = 'SELECT `login` 
					FROM `reg`
					WHERE `login` = :login';
			//Подготавливаем PDO выражение для SQL запроса
			$stmt = $db->prepare($sql);
			$stmt->bindValue(':login', $_POST['email'], PDO::PARAM_STR);
			$stmt->execute();
			$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
			
			if(count($rows) > 0)
				$err[] = '<b>'. $_POST['email'] .'</b> - '.$auth_errors_login_busy;
			
			//Проверяем наличие ошибок и выводим пользователю
			if(count($err) > 0)
				$auth_errors .= showErrorMessage($err);
			else
			{
				//Получаем ХЕШ соли
				$salt = salt();
				
				//Солим пароль
				$pass = md5(md5($_POST['pass']).$salt);
				
				/*Если все хорошо, пишем данные в базу*/
				$sql = 'INSERT INTO `reg`
						VALUES(
								"",
								:email,
								:pass,
								:salt,
								"'. md5($salt) .'",
								0
								)';
				//Подготавливаем PDO выражение для SQL запроса
				$stmt = $db->prepare($sql);
				$stmt->bindValue(':email', $_POST['email'], PDO::PARAM_STR);
				$stmt->bindValue(':pass', $pass, PDO::PARAM_STR);
				$stmt->bindValue(':salt', $salt, PDO::PARAM_STR);
				$stmt->execute();
				
				//Отправляем письмо для активации
				$url = BEZ_HOST .'authorization.php?mode=reg&key='. md5($salt);
				$title = $activate_account_message_title;
				$message = $activate_account_message_body.'
				<a href="'. $url .'">'. $url .'</a>';
				
				sendMessageMail($_POST['email'], BEZ_MAIL_AUTOR, $title, $message);
				
				//Сбрасываем параметры
				header('Location:'. BEZ_HOST .'authorization.php?mode=reg&status=ok');
				exit;
			}
		}
	}
 }
 
?>