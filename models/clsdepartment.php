<?php

namespace models

{
    ini_set('display_errors', 1);
    error_reporting(-1);
    ini_set('error_log', 'files/log.txt');
    ini_set('log_errors_max_len', 0);
    ini_set('log_errors', true);
    
    
    
    class clsDepartment
    {
    
        var $slno;
        var $dept_code;
        var $dept_name;
        var $rec_status;
    }
    }
?>