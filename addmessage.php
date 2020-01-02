<?php
include_once("settings.php");
include_once("db.php");
include_once("functions.php");

$name = "";
$message = "";
$email = "";
//date("Y-m-d H:i:s")

if(!empty($_POST['username'])){$name = $_POST['username'];}  
if(!empty($_POST['useremail'])){$email = $_POST['useremail'];}
if(!empty($_POST['usermessage'])){$message = $_POST['usermessage'];}

if(mb_strlen ($name)>0 && mb_strlen ($email)>0 && mb_strlen ($message)>0){
    $result = mysql_query("INSERT INTO messages (name, email, message, site_id, domain, add_date) VALUES ('".mysql_real_escape_string($name)."','".mysql_real_escape_string($email)."', '".mysql_real_escape_string($message)."', ".$site_id.", '".$_SERVER['SERVER_NAME']."',  '".date("Y-m-d H:i:s")."')");
    if(!$result){
        echo $contacts_message_failed_to_send;
    }else{
        echo $contacts_message_sent_successfully;
    }
}else{
    echo $contacts_message_failed_to_send;
}

mysql_close($db);
?>