<?php
$mix = explode("/", urldecode($_SERVER['REQUEST_URI']));

$result = mysql_query("SELECT * FROM cache WHERE kw='".mysql_real_escape_string($mix[1])."'");
$num_rows = mysql_num_rows($result);
$row=mysql_fetch_assoc($result);
if($num_rows == 0){
    header("Content-Type: text/html; charset=utf-8");
    header($_SERVER['SERVER_PROTOCOL']." 404 Not Found\r\n");
    include_once('404.php');
    exit();
}

$titles = array();
$shops = array();
$result = mysql_query("SELECT * FROM shops", $db);
while ($line = mysql_fetch_array($result)) {
    $shops[$line['shop_id']] = array($line['shop_name'], $line['shop_id'], $line['shop_logo'], $line['shop_url'], $line['shop_description']);
}

$content = "";
$items = json_decode($row['data']);
$count = 0;

$total_goods = count($items);
$total_pages = intval(($total_goods - 1) / $goods_limit) + 1;

$pagination="";
$pagination .= '<div class="row" id="pagination-nav-row"><div class="col-md-12 text-center"><ul class="pagination d-inline-flex">';
for($k=1;$k<=$total_pages;$k++){
    if($k==1){
        $pagination .= '<li class="active pag-nav page-item" onclick="load_more_goods('.$row['id'].', '.$goods_limit.', '.($k).', this);return false;"><a class="page-link" href="#">'.$k.'</a></li>';
    }else{
        $pagination .= '<li class="pag-nav page-item" onclick="load_more_goods('.$row['id'].', '.$goods_limit.', '.($k).', this);return false;"><a class="page-link" href="#">'.$k.'</a></li>';
    }
}
$pagination .= '</ul></div></div>';

$content .= '<div class="row">';

$first_price = 0;
foreach($items as $it){
    if($count>=$goods_limit) break;
    /*$content .= '<div class="col-sm-6 col-md-2">
                        <div class="thumbnail" title="'.$it[0].': '.$it[5].'">
                        <img onclick="modal_init(\''.$it[6].'\', \''.str_replace(" ", "-", $row['kw'])."-".$count.'.'.$it[4].'\')" data-toggle="modal" data-target="#full-view" onerror="imageerrorloading(this)" src="'.$it[6].'" alt="'.$it[0].': '.$it[5].'" title="'.$it[0].': '.$it[5].'" class="hidden-lg hidden-md hidden-sm visible-xs">
                        <div onclick="modal_init(\''.$it[6].'\', \''.str_replace(" ", "-", $row['kw'])."-".$count.'.'.$it[4].'\')" data-toggle="modal" data-target="#full-view" class="thumbnail-div hidden-xs visible-sm visible-md visible-lg" style="background: url('.$it[7].') center; background-size: cover; "></div>
                        <div class="caption">
                            <div class="file-resolution">'.$file_resolution_text.': '.$it[1].'X'.$it[2].'</div>
                            <div class="file-size">'.$file_size.': '.$it[3].'</div>
                            <div class="file-type">'.$file_type.': '.$it[4].'</div>
                            <div class="file-name">'.$file_name.': <span class="file-name-span">'.str_replace(" ", "-", $row['kw'])."-".$count.'.'.$it[4].'</span></div>
                            <!--<noindex>--> <a target="_blank" rel="nofollow" class="download" href="http://'.$_SERVER['SERVER_NAME'].'/download.php?file='.urlencode($it[6]).'&type='.$it[4].'&name='.urlencode(mb_strtolower (str_replace(" ", "-", str_replace(" ", "-", $row['kw'])."-".$count), "UTF-8")).'">'.$download_text.'</a> <!--</noindex>-->
                        </div>
                    </div>
                </div>';*/
    if($first_price == 0 || $first_price>$it[0]->price){
        $first_price = $it[0]->price;
    }

//$content .= $it[0]->title;
$photos = json_decode($it[0]->photos);

$prev_photo = "/images/picture-not-available.png";
if(mb_strlen($photos[0])>0) {$prev_photo = $photos[0];}
//<img onerror="this.onerror=null;this.src=\'http://'.$_SERVER['SERVER_NAME'].'/images/picture-not-available.png\';" style="height: 100%; width: 100%; display: block;" src="http://'.$_SERVER['SERVER_NAME'].$prev_photo.'" data-holder-rendered="true" alt="'.$it[0]->title.'" title="'.$it[0]->title.'">

$titles[] = $it[0]->title;

$content .= '<div class="col-md-12">
                    <div class="thumbnail row">
                        <div class="col-md-3">
                           <img class="d-md-none d-lg-none d-xl-none d-sm-block d-block" onerror="this.onerror=null;this.src=\'http://'.$_SERVER['SERVER_NAME'].'/images/picture-not-available.png\';" style="height: 100%; width: 100%; display: block;" src="http://'.$_SERVER['SERVER_NAME'].$prev_photo.'" data-holder-rendered="true" alt="'.$it[0]->title.'" title="'.$it[0]->title.'">
                           <div title="'.$it[0]->title.'" class="d-sm-none d-none d-md-block d-lg-block d-xl-block" style="height:179px; width:179px;background: url(http://'.$_SERVER['SERVER_NAME'].$prev_photo.') 100% 100% no-repeat; background-size: cover;background-position: center center;display: block;"></div>
                        </div>
                        <div class="caption col-md-9">';
                        //'.$price_titl.': <span class="cur-price">$'.$it[0]->price.'</span><br />
                        if(mb_strlen($it[0]->price)>0){
                            $content .= $price_titl.': <span class="cur-price">$'.$it[0]->price.'</span><br />';
                        }
                   $content .= $store_titl.': <img height="16" alt="'.$shops[$it[0]->shop_id][0].'" title="'.$shops[$it[0]->shop_id][0].'" src="'.$shops[$it[0]->shop_id][2].'" />
                            <h3 id="thumbnail-label-'.$count.'"><i title="'.$like_but_title.'" onclick=\'addlike(1, "'.$it[0]->table_name.'", "'.$it[0]->url.'", "'.$row['id'].'")\' class="far fa-thumbs-up fa-sm vote" ></i> <i title="'.$dislike_but_title.'" onclick=\'addlike(0, "'.$it[0]->table_name.'", "'.$it[0]->url.'", "'.$row['id'].'")\' class="far fa-thumbs-down fa-sm vote" ></i> '.$it[0]->title.'<a class="anchorjs-link" href="#thumbnail-label-'.$count.'"><span class="anchorjs-icon"></span></a></h3>
                            '.words_limit($it[0]->description, 25, " ...").'
                            <p><!--noindex--><a rel="nofollow" href="http://'.$_SERVER['SERVER_NAME'].'/details/'.$it[0]->url.'-'.$row['id'].'" class="btn" role="button">'.$btn_see_it.'</a><!--/noindex--> <!--noindex--><a target="_blank" rel="nofollow" href="http://'.$_SERVER['SERVER_NAME'].'/redirect.php?to='.$it[0]->source.'" class="btn" role="button">'.$btn_go_to_store.'</a><!--/noindex--></p>
                        </div>
                    </div>
                </div>';
$count++;
}
$content .= '</div>';

//$str_dop_title_text = words_limit(implode(" | ", $titles), 7, " ...");
$newtitle = words_limit($before_title.mb_ucwords($row['kw'])." | ".$after_title.": ".implode(" | ", $titles), 12, " ...");

$meta = '';
$meta .= '<meta property="og:title" content="'.addslashes($newtitle).'" />';
$meta .= '<meta property="og:type" content="og:product" />';
$meta .= '<meta property="og:url" content="http://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'].'" />';



$page_template = str_replace("[TITLE]", $newtitle, $page_template);
$page_template = str_replace("[H-TITLE]", "<h1>".$row['kw']."</h1>", $page_template);
$page_template = str_replace("[META]", $meta, $page_template);

$page_template = str_replace("[SERVER-NAME]", $_SERVER['SERVER_NAME'], $page_template);
$page_template = str_replace("[PAGINATION]", $pagination, $page_template);
$page_template = str_replace("[CONTENT]", $content, $page_template);
$page_template = str_replace("[BOTTOM-ROW]", "", $page_template);
?>