<?php
session_start();

$_SESSION['loggedin'] = false;
$_SESSION['username'] = NULL;
$_SESSION['pat_id'] = NULL;
$_SESSION['prov_id'] = NULL;
echo '<script>window.location.href = "index.php";</script>';