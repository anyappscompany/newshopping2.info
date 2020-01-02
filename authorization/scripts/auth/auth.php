<?php
 /**
 * Обработчик формы авторизации
 * Site: http://bezramok-tlt.ru
 * Авторизация пользователя
 */
 
 //Выход из авторизации
 if(isset($_GET['exit']) == true){
 	//Уничтожаем сессию
 	session_destroy();

 	//Делаем редирект
 	header('Location:'. BEZ_HOST .'authorization.php?mode=auth');
 	exit;
 }

 //Если нажата кнопка то обрабатываем данные
 if(isset($_POST['submit']))
 {
	//Проверяем на пустоту
	if(empty($_POST['email']))
		$err[] = $auth_errors_not_entered_login;
	
	if(empty($_POST['pass']))
		$err[] = $auth_errors_not_entered_password;
	
	//Проверяем email
	if(emailValid($_POST['email']) === false)
		$err[] = $auth_errors_not_valid_mail;

	//Проверяем наличие ошибок и выводим пользователю
	if(count($err) > 0)
		echo showErrorMessage($err);
	else
	{
		/*Создаем запрос на выборку из базы 
		данных для проверки подлиности пользователя*/
		$sql = 'SELECT * 
				FROM `reg`
				WHERE `login` = :email
				AND `status` = 1';
		//Подготавливаем PDO выражение для SQL запроса
		$stmt = $db->prepare($sql);
		$stmt->bindValue(':email', $_POST['email'], PDO::PARAM_STR);
		$stmt->execute();

		//Получаем данные SQL запроса
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		
		//Если логин совподает, проверяем пароль
		if(count($rows) > 0)
		{
			//Получаем данные из таблицы
			if(md5(md5($_POST['pass']).$rows[0]['salt']) == $rows[0]['pass'])
			{	
				$_SESSION['user'] = true;
				$_SESSION['userid'] = $rows[0]['id'];

				//Сбрасываем параметры
				header('Location:'. BEZ_HOST .'authorization.php?mode=auth');
				exit;
			}
			else
				$auth_errors .= showErrorMessage($auth_errors_incorrect_password);
		}else{
			$auth_errors .= showErrorMessage('<b>'. $_POST['email'] .'</b> - '.$auth_errors_login_not_found);
		}
	}
 }
 
?>