<?php
$content = "";
$content = <<<EOD
<p>As ecommerce evolves, sellers and buyers are increasingly sophisticated and adventurous, demanding more choice. Consumers want the widest range of products and stores, along with the information and data necessary to navigate those choices efficiently. Merchants demand exposure to the ever-expanding, global population of shoppers.</p>
<h5>Mission</h5>
<p>Mission is to help consumers anywhere use the power of information to find, compare and buy anything!</p>
<h5>Helping change the way consumers shop and merchants sell online</h5>
<p>For consumers, is the ultimate starting point for online shopping. The world's largest product catalog - searchable by thousands of attributes - provides an unprecedented depth of information necessary to make purchase decisions in one easy-to-navigate place. From Puma sneakers to garden furniture, shoppers in Boise, Idaho or Paris, France, confidently can find the right product at the right price and from the right merchant generally in fewer than five clicks.</p>
<p>Consistently ranks among the top ten global ecommerce destinations with websites in the U.S., the U.K., France and Germany.</p>
<p>For merchants, provides one of the most productive and efficient online channels available. The comprehensive and clear presentation of trustworthy data facilitates purchase decisions faster than any other site. As a result, browsers become buyers and offers one of the highest conversion to sale rates in the industry.</p>
<p>Merchant network is one of the most comprehensive in the industry, with more than 85 percent of the top 300 merchants in the U.S.; a majority of leading merchants in the U.K., France, Germany and Australia; and thousands of smaller merchants across the globe.</p>
<p>Headquartered in Brisbane, California with operations in the U.K., France, Germany and Australia. Was acquired by eBay Inc. in August 2005.</p>
<h5>Help us serve you</h5>
<p>We are committed to delivering the world's ultimate shopping experience. You can help us serve you better by telling us your own experiences below.</p>
<p>Thanks again for visiting. Happy shopping!</p>
<p>Your Team</p>
EOD;



$page_template = str_replace("[META]", '<meta name="robots" content="noindex,nofollow" />', $page_template);
$page_template = str_replace("[SERVER-NAME]", $_SERVER['SERVER_NAME'], $page_template);
$page_template = str_replace("[PAGINATION]", "", $page_template);
$page_template = str_replace("[BOTTOM-ROW]", "", $page_template);
$page_template = str_replace("[CONTENT]", $content, $page_template);
$page_template = str_replace("[H-TITLE]", "<h4>About ".$_SERVER['SERVER_NAME']."</h4>", $page_template);
$page_template = str_replace("[TITLE]", "About ".$_SERVER['SERVER_NAME'], $page_template);

?>