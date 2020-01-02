<?php
$fil = urldecode ($_GET['file']);
//$title = urldecode($_GET['name']);
$type="";
$mix3 = explode("/", $fil);
$title=$mix3[6];



$size = getimagesize($fil);
switch ($size['mime']) {
    case "image/gif":
        $type = "gif";
        break;
    case "image/jpeg":
        $type = "jpeg";
        break;
    case "image/png":
        $type = "png";
        break;
    case "image/bmp":
        $type = "bmp";
        break;
    default:
    $type = "jpg";
    break;
}


//$filename = preg_replace ("/[^\p{L}0-9]/iu","_",translitIt(base64_decode ($_GET['link'])));
	header("Content-Type: image/gif, image/jpeg, image/png, image/bmp, image/tiff");
	header("Content-Disposition: attachment; filename=\"".$title.".".$type."\"");
	readfile($fil);
	exit;
?>