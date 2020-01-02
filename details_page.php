<?php
$mix = explode("/", urldecode($_SERVER['REQUEST_URI']));
$mix2 = explode("-", $mix[2]);
$cache_id = $mix2[1];
$cache_url = $mix2[0];

$result = mysql_query("SELECT * FROM cache WHERE id='".mysql_real_escape_string($cache_id)."'");
$num_rows = mysql_num_rows($result);
$row=mysql_fetch_assoc($result);
if($num_rows == 0){
    header("Content-Type: text/html; charset=utf-8");
    header($_SERVER['SERVER_PROTOCOL']." 404 Not Found\r\n");
    include_once('404.php');
    exit();
}



$shops = array();
$result = mysql_query("SELECT * FROM shops", $db);
while ($line = mysql_fetch_array($result)) {
    $shops[$line['shop_id']] = array($line['shop_name'], $line['shop_id'], $line['shop_logo'], $line['shop_url'], $line['shop_description']);
}

$content = "";
$items = json_decode($row['data']);
$count = 0;


$title = "";
$h1 = "";
$total_results = 0;
$naiden_url = 0;
foreach($items as $it){         if($cache_url == $it[0]->url){  $naiden_url = 1;
                             $title = $it[0]->title;
                             $h1 = $it[0]->title;
//$content .= $it[0]->title;
$photos = json_decode($it[0]->photos);
                             //print_r($shops[$it[0]->shop_id]);
$content .= '<div class="row"><div class="col-md-12">';

//$content .= $store_titl.": ".$shops[$it[0]->shop_id][0].", ";
$content .= $price_titl.": <span class='cur-price'>$".$it[0]->price."</span>, ";
$content .= '<!--noindex--><a target="_blank" rel="nofollow" href="http://'.$_SERVER['SERVER_NAME'].'/redirect.php?to='.$it[0]->source.'">'.$btn_go_to_store.'</a> '.$shops[$it[0]->shop_id][0].'<!--/noindex-->';

$content .= '</div></div>';


if(count($photos)>0){
$content .= '<div class="row">';
foreach($photos as $pic){

$mix3 = explode("/", $pic);
//<!--<noindex>--> <a target="_blank" rel="nofollow" class="download" href="http://'.$_SERVER['SERVER_NAME'].'/download.php?file=http://'.$_SERVER['SERVER_NAME'].$pic.'&name='.$mix3[4].'">'.$download_text.'</a> <!--</noindex>-->
    $content .= '<div class="col-sm-12 col-md-6 col-lg-3">
                        <div class="thumbnail" title="'.$it[0]->title.'">
                        <img onclick="modal_init(\'http://'.$_SERVER['SERVER_NAME'].$pic.'\', \''.addslashes ($it[0]->title).'\')" data-toggle="modal" data-target="#full-view" onerror="this.onerror=null;this.src=\'http://'.$_SERVER['SERVER_NAME'].'/images/picture-not-available.png\';" src="http://'.$_SERVER['SERVER_NAME'].$pic.'" alt="'.$it[0]->title.'" title="'.$it[0]->title.'" style="margin:3px;" class="d-block d-sm-none d-md-none d-lg-none d-xl-none w-100 img-thumbnail">
                        <div title="'.$it[0]->title.'" onclick="modal_init(\'http://'.$_SERVER['SERVER_NAME'].$pic.'\', \''.addslashes ($it[0]->title).'\')" data-toggle="modal" data-target="#full-view" class="thumbnail-div img-thumbnail d-none d-sm-block d-md-block d-lg-block d-xl-block w-100 img-thumbnail" style="background: url(http://'.$_SERVER['SERVER_NAME'].$pic.') center; background-size: cover; margin:3px;"></div>
                        <div class="caption">


                        </div>
                    </div>
                </div>';
}
$content .= '</div>';
}


$content .= '<div class="row"><div class="col-md-12">';
$content .= strip_tags($it[0]->description, "<p><ul><li><br><hr><b><ol><span><em><h2><h3><h4><h5><h6><i><label><strong><table><tr><td><u>");
$content .= '</div></div>';


//$prev_photo = "/images/picture-not-available.png";
//if(mb_strlen($photos[0])>0) {$prev_photo = $photos[0];}

/*$content .= '<div class="col-md-12">
                    <div class="thumbnail row">
                        <div class="col-md-3">
                           <img class="hidden-md hidden-lg" onerror="this.onerror=null;this.src=\'http://'.$_SERVER['SERVER_NAME'].'/images/picture-not-available.png\';" style="height: 100%; width: 100%; display: block;" src="http://'.$_SERVER['SERVER_NAME'].$prev_photo.'" data-holder-rendered="true" alt="'.$it[0]->title.'" title="'.$it[0]->title.'">
                           <div class="hidden-xs hidden-sm" style="height:179px; width:179px;background: url(http://'.$_SERVER['SERVER_NAME'].$prev_photo.') 100% 100% no-repeat; background-size: cover;background-position: center center;"></div>
                        </div>
                        <div class="caption col-md-9">';
                        //'.$price_titl.': <span class="cur-price">$'.$it[0]->price.'</span><br />
                        if(mb_strlen($it[0]->price)>0){
                            $content .= $price_titl.': <span class="cur-price">$'.$it[0]->price.'</span><br />';
                        }
                   $content .= $brand_titl.': <img height="16px" alt="'.$shops[$it[0]->shop_id][0].'" title="'.$shops[$it[0]->shop_id][0].'" src="'.$shops[$it[0]->shop_id][2].'" alt="" />
                            <h3 id="thumbnail-label">'.$it[0]->title.'<a class="anchorjs-link" href="#thumbnail-label"><span class="anchorjs-icon"></span></a></h3>
                            '.words_limit($it[0]->description, 25, " ...").'
                            <p><!--noindex--><a rel="nofollow" href="http://'.$_SERVER['SERVER_NAME'].'/details/'.$it[0]->url.'-'.$row['id'].'" class="btn btn-default" role="button">'.$btn_see_it.'</a><!--/noindex--> <!--noindex--><a target="_blank" rel="nofollow" href="http://'.$_SERVER['SERVER_NAME'].'/redirect.php?to='.$it[0]->source.'" class="btn btn-default" role="button">'.$btn_go_to_store.'</a><!--/noindex--></p>
                        </div>
                    </div>
                </div>';*/
if(isset($_SESSION['user']) && $_SESSION['user'] === true){
    //echo "SELECT COUNT(*) FROM favorites WHERE user_id='".mysql_real_escape_string($_SESSION['userid'])."' AND table_name='".mysql_real_escape_string($it[0]->table_name)."' AND url='".mysql_real_escape_string($cache_url)."'";
    $result4 = mysql_query("SELECT COUNT(*) FROM favorites WHERE user_id='".mysql_real_escape_string($_SESSION['userid'])."' AND table_name='".mysql_real_escape_string($it[0]->table_name)."' AND url='".mysql_real_escape_string($cache_url)."'");
    $total_results = mysql_result($result4,0,0);
}
$bottom_row = '';/*
$bottom_row .= '<div class="row">';
$count3 = 0;
foreach($items as $it){if($count3>3) {break;}
                             $title = $it[0]->title;
                             $h1 = $it[0]->title;
//$content .= $it[0]->title;
$photos = json_decode($it[0]->photos);
$bottom_row .= '<div class="col-md-3"><a href="http://'.$_SERVER['SERVER_NAME'].'/details/'.$it[0]->url.'-'.$cache_id.'">


<div class="thumbnail" title="'.$it[0]->title.'">
                        <img onerror="this.onerror=null;this.src=\'http://'.$_SERVER['SERVER_NAME'].'/images/picture-not-available.png\';" src="http://'.$_SERVER['SERVER_NAME'].$photos[0].'" alt="'.$it[0]->title.'" title="'.$it[0]->title.'" style="margin:3px;" class="d-block d-sm-none d-md-none d-lg-none d-xl-none w-100 img-thumbnail">
                        <div title="'.$it[0]->title.'" class="thumbnail-div img-thumbnail d-none d-sm-block d-md-block d-lg-block d-xl-block w-100 img-thumbnail" style="background: url(http://'.$_SERVER['SERVER_NAME'].$photos[0].') center; background-size: cover; margin:3px;"></div>
                        <div class="caption"><h5>
                        '.$it[0]->title.'</h5>

                        </div>
</div>


</div></a>';
$count3++;
}
$bottom_row .= '</div>';*/
//echo $cache_url."---".$it[0]->url;
$meta = '';
$meta .= '<meta property="og:title" content="'.addslashes($before_title.mb_ucwords($title)." - ".$_SERVER['SERVER_NAME']).'" />';
$meta .= '<meta property="og:type" content="og:product" />';
$meta .= '<meta property="og:url" content="http://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'].'" />';
if(count($photos)>0){
    $meta .= '<meta property="og:image" content="http://'.$_SERVER['SERVER_NAME'].$pic.'" />';
}

          //<img class='star-on-off' src='/images/star_off.png'></img>
$page_template = str_replace("[TITLE]", $before_title.mb_ucwords($title)." - ".$_SERVER['SERVER_NAME'], $page_template);         //print_r($it[0]);
$page_template = str_replace("[H-TITLE]", "<i title='".$add_to_favorites."' onclick=\"toogle_hearth_class(this, ".(isset($_SESSION['user']) && $_SESSION['user'] === true? 'true':'false').",'".$it[0]->table_name."', '".(isset($_SESSION['user']) && $_SESSION['user'] === true? $_SESSION['userid']:'false')."', '".$it[0]->url."', '".$row['id']."')\" style=\"color:".($total_results == 1?'goldenrod':'lightgray').";cursor: pointer;\" class=\"fas fa-heart fa-2x\"></i> <h1 id='details-h1'>".$h1."</h1><br />", $page_template);
$page_template = str_replace("[META]", $meta.'<meta name="robots" content="noindex,nofollow" />', $page_template);

$page_template = str_replace("[SERVER-NAME]", $_SERVER['SERVER_NAME'], $page_template);
$page_template = str_replace("[PAGINATION]", "", $page_template);
$page_template = str_replace("[CONTENT]", $content, $page_template);
$page_template = str_replace("[BOTTOM-ROW]", $bottom_row, $page_template);
}
$count++;
}

if(!$naiden_url){
    header('Location:'. 'http://'.$_SERVER['SERVER_NAME'].'/' .'404.php');
		exit;
}

?>
