<?php
                    
$shops = array();
$result = mysql_query("SELECT * FROM shops", $db);
while ($line = mysql_fetch_array($result)) {
    $shops[$line['shop_id']] = array($line['shop_name'], $line['shop_id'], $line['shop_logo'], $line['shop_url'], $line['shop_description']);
}

$result = mysql_query("SELECT * FROM likes ORDER BY last_mod DESC LIMIT ".$lim_liked."");
$num_rows = mysql_num_rows($result);

/*
while ($line = mysql_fetch_array($result)) {
    //$shops[$line['shop_id']] = array($line['shop_name'], $line['shop_id'], $line['shop_logo'], $line['shop_url'], $line['shop_description']);
    $result1 = mysql_query("SELECT * FROM ".$line['table_name']." WHERE url='".mysql_real_escape_string($line['url'])."'");
    $row = mysql_fetch_assoc($result1);
    //echo $row['url']." ";
}*/
$content = "";
$count = 0;
$content .= '<div class="row">';

while ($line = mysql_fetch_array($result)) {
    $result1 = mysql_query("SELECT * FROM ".$line['table_name']." WHERE url='".mysql_real_escape_string($line['url'])."' AND active=1");
    $it = mysql_fetch_assoc($result1);
    //if($count>=$goods_limit) break;
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

//$content .= $it[0]->title;
$photos = json_decode($it['photos']);

$prev_photo = "/images/picture-not-available.png";
if(mb_strlen($photos[0])>0) {$prev_photo = $photos[0];}
//<img onerror="this.onerror=null;this.src=\'http://'.$_SERVER['SERVER_NAME'].'/images/picture-not-available.png\';" style="height: 100%; width: 100%; display: block;" src="http://'.$_SERVER['SERVER_NAME'].$prev_photo.'" data-holder-rendered="true" alt="'.$it[0]->title.'" title="'.$it[0]->title.'">
$content .= '<div class="col-md-12">
                    <div class="thumbnail row">
                        <div class="col-md-3">
                           <img class="d-md-none d-lg-none d-xl-none d-sm-block d-block" onerror="this.onerror=null;this.src=\'http://'.$_SERVER['SERVER_NAME'].'/images/picture-not-available.png\';" style="height: 100%; width: 100%; display: block;" src="http://'.$_SERVER['SERVER_NAME'].$prev_photo.'" data-holder-rendered="true" alt="'.$it['title'].'" title="'.$it['title'].'">
                           <div title="'.$it['title'].'" class="d-sm-none d-none d-md-block d-lg-block d-xl-block" style="height:179px; width:179px;background: url(http://'.$_SERVER['SERVER_NAME'].$prev_photo.') 100% 100% no-repeat; background-size: cover;background-position: center center;display: block;"></div>
                        </div>
                        <div class="caption col-md-9">';
                        //'.$price_titl.': <span class="cur-price">$'.$it[0]->price.'</span><br />
                        if(mb_strlen($it['price'])>0){
                            $content .= $price_titl.': <span class="cur-price">$'.$it['price'].'</span><br />';
                        }
                   $content .= $store_titl.': <img height="16" alt="'.$shops[$it['shop_id']][0].'" title="'.$shops[$it['shop_id']][0].'" src="'.$shops[$it['shop_id']][2].'" />
                            <h3 id="thumbnail-label-'.$count.'">'.$it['title'].'<a class="anchorjs-link" href="#thumbnail-label-'.$count.'"><span class="anchorjs-icon"></span></a></h3>
                            '.words_limit($it['description'], 25, " ...").'
                            <p><!--noindex--><a rel="nofollow" href="http://'.$_SERVER['SERVER_NAME'].'/details/'.$it['url'].'-'.$line['it_id'].'" class="btn" role="button">'.$btn_see_it.'</a><!--/noindex--> <!--noindex--><a target="_blank" rel="nofollow" href="http://'.$_SERVER['SERVER_NAME'].'/redirect.php?to='.$it['source'].'" class="btn" role="button">'.$btn_go_to_store.'</a><!--/noindex--></p>
                        </div>
                    </div>
                </div>';
$count++;
}

$content .= '</div>';

    $page_template = str_replace("[TITLE]", $liked_page_title, $page_template);
    $page_template = str_replace("[H-TITLE]", $liked_page_h, $page_template);
    $page_template = str_replace("[META]", '', $page_template);

    $page_template = str_replace("[SERVER-NAME]", $_SERVER['SERVER_NAME'], $page_template);
    $page_template = str_replace("[PAGINATION]", "", $page_template);
    $page_template = str_replace("[CONTENT]", $content, $page_template);
    $page_template = str_replace("[BOTTOM-ROW]", "", $page_template);





?>