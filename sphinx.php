D:\SphinxServer\bin\searchd --install --config D:\SphinxServer\sphinx.conf.in --servicename SphinxSearch

без индексации не запускается
indexer --config D:\SphinxServer\sphinx.conf.in --all<br />
<?php
// Подключим файл с api
    include('sphinxapi.php');

    // Создадим объект - клиент сфинкса и подключимся к нашей службе
    $cl = new SphinxClient();
    $cl->SetServer( "127.0.0.1", 9312 );
    //$cl->SetArrayResult (true);
    $cl->SetSortMode(SPH_SORT_RELEVANCE);
    $cl->SetFieldWeights(array (
        'html'=>10,
		'title' => 60,
		'description' => 30/*,
		'location' => 50,
		'category' => 40,
        'price' => 10,
        'fullname' => 10,
        'source' => 20       */
		));
    $cl->SetLimits(0, 10);

    // Собственно поиск
    /*$cl->SetMatchMode( SPH_MATCH_ANY  ); // ищем хотя бы 1 слово из поисковой фразы*/
    $cl->SetMatchMode( SPH_MATCH_EXTENDED2  );
    $phrase = "childrens winter coats";
    $phrase = preg_replace('/ {2,}/',' ',preg_replace ("/[^\p{L}0-9]/iu"," ",$phrase));
    //$phrase = str_replace(" ", " ", trim($phrase));
    //echo "<b>".$phrase."</b>";
    $result = $cl->Query(GetSphinxKeyword($phrase), 'ColumbiaComIndex;NewBalanceComIndex'); // поисковый запрос

    // обработка результатов запроса
    if ( $result === false ) {
          echo "Query failed: " . $cl->GetLastError() . ".\n"; // выводим ошибку если произошла
      }
      else {
          if ( $cl->GetLastWarning() ) {
              echo "WARNING: " . $cl->GetLastWarning() . " // выводим предупреждение если оно было
    ";
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
              foreach ( $result["matches"] as $product => $info ) { //print_r($info);
                    //echo $product . "";
                    // просто выводим id найденных товаров
                    //echo $info['attrs']['description']." ".$product.") ";//.$info['attrs']['gname'];
                    //$New_Excerpts = ($cl->BuildExcerpts(array($info['attrs']['title']), 'OlxGoods', $phrase, $options));
                    $New_Excerpts = ($cl->BuildExcerpts(array($info['attrs']['title']), 'ColumbiaComIndex', $phrase));
                    echo " ".$New_Excerpts[0]."<br />";
              }



          }
      }

  exit;

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