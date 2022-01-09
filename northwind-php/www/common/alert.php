<?php
class ApplicationAlert {
    private static $instance = null;
    private  $message;


    private $type;
    private function __construct()
    {

    }
    public static function getInstance()
    {
        if (self::$instance == null)
        {
            self::$instance = new ApplicationAlert();
        }

        return self::$instance;
    }


    public function getType()
    {
        return $this->type;
    }


    public function getMessage()
    {
        return $this->message;
    }


    public function setMessage($msg, $typ): void
    {

        $this->message = $msg;
        $this->type = $typ;
    }

    public function clear(): void
    {

        $this->message = null;
        $this->type = null;
    }
}




?>