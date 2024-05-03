<?php
$conn = mysqli_connect("localhost", "root", "", "chatingapp");
if (!$conn) {
    die("Could not connect to the dataabse due to an error "+mysqli_connect_error());
}
