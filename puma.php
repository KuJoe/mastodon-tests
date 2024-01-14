<?php

// For this script to work, you need to enable stats output on your puma processes.
// Add the following line to your /home/mastodon/live/config/puma.rb file:
// activate_control_app 'tcp://<server_IP>:9000', { no_token: true }
// Now restart your mastodon-web.service (systemctl restart mastodon-web.service)

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

function getStats($response,$backlog,$running,$pool_capacity,$max_threads,$requests_count) {
        $resArr = json_decode($response);
        foreach ($resArr->worker_status as $output) {
                $backlog+= $output->last_status->backlog;
                $running+= $output->last_status->running;
                $pool_capacity+= $output->last_status->pool_capacity;
                $max_threads+= $output->last_status->max_threads;
                $requests_count+= $output->last_status->requests_count;
        }
        $out['backlog'] = $backlog;
        $out['running'] = $running;
        $out['pool_capacity'] = $pool_capacity;
        $out['max_threads'] = $max_threads;
        $out['requests_count'] = $requests_count;
        return $out;
}

$response = get_web_page("http://<hostname/IP>:9000/stats");
$stats = getStats($response,'0','0','0','0','0');

if($stats['backlog'] > '1' )  {
        echo "OVERLOADED<br />";
} elseif($stats['max_threads'] < '1') {
        echo "FAILED<br />";
} else {
        echo "HEALTHY<br />";
}
echo "Backlog: ".$stats['backlog']."<br />";
echo "Running: ".$stats['running']."<br />";
echo "Pool Capacity: ".$stats['pool_capacity']."<br />";
echo "Max Threads: ".$stats['max_threads']."<br />";
echo "Requests Count: ".$stats['requests_count']."<br />";

?>
