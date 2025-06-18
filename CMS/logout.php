<?php

session_start();

header("Location: userlogin.php");

session_unset();
session_destroy();

?>