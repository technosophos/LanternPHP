<?php
/**
 * Handle the rendering of the main contents of an HTML file.
 */

/**
 * Render the main template into HTML.
 */
class LanternRenderMainHTML extends LanternRender {
  
  protected static $defaults = array(
    'head_title' => 'Lantern',
    'head_links' => '',
    'metadata' => '',
    'styles' => array(),
    'inline_styles' => array(),
    'scripts' => array(),
    'inline_scripts' => array(),
    'bodyclasses' => array('lantern-main'),
    'body' => '',
  );
  
  public static function setTitle($title) {
    self::setDefault('head_title', $title);
  }
  
  public static function addBodyClass($data) {
    self::addDefault('bodyclasses', $data);
  }
  
  public static function addScript($script) {
    self::addDefault('scripts', $script);
  }
  
  public static function addStyle($file) {
    self::addDefault('stypes', $file);
  }
  
  public static function addInlineScript($script) {
    self::addDefault('inline_scripts', $script);
  }
  
  public static function addInlineStyle($css) {
    self::addDefault('inline_styles', $css);
  }
  
  /**
   * Utility for setting default.
   */
  protected static function setDefault($name, $value) {
    self::$defaults[$name] = $value;
  }
  
  /**
   * Utility for adding default value to an array.
   */
  protected static function addDefault($name, $value) {
    self::$defaults[$name][] = $value;
  }
  
  /**
   * Get the value of a default template variable.
   */
  public static function getDefault($name) {
    return self::$defaults[$name];
  }
  
  /**
   * Empty the current value(s) of a default template variable.
   */
  public static function clearDefault($name) {
    self::$defaults[$name] = is_array(self::$defaults[$name]) ? array() : '';
  }
  
  protected function processVariables(&$variables) {
    
    $tplVars = array();
    foreach (self::$defaults as $var => $val) {
      $tplVars[$var] = empty($variables[$var]) ? $val : $variables[$var]; 
    }
    
    // Special handling...
    $tplVars['styles'] = $this->generateStyles($tplVars['styles']);
    $tplVars['inline_styles'] = $this->generateInlineStyles($tplVars['inline_styles']);
    $tplVars['scripts'] = $this->generateScripts($tplVars['scripts']);
    $tplVars['inline_scripts'] = $this->generateInlineScripts($tplVars['inline_scripts']);
    $tplVars['bodyclasses'] = implode(' ', $tplVars['bodyclasses']);
    
    return $tplVars;
  }
  
  protected function generateScripts($scripts) {
    if (is_string($scripts)) return $scripts;
    
    $buffer = array();
    foreach ($scripts as $script) {
      $buffer[] = '<script language="javascript" type="text/javascript" src="' 
        . $script 
        . '"></script>';
    }
    return implode('',$buffer);
  }
  
  protected function generateInlineScripts($scripts) {
    if (is_string($scripts)) return $scripts;
    
    return '<script language="javascript" type="text/javascript">'
      . implode(';', $scripts)
      . '</script>';
  }
  
  protected function generateStyles($cssFiles) {
    if (is_string($cssFiles)) {
      $cssFiles = array($cssFiles);
    }
    
    // Else create link tags...
    $t = '<link rel="stylesheet" type="text/css" href="%s"/>';
    $buffer = array();
    foreach ($cssFiles as $c) {
      $buffer[] = sprintf($t, $c);
    }
    return implode('', $buffer);
  }
  
  protected function generateInlineStyles($css) {
    if (is_string($css)) return $css;
    return '<style>' . implode("\n", $css) . '</style>';
  }
  
}