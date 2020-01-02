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
foreach($items as $it){         if($cache_url == $it[0]->url){
                             $title = $it[0]->title;
                             $h1 = $it[0]->title;
//$content .= $it[0]->title;
$photos = json_decode($it[0]->photos);
                             //print_r($shops[$it[0]->shop_id]);
$content .= '<div class="row"><div class="col-md-12">';

$content .= '<hr /><img alt="'.$shops[$it[0]->shop_id][0].'" title="'.$shops[$it[0]->shop_id][0].'" height="16" src="http://'.$_SERVER['SERVER_NAME'].'/'.$shops[$it[0]->shop_id][2].'" /><br />';
$content .= $price_titl.": <span class='cur-price'>$".$it[0]->price."</span><br />";
$content .= '<!--noindex--><a target="_blank" rel="nofollow" href="http://'.$_SERVER['SERVER_NAME'].'/redirect.php?to='.$it[0]->source.'" class="btn btn-default" role="button">'.$btn_go_to_store.'</a><!--/noindex--><hr />';

$content .= '</div></div>';

$carousel_indicators = "";
$carousel_inner = "";
$content .= '<div class="row">';
$count2= 0;
foreach($photos as $pic){

$mix3 = explode("/", $pic);
    if($count2 ==0){
        $carousel_indicators .= '<li data-target="#carousel1" data-slide-to="'.$count2.'" class="active"></li>';
        $carousel_inner .= '<div class="carousel-item active">
                    <img class="d-block w-100" src="http://'.$_SERVER['SERVER_NAME'].$pic.'" alt="First slide">
                    <div class="carousel-caption d-none d-md-block">
                        <h3>Slide label 1</h3>
                        <p><img src="https://lh6.ggpht.com/x0QFTdQGj1DR9ynA4B_l91xXVXxRG3gzg6X9aO3nYXfycsHIG2tSqXHzlWMWEEDvEcDUGpQ=w320-h100" alt="" /></p>
                    </div>
                </div>';
    }else{
        $carousel_indicators .= '<li data-target="#carousel1" data-slide-to="'.$count2.'"></li>';
        $carousel_inner .= '<div class="carousel-item">
                    <img class="d-block w-100" src="http://'.$_SERVER['SERVER_NAME'].$pic.'" alt="First slide">
                    <div class="carousel-caption d-none d-md-block">
                        <h3>Slide label 1</h3>
                        <p><img src="https://lh6.ggpht.com/x0QFTdQGj1DR9ynA4B_l91xXVXxRG3gzg6X9aO3nYXfycsHIG2tSqXHzlWMWEEDvEcDUGpQ=w320-h100" alt="" /></p>
                    </div>
                </div>';
    }
    /*$content .= '<div class="col-sm-12 col-md-6 col-lg-3">
                        <div class="thumbnail" title="'.$it[0]->title.'">
                        <img onclick="modal_init(\'http://'.$_SERVER['SERVER_NAME'].$pic.'\', \''.addslashes ($it[0]->title).'\')" data-toggle="modal" data-target="#full-view" onerror="this.onerror=null;this.src=\'http://'.$_SERVER['SERVER_NAME'].'/images/picture-not-available.png\';" src="http://'.$_SERVER['SERVER_NAME'].$pic.'" alt="'.$it[0]->title.'" title="'.$it[0]->title.'" class="d-block d-sm-none d-md-none d-lg-none d-xl-none w-100 img-thumbnail">
                        <div title="'.$it[0]->title.'" onclick="modal_init(\'http://'.$_SERVER['SERVER_NAME'].$pic.'\', \''.addslashes ($it[0]->title).'\')" data-toggle="modal" data-target="#full-view" class="thumbnail-div img-thumbnail d-none d-sm-block d-md-block d-lg-block d-xl-block" style="background: url(http://'.$_SERVER['SERVER_NAME'].$pic.') center; background-size: cover; "></div>
                        <div class="caption">

                            <!--<noindex>--> <a target="_blank" rel="nofollow" class="download" href="http://'.$_SERVER['SERVER_NAME'].'/download.php?file=http://'.$_SERVER['SERVER_NAME'].$pic.'&name='.$mix3[4].'">'.$download_text.'</a> <!--</noindex>-->
                        </div>
                    </div>
                </div>';*/
    $count2++;
}


$content .= '<div id="carousel1" class="carousel slide w-50" data-ride="carousel">
            <ol class="carousel-indicators">';
$content .= $carousel_indicators;
$content .= '</ol><div class="carousel-inner">';
$content .= $carousel_inner;
$content .= '</div>
            <a class="carousel-control-prev" href="#carousel1" role="button" data-slide="prev"> <span class="carousel-control-prev-icon text-warning bg-dark" aria-hidden="true"></span> <span class="sr-only">Previous</span> </a>
            <a class="carousel-control-next" href="#carousel1" role="button" data-slide="next"> <span class="carousel-control-next-icon text-warning bg-dark" aria-hidden="true"></span> <span class="sr-only">Next</span> </a>
        </div>';



$content .= '</div>';


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

}
$count++;
}
          //<img class='star-on-off' src='/images/star_off.png'></img>
$page_template = str_replace("[TITLE]", $before_title.mb_ucwords($title).$after_title, $page_template);
$page_template = str_replace("[H1]", "<h1 id='details-h1'>".$h1."</h1>", $page_template);
$page_template = str_replace("[META]", '<meta name="robots" content="noindex,nofollow" />', $page_template);
$page_template = str_replace("[MODAL-CLOSE]", $modal_close, $page_template);
$page_template = str_replace("[SERVER-NAME]", $_SERVER['SERVER_NAME'], $page_template);
$page_template = str_replace("[PAGINATION]", "", $page_template);
$page_template = str_replace("[CONTENT]", $content, $page_template);
?>
