<?php       session_start();
       ob_start();

include_once("settings.php");
include_once("db.php");
include_once("functions.php");

$auth_message = "";
$auth_errors = "";

$result = mysql_query("SELECT COUNT(*) FROM cache");
$total_records = mysql_result($result,0,0);

$home = true;
$page_template = file_get_contents("template/template.html");

$page_template = str_replace("[UNIQUE]", md5(uniqid(rand(),1)), $page_template);
$page_template = str_replace("[COPYRIGHT]", $copyright_text, $page_template);
$page_template = str_replace("[LANG]", $lang, $page_template);
//$page_template = str_replace("[SITE-TITLE]", $site_title, $page_template);
// top меню
/*foreach($top_menu_elements as $tm){
    $top_menu .= '<li><a class="top-menu-element" href="http://'.$_SERVER['SERVER_NAME'].'/'.mb_strtolower ($tm, "UTF-8").'">'.mb_strtolower ($tm, "UTF-8").'</a></li>';
}
$page_template = str_replace("[TOP-MENU-ELEMENTS]", $top_menu, $page_template); */
// случайные записи

$recent_searches_str = "";
$recent_searches_arr = array();
$result2 = mysql_query("SELECT * FROM (SELECT * FROM cache WHERE site_id='".$site_id."' ORDER BY id DESC LIMIT 5) sub ORDER BY id ASC");
while($line = mysql_fetch_array($result2)){
    $recent_searches_arr[]= "<a class='recent-searches-link' href='http://".$_SERVER['SERVER_NAME']."/".urlencode ($line['kw'])."'>".$line['kw']."</a>";
}
$recent_searches_str = implode(" | ", $recent_searches_arr);

//$page_template = str_replace("[TOP-RANDOM-RECORDS]", implode("&nbsp;", $top_random_records), $page_template);
//$page_template = str_replace("[BOTTOM-RANDOM-RECORDS]", implode("&nbsp;", $bottom_random_records), $page_template);

$page_template = str_replace("[PLACEHOLDER]", $placeholder, $page_template);
$page_template = str_replace("[LOADING-TEXT]", "Loading...", $page_template);

$page_template = str_replace("[RECENT-SEARCHES]", $recent_searches_title.$recent_searches_str, $page_template);

$page_template = str_replace("[MODAL-CLOSE]", $modal_close, $page_template);
$page_template = str_replace("[DOWNLOAD-PHOTO]", $download_text, $page_template);
$page_template = str_replace("[GLOBAL-SITE-TITLE]", $global_site_title, $page_template);
$page_template = str_replace("[GLOBAL-SITE-DESCRIPTION]", $global_site_description, $page_template);
$page_template = str_replace("[SERVER-NAME]", $_SERVER['SERVER_NAME'], $page_template);

//[SIGN-IN-OR-OUT]
if(isset($_SESSION['user']) && $_SESSION['user'] === true){

    $page_template = str_replace("[SIGN-IN-OR-OUT]", ' | <a class="main-menu-link" href="/myfeed.php"><i class="fas fa-heart"></i>'.$feed_title.'</a> | <a class="main-menu-link" href="http://'.$_SERVER['SERVER_NAME'].'/authorization.php?mode=auth&exit=true"><i class="fas fa-sign-out-alt"></i>'.$authorization_log_out_title.'</a>', $page_template);
}
if((isset($_SESSION['user']) && $_SESSION['user'] === false) || !isset($_SESSION['user'])){
    $page_template = str_replace("[SIGN-IN-OR-OUT]", ' | <a class="main-menu-link" href="http://'.$_SERVER['SERVER_NAME'].'/authorization.php?mode=reg"><i class="fas fa-user-plus"></i>'.$authorization_register_title.'</a> | <a class="main-menu-link" href="http://'.$_SERVER['SERVER_NAME'].'/authorization.php?mode=auth"><i class="fas fa-sign-in-alt"></i>'.$authorization_sign_in_title.'</a>', $page_template);
}

if(is_page()){
  include_once('page.php');
}else
if(is_archive_page()){
  include_once('archive_page.php');
}else
if(is_details_page()){
  include_once('details_page.php');
}else
if(is_about_page()){
  include_once('/pages/about.php');
}else
if(is_contacts_page()){
  include_once('/pages/contacts.php');
}else
if(is_useragreement_page()){
  include_once('/pages/useragreement.php');
}else
if(is_articles_list_page()){
  include_once('/pages/articles.php');
}else
if(is_authorization_page()){
  include_once('/pages/authorization.php');
}else
if(is_full_article()){
  include_once('/full_article.php');
}else
if(is_my_feed_page()){
  include_once('/pages/myfeed.php');
}else
if(is_liked_page()){
  include_once('/pages/liked.php');
}else
if(is_privacy_policy_page()){
  include_once('/pages/privacypolicy.php');
}else
if(is_home()){
  include_once('home.php');
}else{
    $incl = TRUE;
    header("Content-Type: text/html; charset=utf-8");
    header($_SERVER['SERVER_PROTOCOL']." 404 Not Found\r\n");
    include_once('404.php');
    exit();
}

  //mysql_close($db);

echo $page_template;


// генерация карты сайта
//$cur_cache_time = strtotime($row['cachetime']);
$curtime = time();
$sitemap_last_generation_time_file = "sitemap_last_generation_time.txt";

$sitemap_last_generation_time = 0;
if(file_exists ($sitemap_last_generation_time_file)){
    $sitemap_last_generation_time = file_get_contents($sitemap_last_generation_time_file);
}
//echo "<".$curtime."-".$sitemap_last_generation_time.">";

if(($curtime-$sitemap_last_generation_time) > $sitemap_generation_period){
    // сгенерить карту
    // обновить файл текущим временеим
    try{
        include_once("sitemap_generation.php");
        file_put_contents($sitemap_last_generation_time_file, $curtime);
        file_put_contents("robots.txt", "User-agent: *".PHP_EOL."Disallow: /page/".PHP_EOL."User-Agent: *".PHP_EOL."Sitemap: httр://".$_SERVER['SERVER_NAME']."/sitemap.xml");
    }catch (Exception $e){
        //
    }

}


$content2 = ob_get_contents();
ob_end_clean();

echo $content2;     //print_r($_SESSION); if(isset($_SESSION['user']) && $_SESSION['user'] === true){echo "1222222222222";}

?>