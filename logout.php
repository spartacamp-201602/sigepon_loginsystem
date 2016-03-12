<?php

session_start();

$_SESSION = array();

// unset($_SESSION['id']);

session_destroy();

header('Location: login.php');
exit;
