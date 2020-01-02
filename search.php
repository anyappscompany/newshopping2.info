<?php
include_once("db.php");     //adlt=strict - строгий,         demote -moderate, OFF -откл http://www.bing.com/images/async?q=porn&format=htmlraw&first=0&ADLT=demote
include_once("settings.php");
include_once("functions.php");
include('sphinxapi.php');
//$q = trim(urldecode ($_GET['q']));
$sq = trim(preg_replace('/ {2,}/',' ',preg_replace ("/[^\p{L}0-9]/iu"," ",mb_strtolower (urldecode ($_GET['q']), "UTF-8"))));
       //file_put_contents("11.txt", mysql_real_escape_string($sq)); \’\'\"



if(mb_strlen($sq)<=0) return;

$result = mysql_query("SELECT * FROM cache WHERE kw='".mysql_real_escape_string($sq)."'") or die();
$num_rows = mysql_num_rows($result);
$row=mysql_fetch_assoc($result);

$cur_cache_time = strtotime($row['cachetime']);
$curtime = time();

if(($curtime-$cur_cache_time) > $cache_time || $num_rows == 0) {

$cl = new SphinxClient();
    $cl->SetServer( "127.0.0.1", 9312 );
    //$cl->SetArrayResult (true);
    $cl->SetSortMode(SPH_SORT_RELEVANCE);
    $cl->SetFieldWeights(array (
        'html'=>5,
		'title' => 80,
		'description' => 15/*,
		'location' => 50,
		'category' => 40,
        'price' => 10,
        'fullname' => 10,
        'source' => 20       */
		));
    $cl->SetLimits(0, 56);

    // Собственно поиск
    /*$cl->SetMatchMode( SPH_MATCH_ANY  ); // ищем хотя бы 1 слово из поисковой фразы*/
    $cl->SetMatchMode( SPH_MATCH_EXTENDED2  );
    //$phrase = $sq;
    //$phrase = preg_replace('/ {2,}/',' ',preg_replace ("/[^\p{L}0-9]/iu"," ",$phrase));      //file_put_contents("22.txt", $phrase); $phrase = mysqli_real_escape_string("cooldon’t");
    //$phrase = str_replace(" ", " ", trim($phrase));
    //echo "<b>".$phrase."</b>";
    $result = $cl->Query(GetSphinxKeyword($sq), 'shop_www_columbia_com_index;shop_www_newbalance_com_index;shop_www_asics_com_index;shop_www_ralphlauren_com_index;shop_www_reebok_com_index;shop_www_michaelkors_com_index;shop_www_backcountry_com_index'); // поисковый запрос
            //print_r($result);
    // обработка результатов запроса
    if ( $result === false ) {     //echo "fff";
          //echo "Query failed: " . $cl->GetLastError() . ".\n"; // выводим ошибку если произошла
      }
      else {
          if ( $cl->GetLastWarning() ) {
              /*echo "WARNING: " . $cl->GetLastWarning() . " // выводим предупреждение если оно было
    ";         */
          }

          if ( ! empty($result["matches"]) ) { // если есть результаты поиска - обрабатываем их
          $options = array
(
        'before_match'          => '<b>',
        'after_match'           => '</b>',
        'chunk_separator'       => ' ... ',
        'limit'                 => 30,
        'around'                => 3,
);
$goods = array();

//print_r($result["matches"]);
              foreach ( $result["matches"] as $product => $info ) { //print_r($info);
              $tmp = array();
                    //echo $product . "";
                    // просто выводим id найденных товаров
                    //echo $info['attrs']['description']." ".$product.") ";//.$info['attrs']['gname'];
                    //$New_Excerpts = ($cl->BuildExcerpts(array($info['attrs']['title']), 'OlxGoods', $phrase, $options));
                    //$New_Excerpts = ($cl->BuildExcerpts(array($info['attrs']['title']), 'ColumbiaComIndex', $phrase));
                    //echo " ".$New_Excerpts[0]."<br />";
                    array_push($tmp, array("source"=>$info['attrs']['source'], "title"=>$info['attrs']['title'], "description"=>$info['attrs']['description'], "shop_id"=>$info['attrs']['shop_id'], "price"=>$info['attrs']['price'], "photos"=>$info['attrs']['photos'], "url"=>$info['attrs']['url'], "table_name"=>$info['attrs']['table_name']));
                    //array_push($tmp, $info['attrs']['description']);
                    //array_push($tmp, $info['attrs']['price']);
                    array_push($goods, $tmp);
                    unset($tmp);

              }
              //file_put_contents("11.txt",json_encode($goods, JSON_UNESCAPED_UNICODE));
             $result = mysql_query("INSERT INTO cache (kw, data, site_id, cachetime) VALUES ('".mysql_real_escape_string($sq)."','".mysql_real_escape_string(json_encode($goods, JSON_UNESCAPED_UNICODE))."',".$site_id.", '".date("Y-m-d H:i:s")."') ON DUPLICATE KEY UPDATE data='".mysql_real_escape_string(json_encode($goods, JSON_UNESCAPED_UNICODE))."', cachetime='".date("Y-m-d H:i:s")."';");
                    echo urlencode($sq);


          }else{
              return;
          }
      }


}else{
    echo urlencode($row['kw']);
}

mysql_close($db);


function GetSphinxKeyword($sQuery)
{
	$aRequestString=preg_split('/[\s,-]+/', $sQuery, 5);
	if ($aRequestString) {
	    $aKeyword = array();
		foreach ($aRequestString as $sValue)
		{
			if (strlen($sValue)>3)
			{
				$aKeyword[] = "(".$sValue." | *".$sValue."*)";
			}
		}
		$sSphinxKeyword = implode(" & ", $aKeyword);
	}
	return $sSphinxKeyword;
}
?>