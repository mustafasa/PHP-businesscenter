<?php
$db_conx = mysqli_connect("localhost", "bluelynx_jack", "mustafa", "bluelynx_business");
// Evaluate the connection
if (mysqli_connect_errno()) {
    echo mysqli_connect_error();
    exit();
} else {
	echo "";
}
?>