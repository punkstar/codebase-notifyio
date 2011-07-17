<?php
class Config {
    // Codebase Configuration
    public static $CODEBASE_HTTP_USER = "";
    public static $CODEBASE_HTTP_PASS = "";
    
    // Notify.io Configuration
    public static $NIO_EMAIL_ADDRESS = "";
    public static $NIO_API_KEY       = "";
    
    public static $LOG_ENABLED       = true;
    public static $LOG_LOCATION      = "codebase-notify.log";
    
    public static function isConfigured() {
        return  !empty(self::$CODEBASE_HTTP_USER) &&
                !empty(self::$CODEBASE_HTTP_PASS) &&
                !empty(self::$NIO_EMAIL_ADDRESS) &&
                !empty(self::$NIO_API_KEY);
    }
}