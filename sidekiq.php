<?php

$max_limit = '1000'; // Set this to the max number of enqueued jobs before you consider your server overloaded. This will probably depend on the number of sidekiq services you have running.

$redis = new Redis();
$redis->connect('<hostname/IP>', <port>);
$queues = ['queue:default', 'queue:push', 'queue:ingress', 'queue:mailers', 'queue:pull', 'queue:scheduler'];

$queue_length = '0';
foreach ($queues as $queue_name) {
	$queue_length += $redis->llen($queue_name);
}

if($queue_length > $max_limit) {
	echo "OVERLOADED";
} else {
	echo "HEALTHY";
}

?>