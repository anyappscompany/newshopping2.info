<?php
include_once("settings.php");
include_once("db.php");
include_once("functions.php");

$content = "";

$mix = explode("/", urldecode($_SERVER['REQUEST_URI']));
$art_url = $mix[2];

$result = mysql_query("SELECT * FROM articles WHERE url='".mysql_real_escape_string($art_url)."'");
$num_rows = mysql_num_rows($result);
$row=mysql_fetch_assoc($result);
if($num_rows == 0){
    header("Content-Type: text/html; charset=utf-8");
    header($_SERVER['SERVER_PROTOCOL']." 404 Not Found\r\n");
    include_once('404.php');
    exit();
}


$content = $row['article_text'];

$page_template = str_replace("[META]", '<meta name="robots" content="noindex,nofollow" />', $page_template);
$page_template = str_replace("[SERVER-NAME]", $_SERVER['SERVER_NAME'], $page_template);
$page_template = str_replace("[PAGINATION]", "", $page_template);
$page_template = str_replace("[BOTTOM-ROW]", "", $page_template);
$page_template = str_replace("[CONTENT]", $content, $page_template);
$page_template = str_replace("[H-TITLE]", "<h4>".$row['article_title']."</h4>", $page_template);
$page_template = str_replace("[TITLE]", "Articles: ".$row['article_title']." - ".$_SERVER['SERVER_NAME'], $page_template);


?>