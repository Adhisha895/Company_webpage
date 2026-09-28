<?php

$conn = mysqli_connect("localhost", "root", "", "company_management");

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

?>