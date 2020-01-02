<?php
include_once("settings.php");
include_once("db.php");
include_once("functions.php");



$content = "";
$content .= '<div class="row"><div class="col-12"> <div id="carousel1" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                <li data-target="#carousel1" data-slide-to="0" class="active"></li>

                <li data-target="#carousel1" data-slide-to="1"></li>

                <li data-target="#carousel1" data-slide-to="2"></li>
            </ol>

            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img class="d-block w-100" src="http://s1.cnnx.io/creative_services/bizrate/jumbo/2013/10_october/BZ-131104DigitalCameraJumbo-00b.jpg" alt="First slide">
                    <div class="carousel-caption d-none d-md-block">
                        <!--<h3>Slide label 1</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>-->
                    </div>
                </div>

                <div class="carousel-item">
                    <img class="d-block w-100" src="http://s1.cnnx.io/creative_services/editorial_and_email/bizrate_editorial_features/1307/BZ-130729HighTechBabyJumbo-00a.jpg" alt="Second slide">
                    <div class="carousel-caption d-none d-md-block">
                        <!--<h3>Slide label 2</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>-->
                    </div>
                </div>

                <div class="carousel-item">
                    <img class="d-block w-100" src="http://s1.cnnx.io/creative_services/editorial_and_email/bizrate_editorial_features/1307/BZ-130715CampingAndHikingJumbo-00a.jpg" alt="Third slide">
                    <div class="carousel-caption d-none d-md-block">
                        <!--<h3>Slide label 3</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>-->
                    </div>
                </div>

                <div class="carousel-item">
                    <img class="d-block w-100" src="http://s1.cnnx.io/home/www/html/bizrate/jumbos/10-2014/BZ-Jumbo-winter201410.jpg" alt="Third slide">
                    <div class="carousel-caption d-none d-md-block">
                        <!--<h3>Slide label 3</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>-->
                    </div>
                </div>
            </div>

            <a class="carousel-control-prev" href="#carousel1" role="button" data-slide="prev"> <span class="carousel-control-prev-icon" aria-hidden="true"></span> <span class="sr-only">Previous</span> </a>
            <a class="carousel-control-next" href="#carousel1" role="button" data-slide="next"> <span class="carousel-control-next-icon" aria-hidden="true"></span> <span class="sr-only">Next</span> </a>
        </div> </div></div>';


$content .= '<div class="row">';


$content .= '<div class="col-4"><dl>
            <dt><a href="http://'.$_SERVER['SERVER_NAME'].'/fashion">Fashion</a></dt>
            <dd>Fashion is a popular style or practice, especially in clothing, footwear, accessories, makeup, hairstyle and body...</dd>

            <dt><a href="http://'.$_SERVER['SERVER_NAME'].'/forever 21">Forever 21</a></dt>
            <dd>Forever 21 is an American fast fashion retailer headquartered in Los Angeles, California...</dd>

            <dt><a href="http://'.$_SERVER['SERVER_NAME'].'/gucci">Gucci</a></dt>
            <dd>Gucci is an Italian luxury brand of fashion and leather goods, part of the Gucci Group, which is owned by the French...</dd>

            <dt><a href="http://'.$_SERVER['SERVER_NAME'].'/h m">H&M</a></dt>
            <dd>H & M Hennes & Mauritz AB is a Swedish multinational clothing-retail company which has a reputation for its fast-fashion...</dd></dl>
            </div>';

$content .= '<div class="col-4"><dl>
            <dt><a href="http://'.$_SERVER['SERVER_NAME'].'/american eagle outfitters">American Eagle Outfitters</a></dt>
            <dd>American Eagle Outfitters, Inc. is an American clothing and accessories retailer, headquartered in the Southside Works...</dd>

            <dt><a href="http://'.$_SERVER['SERVER_NAME'].'/zara">Zara</a></dt>
            <dd>Zara is a Spanish fast fashion retailer based in Arteixo, Galicia. The company was founded in 1975 by Amancio Ortega and Rosalia Mera...</dd>

            <dt><a href="http://'.$_SERVER['SERVER_NAME'].'/tiffany & co.">Tiffany & Co.</a></dt>
            <dd>Tiffany & Company is an American luxury jewelry and specialty retailer, headquartered in New York City...</dd></dl>
            </div>';

$content .= '<div class="col-4"><dl>
            <dt><a href="http://'.$_SERVER['SERVER_NAME'].'/rolex">Rolex</a></dt>
            <dd>Rolex SA is a Swiss luxury watchmaker. The company and its subsidiary Montres Tudor SA design, manufacture, distribute...</dd>

            <dt><a href="http://'.$_SERVER['SERVER_NAME'].'/hollister co.">Hollister Co.</a></dt>
            <dd>Hollister Co., often advertised as Hollister or HCo., is an American lifestyle brand owned by Abercrombie & Fitch Co...</dd>

            <dt><a href="http://'.$_SERVER['SERVER_NAME'].'/abercrombie & fitch">Abercrombie & Fitch</a></dt>
            <dd>Abercrombie & Fitch is an American retailer that focuses on upscale casual wear for young consumers, its headquarters are...</dd>
            </dl>
        </div>';


$content .= '</div>';

$page_template = str_replace("[META]", '', $page_template);
$page_template = str_replace("[SERVER-NAME]", $_SERVER['SERVER_NAME'], $page_template);
$page_template = str_replace("[PAGINATION]", "", $page_template);
$page_template = str_replace("[BOTTOM-ROW]", "", $page_template);
$page_template = str_replace("[CONTENT]", $content, $page_template);
$page_template = str_replace("[H-TITLE]", "<h4>".$home_h_text."</h4>", $page_template);
$page_template = str_replace("[TITLE]", $global_site_title." - ".$_SERVER['SERVER_NAME'], $page_template);
?>