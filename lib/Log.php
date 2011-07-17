<?php
class Log {
    protected static $_handle = null;
    
    public static function write($message) {
        if (Config::$LOG_ENABLED && Config::$LOG_LOCATION) {
            if (self::$_handle === null) {
                self::$_handle = fopen(Config::$LOG_LOCATION, "a");
            }
            
            $line = sprintf("[%s] %s\n",
                date("Y-m-d H:i:s"),
                $message
            );
            
            echo nl2br($line);
            fwrite(self::$_handle, $line);
            fflush(self::$_handle);
        }
    }
    
    public static function close() {
        if (self::$_handle) {
            fclose(self::$_handle);
        }
    }
}