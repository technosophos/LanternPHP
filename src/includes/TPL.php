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
  
  public static function tags($tags) {
    if (empty($tags)) return '';
    
    $links = array();
    foreach ($tags as $tag) {
      $url = Util::url('tag', array('t' => $tag));
      $links[] = sprintf('<a href="%s">%s</a>', $url, $tag);
    }
    
    return implode(', ', $links);
  }
  
  public static function snip($text, $maxChars = 25) {
    $text = filter_var($text, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH | FILTER_FLAG_STRIP_LOW);
    
    $len = strlen($text);
    if ($len > $maxChars) {
      $whitespace = strrpos($text, ' ', ($maxChars - 1 - $len));
      $text = substr($text, 0, $whitespace) . '&hellip;';
    }
    return $text;
  }
}