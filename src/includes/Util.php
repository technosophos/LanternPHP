<?php
/**
 * Utilities.
 */
 
class Util {
  
  public static function base() {
    //global $base; // This comes from index.php
    $base = $_SERVER['PHP_SELF'];
    
    return $base;
  }
  
  public static function url($cmd, $args = array(), $options = array()) {
    
    $args['ff'] = $cmd;
    
    $q = http_build_query($args);
    
    $relUri = self::base() . '?' . $q;
    
    return $relUri;
  }
  
  public static function link($str, $url) {
    return sprintf('<a href="%s">%s</a>', $url, $str);
  }
  
}