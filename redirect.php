<?php
if(isset($_GET["to"])){
    header('Location: '.$_GET["to"]);
exit;
}

?>