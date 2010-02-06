<?php
/**
 * Defines template tools.
 */
 
/**
 * This class defines static methods available to templates.
 */
class TPL {
  
  const shortDate = 'M jS, Y';
  const longDate = 'M jS, Y';
  const shortDateTime = 'M jS, Y h:ia';
  const longDateTime = 'M jS, Y \a\t h:ia';  
  
  public static function plural($number, $singular, $plural) {
    $fmt = $number == 1 ? $singular : $plural;
    return sprintf($fmt, $number);
  }
  
  public static function breadcrumbs($urls, $sep = ' » ') {
    $fmt = '<a href="%s">%s</a>';
    $buff = array();
    foreach ($urls as $url => $title) $buff[] = sprintf($fmt, $url, $title);
    
    return implode($sep, $buff);
  }
}