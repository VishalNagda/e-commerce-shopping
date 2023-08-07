<?php
require('connection.php');
require('functioninc.php');



   unset ($_SESSION['USER_LOGIN']);
   unset ($_SESSION['USER_ID']);
   unset($_SESSION['USER_NAME']);
header('location:index.php');
die();


?>