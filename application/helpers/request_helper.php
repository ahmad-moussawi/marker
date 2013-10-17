<?php
class Request {

    private static $post = array();
    public static function Post($key = FALSE, $default = FALSE, $xss_clean = TRUE) {
        if (strpos($_SERVER['HTTP_ACCEPT'], 'application/json') !== FALSE) {
            try {
                self::$post = (array)json_decode($GLOBALS['HTTP_RAW_POST_DATA']);
            } catch (Exception $exc) {
                
            }
        }
        if($key){
            return array_key_exists($key, self::$post) ? xss_clean(self::$post[$key]) : $default;
        }else{
            return self::$post;
        }
    }
}
