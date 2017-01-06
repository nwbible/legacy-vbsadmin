<?php

$host = "localhost"; // your MySQL host i.e. the server on which the database is, usually localhost
$user = "root"; // your MySQL username
$pass = "password"; // your MySQL password
$db = "<INSERT YOUR DATABASE NAME HERE>"; // the database to which you're trying to connect to
$conn = mysqli_connect("$host", "$user", "$pass", "$db") or die("Unable to connect to database." . mysqli_error());


?>