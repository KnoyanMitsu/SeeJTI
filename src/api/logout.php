<?php
header ('Access-Control-Allow-Origin: *');
session_start();
session_unset();
session_destroy();
echo "logout";
?>