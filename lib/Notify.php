<?php
class Notify {
    const API_ENDPOINT = "http://api.notify.io/v1/notify/";
    
    protected $_email;
    protected $_api;
    
    public function __construct($email, $api) {
        $this->_email = $email;
        $this->_api = $api;
    }
    
    public function publish(NotifyMessage $message) {
        $options = array(
            CURLOPT_URL            => $this->_getApiUrl(),
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => $message->getPostString(),
            CURLOPT_RETURNTRANSFER => true
        );
        
        $ch = curl_init();
        
        Log::write("Post data: " . $message->getPostString());
        Log::write("Publishing to: " . $this->_getApiUrl());

        foreach ($options as $key => $value) {
            curl_setopt($ch, $key, $value);
        }
        
        $result = curl_exec($ch);
        
        curl_close($ch);
        
        Log::write("Publish result: " . $result);
        
        return $result == "OK";
    }
    
    protected function _getApiUrl() {
        return self::API_ENDPOINT . md5($this->_email) . "?api_key=" . $this->_api;
    }
}