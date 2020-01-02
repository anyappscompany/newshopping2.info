<?php
include_once("./settings.php");
include_once("./db.php");
include_once("./functions.php");

$content = "<dl>";

$result = mysql_query("SELECT * FROM articles WHERE active =1 ORDER BY id DESC");    //print_r(mysql_fetch_array($result));
$num_rows = mysql_num_rows($result);

while ($line = mysql_fetch_array($result)) {
    $content .= "<dt>".$line['article_title']."</dt><dd>".words_limit($line['article_text'], 15, " ...<br /><a href='http://".$_SERVER['SERVER_NAME']."/art/".$line['url']."'>".$read_more_article_text."</a>")."</dd>";   //words_limit($it[0]->description, 25, " ...")
}

$content .= "</dl>";

$page_template = str_replace("[META]", '<meta name="robots" content="noindex,nofollow" />', $page_template);
$page_template = str_replace("[SERVER-NAME]", $_SERVER['SERVER_NAME'], $page_template);
$page_template = str_replace("[PAGINATION]", "", $page_template);
$page_template = str_replace("[BOTTOM-ROW]", "", $page_template);
$page_template = str_replace("[CONTENT]", $content, $page_template);
$page_template = str_replace("[H-TITLE]", "<h4>Welcome to Article Catalog Directory</h4>", $page_template);
$page_template = str_replace("[TITLE]", "Articles ".$_SERVER['SERVER_NAME'], $page_template);




?>