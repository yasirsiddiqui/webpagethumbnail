<?php
$api_config = array(
    
    'api_key'   => "YOUR_API_KEY",  // Your api key. Get it after sign up on thumbalizr.com
    'api_url'   => "http://api.thumbalizr.com/",
    'cache_dir' => "./cache",                   // Cache directory path
    'cache_expirey_time' => 1                  //  Cache expiry time in hours
);

$thumnail_config = array (
    
    'imagewidth' =>  "250",      // 1-1280  image width
    'delay'	 =>  10,         //  5 - 10 better config value. For more infirmation see http://api.thumbalizr.com/
    'encoding'	 =>  "jpg",      // For free account only jpg is supported For more infirmation see http://api.thumbalizr.com/
    'quality'	 =>  "90",       // image quality 10-90
    'mode'	 =>  "screen",   // screen or page
    'bwidth'	 =>  "1280",     // capture browser width
    'bheight'	 =>  "1024",     // capture browser height only for mode=screen
    'watermark'  =>  "0",        // Defaults sets to one for free account and for the paid account this can be set to 0
);

?>