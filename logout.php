<?php
require_once '../config/database.php';
require_once '../functions/functions.php';
logoutUser();
header('Location: login.php');
exit();
