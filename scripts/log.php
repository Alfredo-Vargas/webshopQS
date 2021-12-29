<?php
    class ErrorLog {
        const ERROR_FILE = "logs/errors.log";
        private $errno;
        private $errMsg;
        private $errFile;
        private $errLine;

        public function __construct($errno=0, $errMsg="", $errFile="", $errLine=""){
            $this->errno = $errno;
            $this->errMsg = $errMsg;
            $this->errFile = $errFile;
            $this->errLine = $errLine;
        }

        public function WriteError(){
            $error = "Error logged: " . date("Y-m-d H:i:s - ");
            $error .= "[ " . $this->errno . " ]: ";
            $error .= $this->errMsg;
            $error .= " in file "  . $this->errFile;
            $error .= " in line "  . $this->errLine . "\n";
            error_log($error, 3, self::ERROR_FILE);  // 3 means to append
        }
    }

    // function to be using when exceptions has no catch
    function handleUncaughtException($e){
        $log = new ErrorLog($e->getCode(), $e->getMessage(), $e->getFile(), $e->getLine(), "An UnCaughtException Occurred");
        $log->WriteError();

    }

    class MyException extends Exception
    {
        public function HandleException()
        {
            $log = new ErrorLog($this->getCode(), $this->getMessage(),
            $this->getFile(), $this->getLine());
            $log->WriteError();
            exit($this->getMessage());
        }
    }
?>