<?php
    class ErrorLog {
        const ERROR_FILE = "./";
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
?>