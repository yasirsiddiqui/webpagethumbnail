webpagethumbnail
================

This sample project demonstrates how you get image preview of any web page using thumbalizr api in PHP. It also supports
caching images once geenrated. Cache and thumnail parametrs can be configured in config.php

Follow the following instruction

1) Create account at http://www.thumbalizr.com/

2) After login get API Key and replace the value in config.php

Use the following code to get thumbnail of any web page

<?php

include_once ("Webpagepthumbnail.class.php");

$obj = new Webpagethumbnail();

$imagepath = $obj->getThumbnail("http://bing.com");

echo $imagepath;

?>

