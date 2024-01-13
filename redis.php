<?php 
try {
    $redis = new Redis();
    $redis->connect('<hostname/IP>', <port>);
} catch (RedisException $e) {
    echo "FAILED";
}
if ($redis->ping()) {
 echo "HEALTHY";
}
?>
