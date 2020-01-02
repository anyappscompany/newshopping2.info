<?php
include_once("settings.php");
include_once("db.php");
include_once("functions.php");

//file_put_contents("11.txt", $_GET);
if(isset($_GET['act']) && isset($_GET['shop']) && isset($_GET['url']) && isset($_GET['itid'])){
    $total_results = 0;
    $result2 = mysql_query("SELECT * FROM likes WHERE table_name='".mysql_real_escape_string($_GET['shop'])."' AND url='".mysql_real_escape_string($_GET['url'])."' AND it_id='".mysql_real_escape_string($_GET['itid'])."'");
    $total_results = mysql_num_rows($result2);
    $one_row = mysql_fetch_array($result2);

    switch($_GET['act']){
        case 0:
            if($total_results<=0){
                $result4 = mysql_query("INSERT INTO likes (table_name, url, it_id, val, last_mod) VALUES ('".mysql_real_escape_string($_GET['shop'])."', '".mysql_real_escape_string($_GET['url'])."', '".mysql_real_escape_string($_GET['itid'])."', -1, '".date("Y-m-d H:i:s")."')");
            }else{
                $val = $one_row['val']-1;
                $result4 = mysql_query("UPDATE likes SET val=".$val." WHERE table_name='".mysql_real_escape_string($_GET['shop'])."' AND url='".mysql_real_escape_string($_GET['url'])."' AND it_id='".mysql_real_escape_string($_GET['itid'])."'");
            }
        break;
        case 1:
        if($total_results<=0){
                $result4 = mysql_query("INSERT INTO likes (table_name, url, it_id, val, last_mod) VALUES ('".mysql_real_escape_string($_GET['shop'])."', '".mysql_real_escape_string($_GET['url'])."', '".mysql_real_escape_string($_GET['itid'])."', 1, '".date("Y-m-d H:i:s")."')");
            }else{
                $val = $one_row['val']+1;
                $result4 = mysql_query("UPDATE likes SET val=".$val." WHERE table_name='".mysql_real_escape_string($_GET['shop'])."' AND url='".mysql_real_escape_string($_GET['url'])."' AND it_id='".mysql_real_escape_string($_GET['itid'])."'");
            }
        break;
    }

    //если с такими данными не найдена запись, то вставить

}

mysql_close($db);
?>
