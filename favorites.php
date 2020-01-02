<?php
include_once("settings.php");
include_once("db.php");
include_once("functions.php");

//file_put_contents("11.txt", $_GET);
if(isset($_GET['act']) && isset($_GET['shop']) && isset($_GET['user']) && isset($_GET['url']) && isset($_GET['itid'])){
    switch($_GET['act']){
        case 0:
        $result4 = mysql_query("DELETE FROM favorites where user_id='".mysql_real_escape_string($_GET['user'])."' AND table_name='".mysql_real_escape_string($_GET['shop'])."' AND url='".mysql_real_escape_string($_GET['url'])."' AND it_id='".mysql_real_escape_string($_GET['itid'])."'");
        break;
        case 1:
        $result5 = mysql_query("SELECT COUNT(*) FROM favorites where user_id='".mysql_real_escape_string($_GET['user'])."' AND table_name='".mysql_real_escape_string($_GET['shop'])."' AND url='".mysql_real_escape_string($_GET['url'])."' AND it_id='".mysql_real_escape_string($_GET['itid'])."'");
        $total_results = mysql_result($result5,0,0);
        if($total_results <=0){
            $result6 = mysql_query("INSERT INTO favorites (user_id, table_name, url, it_id, dateadd) VALUES ('".mysql_real_escape_string($_GET['user'])."','".mysql_real_escape_string($_GET['shop'])."', '".mysql_real_escape_string($_GET['url'])."', '".mysql_real_escape_string($_GET['itid'])."', '".date("Y-m-d H:i:s")."')");
        }
        break;
    }

    //если с такими данными не найдена запись, то вставить

}

mysql_close($db);
?>

