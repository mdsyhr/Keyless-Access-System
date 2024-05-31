<?php
class Database
{
    private static $dbName = 'nodemcu_rfidrc522_mysql';
    private static $dbHost = 'localhost';
    private static $dbUsername = 'root';
    private static $dbUserPassword = '';

    private static $cont = null;

    public function __construct() {
        die('Init function is not allowed');
    }

    public static function connect()
    {
        // One connection through whole application
        if (null == self::$cont) {     
            self::$cont = new mysqli(self::$dbHost, self::$dbUsername, self::$dbUserPassword, self::$dbName);

            if (self::$cont->connect_error) {
                die('Connection failed: ' . self::$cont->connect_error);
            }
        }
        return self::$cont;
    }

    public static function disconnect()
    {
        if (self::$cont !== null) {
            self::$cont->close();
            self::$cont = null;
        }
    }
}
?>
