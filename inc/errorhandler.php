<?php
/**
 * Class for error handling
 * 
 * @author Alexander Aasebø <alexander@aasebo.net>
 * @version 0.1
 */
class errorhandler {

    protected $errors =[];
    
    public function addError($error, $key = null) {
        if ($key){
            $this->errors[$key][] = $error;
        } else {
            $this->errors[] = $error;
        }
    }
    
    public function all($key = null) {
        return isset($this->errors[$key]) ? $this->errors[$key] : $this->errors;
    }
    
    public function hasErrors() {
        return count($this->all()) ? true : false;
    }
    
    public function first($key) {
        return isset($this->all($key)[0]) ? $this->all($key)[0] : false;
    }
}

