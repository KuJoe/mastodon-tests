<?php

$url = 'http://<hostname/IP>:4000/api/v1/streaming/health';
$content = file_get_contents($url);

if ($content == "OK" ) {
    echo "HEALTHY";
} else {
    echo "DEGRADED";
}

?>