<?php

function get_web_page($url) {
    $options = array(
        CURLOPT_RETURNTRANSFER => true,   // return web page
        CURLOPT_HEADER         => false,  // don't return headers
        CURLOPT_FOLLOWLOCATION => true,   // follow redirects
        CURLOPT_MAXREDIRS      => 10,     // stop after 10 redirects
        CURLOPT_ENCODING       => "",     // handle compressed
        CURLOPT_USERAGENT      => "monitor", // name of client
        CURLOPT_AUTOREFERER    => true,   // set referrer on redirect
        CURLOPT_CONNECTTIMEOUT => 30,    // time-out on connect
        CURLOPT_TIMEOUT        => 30,    // time-out on response
    );

    $ch = curl_init($url);
    curl_setopt_array($ch, $options);

    $content  = curl_exec($ch);

    curl_close($ch);

    return $content;
}

$check = '0';
$response = get_web_page("http://<hostname/IP>:4000/api/v1/streaming/health");
if($response = "OK") {
        $check++;
}
if($check > 0) {
        echo "HEALTHY";
} else {
        echo "DEGRADED";
}

?>