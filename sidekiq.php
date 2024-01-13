<?php

$redis = new Redis();
$redis->connect('<hostname/IP>', <port>);
$queue_name = 'queue:pull';

$queue_length = $redis->llen($queue_name);

if($queue_length > 1000) {
	echo "OVERLOADED";
} else {
	echo "HEALTHY";
}

?>