<?php
    $host = '<hostname/IP>';
    $database = '<database>'; //Probably mastodon_production
    $username = '<username>'; //Probably mastodon
    $password = '<password>';
    $port = '5432';
    $connection = pg_connect("host=$host dbname=$database user=$username password=$password port=$port");
    if($connection) {
        die("HEALTHY");
    } else {
        die("FAILED");
    }
?>
