<?php
 /**
 * Подключение к базе данных
 * Site: http://bezramok-tlt.ru
 * Регистрация пользователя письмом
 */

 //Ключ защиты
 if(!defined('BEZ_KEY'))
 {
     header("Content-Type: text/html; charset=utf-8");
    header($_SERVER['SERVER_PROTOCOL']." 404 Not Found\r\n");
    include_once('/404.php');
    exit();
 }

//Подключение к базе данных mySQL с помощью PDO
try {
    $db = new PDO('mysql:host=localhost;dbname='.BEZ_DATABASE, BEZ_DBUSER, BEZ_DBPASSWORD, array(
    	PDO::ATTR_PERSISTENT => true
    	));

} catch (PDOException $e) {
    print "Connect error!: " . $e->getMessage() . "<br/>";
    die();
}

