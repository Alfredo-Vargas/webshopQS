<?php
    include_once "./scripts/logs.php";
    // error logs are saved on php.ini (default file)

    function handleErrors($errno, $errMsg, $errFile, $errLine){
        $log = new ErrorLog($errno, $errMsg, $errFile, $errLine);
        $log->WriteError();
        echo("An error occurred. Please consult the error log file for more information.");
        exit();  // makes sure no php script continues
    }

    function handleFailedLogins($errno, $errMsg, $errFile, $errLine){
        $log = new ErrorLog($errno, $errMsg, $errFile, $errLine);
        $log->WriteError();
    }

	set_error_handler("handleErrors");
	set_error_handler("handleFailedLogins", E_USER_WARNING);
?>