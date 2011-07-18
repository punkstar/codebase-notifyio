<?php
require_once "Config.php";
require_once "lib/Log.php";
require_once "lib/Notify.php";
require_once "lib/NotifyMessage.php";

Log::write("Request received from " . $_SERVER['REMOTE_ADDR']);

if (!Config::isConfigured()) {
    Log::write("Not configured, aborting.");
    trigger_error("You'll need enter your details into the <tt>Config</tt> class before we can rock and roll.", E_USER_ERROR);
    exit(1);
}

try {
    $nio = new Notify(Config::$NIO_EMAIL_ADDRESS, Config::$NIO_API_KEY);
    
    $username = $_SERVER['PHP_AUTH_USER'];
    $password = $_SERVER['PHP_AUTH_PW'];
    
    if ($username != Config::$CODEBASE_HTTP_USER || $password != Config::$CODEBASE_HTTP_PASS) {
        
        if (!$username) {
            $username = "(empty)";
        }
        
        if (!$password) {
            $password = "(empty)";
        }
        
        Log::write("Authentication failed (with username: $username and password: $password), aborting.");
        trigger_error("Authentication failed: Incorrect HTTP username and/or password", E_USER_ERROR);
        exit(2);
    }
    
    $message = new NotifyMessage();
    
    list($data, $type) = explode(";", $payload);
    $data = json_decode($data, true);
    $type = str_replace(array("type=", '"'), "", $type);
    
    switch ($type) {
        case "update_ticket":
            $text = sprintf("%s updated ticket #%s.",
                $data['user']['name'],
                $data['ticket']['id']
            );
            $title = sprintf("Codebase: %s",
                $data['ticket']['project']['name']
            );
            $link = $data['ticket']['url'];
            break;
        case "push":
            $text = sprintf("%s pushed to %s (%s).",
                $data['user']['name'],
                $data['repository']['name'],
                $data['ref']
            );
            $title = sprintf("Codebase: %s",
                $data['repository']['project']['name']
            );
            $link = $data['repository']['url'];
            break; 
        case "deployment":
            $text = sprintf("%s deployed branch %s to %s.",
                $data['user']['name'],
                $data['branch'],
                $data['servers']
            );
             $title = sprintf("Codebase: %s",
                $data['repository']['project']['name']
            );
            $link = $data['repository']['url'];
            break;
        case "new_ticket":
            $text = sprintf("%s created a new ticket.",
                $data['reporter']['name']
            );
            $title = sprintf("Codebase: %s",
                $data['project']['name']
            );
            $link = $data['ticket']['url'];
             break;
        default:
            $text = "Type: $type";
            $title = "Codebase";
            $link = "http://meanbee.codebasehq.com";
            break;
    }
    
    $message->title = $title;
    $message->text  = $text;
    $message->link  = $link;
    $message->icon  = "https://assets.codebasehq.com/images/fluidicon.png";
    
    $nio->publish($message);
} catch (Exception $e) {
    Log::write("Caught exception: " . $e->getMessage());
}

Log::close();