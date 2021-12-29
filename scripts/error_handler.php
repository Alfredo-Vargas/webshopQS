<?php
    include_once "./scripts/log.php";
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
        // No need for exit(); failed login attempts are no reason to stop the php scripts
        // brute force attacks maybe a reason though? -- to investigate how to deal with DDoS at this stage
    }

	set_error_handler("handleErrors");
	set_error_handler("handleFailedLogins", E_USER_WARNING);

    set_exception_handler("handleUncaughtException");
?>