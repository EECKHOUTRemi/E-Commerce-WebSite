<?php
require_once('header.php');

session_start();

session_destroy();

header('Location:index.php');die;

require_once('footer.php');
?>