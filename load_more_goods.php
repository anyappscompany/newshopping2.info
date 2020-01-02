<?php
include_once("settings.php");
include_once("db.php");
include_once("functions.php");


$result = mysql_query("SELECT * FROM cache WHERE id='".mysql_real_escape_string($_GET['cache_id'])."'");
$num_rows = mysql_num_rows($result);
$row=mysql_fetch_assoc($result);
if($num_rows == 0){
    echo ""; exit;
}

//echo $_GET['cache_id'].$_GET['goods_limit'].$_GET['page_num'];
$items = json_decode($row['data']);

$shops = array();
$result = mysql_query("SELECT * FROM shops", $db);
while ($line = mysql_fetch_array($result)) {
    $shops[$line['shop_id']] = array($line['shop_name'], $line['shop_id'], $line['shop_logo'], $line['shop_url'], $line['shop_description']);
}

$content = "";
$count = 0;
$content .= '<div class="row">';

for($i=($_GET['page_num']*$_GET['goods_limit']-$_GET['goods_limit']); $i<$_GET['page_num']*$_GET['goods_limit'];$i++){

if($i>=count($items)) break;

    //$rows.= $items[$i][0]->title;
    $photos = json_decode($items[$i][0]->photos);

$prev_photo = "/images/picture-not-available.png";
if(mb_strlen($photos[0])>0) {$prev_photo = $photos[0];}
//<img onerror="this.onerror=null;this.src=\'http://'.$_SERVER['SERVER_NAME'].'/images/picture-not-available.png\';" style="height: 100%; width: 100%; display: block;" src="http://'.$_SERVER['SERVER_NAME'].$prev_photo.'" data-holder-rendered="true" alt="'.$it[0]->title.'" title="'.$it[0]->title.'">
$content .= '<div class="col-md-12">
                    <div class="thumbnail row">
                        <div class="col-md-3">
                           <img class="d-md-none d-lg-none d-xl-none d-sm-block d-block" onerror="this.onerror=null;this.src=\'http://'.$_SERVER['SERVER_NAME'].'/images/picture-not-available.png\';" style="height: 100%; width: 100%; display: block;" src="http://'.$_SERVER['SERVER_NAME'].$prev_photo.'" data-holder-rendered="true" alt="'.$items[$i][0]->title.'" title="'.$items[$i][0]->title.'">
                           <div title="'.$items[$i][0]->title.'" class="d-sm-none d-none d-md-block d-lg-block d-xl-block" style="height:179px; width:179px;background: url(http://'.$_SERVER['SERVER_NAME'].$prev_photo.') 100% 100% no-repeat; background-size: cover; background-position: center center;"></div>
                        </div>
                        <div class="caption col-md-9">';
                    if(mb_strlen($items[$i][0]->price)>0){
                       $content .= 'Price: <span class="cur-price">$'.$items[$i][0]->price.'</span><br />';
                    }
                        //Price: <span class="cur-price">$'.$items[$i][0]->price.'</span><br />
                        $content .= $store_titl.': <img height="16" alt="'.$shops[$items[$i][0]->shop_id][0].'" title="'.$shops[$items[$i][0]->shop_id][0].'" src="'.$shops[$items[$i][0]->shop_id][2].'" alt="" />
                            <h3 id="thumbnail-label-'.$count.'"><i title="'.$like_but_title.'" onclick=\'addlike(1, "'.$items[$i][0]->table_name.'", "'.$items[$i][0]->url.'", "'.$row['id'].'")\' class="far fa-thumbs-up fa-sm vote" ></i> <i title="'.$dislike_but_title.'" onclick=\'addlike(0, "'.$items[$i][0]->table_name.'", "'.$items[$i][0]->url.'", "'.$row['id'].'")\' class="far fa-thumbs-down fa-sm vote" ></i> '.$items[$i][0]->title.'<a class="anchorjs-link" href="#thumbnail-label-'.$count.'"><span class="anchorjs-icon"></span></a></h3>
                            '.words_limit($items[$i][0]->description, 25, " ...").'
                            <p><!--noindex--><a rel="nofollow" href="http://'.$_SERVER['SERVER_NAME'].'/details/'.$items[$i][0]->url.'-'.$row['id'].'" class="btn btn-default" role="button">'.$btn_see_it.'</a><!--/noindex--> <!--noindex--><a target="_blank" rel="nofollow" href="http://'.$_SERVER['SERVER_NAME'].'/redirect.php?to='.$items[$i][0]->source.'" class="btn btn-default" role="button">'.$btn_go_to_store.'</a><!--/noindex--></p>
                        </div>
                    </div>
                </div>';
$count++;
}
$content .= '</div>';
echo $content;




mysql_close($db);
?>