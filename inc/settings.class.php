<?php

/**
 * Description of settings
 *
 * @author alex
 */
class settings {
    public $url;
    public $local_path;

    public $mysql_dsn;
    public $mysql_host;
    public $mysql_user;
    public $mysql_pass;
    public $mysql_database;

    // $extra will be saved in a settings file
    public $extra = array();
    protected $settings_file = './data/settings';



    public function __construct () {
        // Set standard-setting
        // Find url
        $host  = $_SERVER['HTTP_HOST'];
        $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
        $this->url = 'http://' . $host.$uri;
    }

    public function getFromFile() {
        $file = $this->local_path . $this->settings_file;
        if (file_exists($file)) {
            $fp = fopen($file, 'r');
            if (!flock($fp, LOCK_SH)) {
                throw new Exception('Could\'nt lock on the settings file.');
            }
            $this->extra = unserialize(file_get_contents(($file)));
            if (!flock($fp, LOCK_UN)) {
                throw new Exception('Could\'nt unlock the settings file.');
            }
            fclose($fp);
            return true;
        }

        return false;

    }

    public function writeToFile() {
        file_put_contents($this->local_path . $this->settings_file, serialize($this->extra), LOCK_EX);
    }
    
    public function __get($key) {
        if (isset($this->extra[$key])) {
            return $this->extra[$key];
        }
        return NULL;
    }
    
    public function __isset($key) {
        return isset($this->extra);
    }

    public function settingsFile() {
        return $this->local_path.$this->settings_file;
    }
    




}

// Create the object!

$settings = new settings();
// From now on, we can use the $settings to fetch settings.
// Settings are set in settings.php
