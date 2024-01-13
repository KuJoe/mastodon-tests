<?php

$connection = @fsockopen('<hostname/IP>', <port>);
if (is_resource($connection)) {
    echo "HEALTHY";
    fclose($connection);
} else {
    echo "FAILED";
}

?>
