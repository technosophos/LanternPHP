<?php
/**
 * Handle the rendering of the main contents of an HTML file.
 */

/**
 * 
 */
class LanternRenderMainHTML extends LanternRender {
  protected function processVariables(&$variables) {
    
    $tplVars = array(
      'head_title' => !empty($variables['head_title']) ? $variables['head_title'] : 'Lantern',
      'head_links' => !empty($variables['head_links']) ? $variables['head_links'] : '',
      'metadata' => !empty($variables['metadata']) ? $variables['metadata'] : '',
      'styles' => !empty($variables['styles']) ? $this->generateStyles($variables['styles']) : '',
      'inline_styles' => !empty($variables['inline_styles']) ? $this->generateInlineStyles($variables['inline_styles']) : '',
      'scripts' => !empty($variables['scripts']) ? $this->generateScripts($variables['scripts']) : '',
      'inline_scripts' => !empty($variables['inline_scripts']) ? $this->generateInlineScripts($variables['inline_scripts']): '',
      'bodyclasses' => !empty($variables['bodyclasses']) ? $variables['bodyclasses'] : '',
      'body' => !empty($variables['body']) ? $variables['body'] : '',
    );
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
    if (is_string($cssFiles)) return $cssFiles;
    
    // Else create link tags...
  }
  
  protected function generateInlineStyles($css) {
    if (is_string($css)) return $css;
    return '<style>' . implode("\n", $css) . '</style>';
  }
  
}