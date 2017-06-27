<?php
  ini_set('display_errors', 0); error_reporting(-1);
    ini_set('error_log', 'files/log.txt');
    ini_set('log_errors_max_len', 0);
    ini_set('log_errors', true);
session_start();
    if (!$_SESSION['user']){
        header("location: views/login.html");
        die;
    }
    ?>