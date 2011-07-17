<?php
class NotifyMessage {
    public $text  = "";
    public $title = "";
    public $icon  = "";
    public $link  = "";
    
    protected $_tags = array();
    
    public function addTag($tag) {
        array_push($this->_tags, $tag);
    }
    
    public function setSticky() {
        $this->addTag('sticky');
    }
    
    public function unsetSticky() {
        if ($key = array_search('sticky', $this->_tags)) {
            unset($this->_tags[$key]);
        }
    }
    
    public function getTags() {
        return $this->_tags;
    }
    
    public function getPostString() {
        if (empty($this->text)) {
            throw new Exception("The text field of the notify message is required");
        }
        
        $data = array(
            "text"  => $this->text,
            "title" => $this->title,
            "icon"  => $this->icon,
            "link"  => $this->link,
            "tags"  => join(" ", $this->getTags())
        );
        
        $fields_string = "";
        foreach($data as $key => $value) {
            $fields_string .= $key.'='.$value.'&';
        }
        
        rtrim($fields_string,'&');
        
        return $fields_string;
    }
}