<?php

include_once ("Webpagepthumbnail.class.php");

$obj = new Webpagethumbnail();

try {
    
    $thumnailpath = $obj->getThumbnail("http://bing.com");  
}

catch (Exception $e) {
    
      echo $e->getMessage();
      exit;
}
?>

<img src="<?php echo $thumnailpath;?>">