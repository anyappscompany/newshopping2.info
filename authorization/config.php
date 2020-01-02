<?php
include_once('/settings.php');
 /**
 * Конфигурационный файл
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

 //Адрес базы данных
 define('BEZ_DBSERVER','localhost');

 //Логин БД
 define('BEZ_DBUSER',$userdb);

 //Пароль БД
 define('BEZ_DBPASSWORD',$passdb);

 //БД
 define('BEZ_DATABASE',$dbnamedb);

 //Префикс БД
 //define('BEZ_DBPREFIX','bez_');

 //Errors
 define('BEZ_ERROR_CONNECT','Fail connect to DB');

 //Errors
 define('BEZ_NO_DB_SELECT','Missing DB name');

 //Адрес хоста сайта
 define('BEZ_HOST','http://'. $_SERVER['HTTP_HOST'] .'/');
 
 //Адрес почты от кого отправляем
 define('BEZ_MAIL_AUTOR','Registration on http://'.$_SERVER['HTTP_HOST'].' <no-reply@'.$_SERVER['HTTP_HOST'].'>');
 ?>