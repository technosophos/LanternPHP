<?php
/**
 * Rendering library for Lantern.
 */
 
/**
 * Render content into a template.
 *
 * Lantern uses a two-stage output mechanism. The first mechanism takes data
 * and formats it for display. In Lantern, this is done by creating PHP files
 * that act like templates, and having the present class (LanternRender) render
 * these into static output.
 *
 * The second mechanism takes the buffer generated by the renderer, and writes that
 * buffer to some output stream. In Lantern's default case, {@link LanternOut} is
 * used to write the contents to STDOUT, which is usually redirected to the browser.
 *
 * The advantages of this two-stage rendering process are discussed in {@link LanternOut}.
 *
 * @see LanternOut
 */
class LanternRender extends BaseLanternCommand {
  
  public function expects() {
    return $this
      ->description('Takes some input and formats it for output.')
      
      ->usesParam('variables', 'An associative array containing the variables to be made available to the template. If this is not supplied, the execution context is used.')
      
      ->usesParam('themeDir', 'The directory containing the theme. Paths to templates are created by adding base path to (optional) theme dir, and then appending the template. No leading or trailing slashes! To use more than one directory, supply a comma-separated string, ordered by importance.')
      ->withFilter('string')
      
      ->usesParam('template', 'The name of the template file into which the variables will be rendered. Leading slash is read as an absolute path. Otherwise, the path is built.')
      ->withFilter('string')
      ->whichIsRequired()
      
      ->andReturns('A string containing the formatted text.')
      ;
  }
  
  public function doCommand() {
    $variables = $this->param('variables', $this->context->toArray());
    $template = $this->param('template');
    $themeDir = $this->param('themeDir','');
    
    // FIXME: This probably needs more sophistication on Windows.
    if (strpos($template, '/') === 0) {
      $path = $template;
    }
    elseif(!empty($themeDir)) {
      $path = $this->basePath() . DIRECTORY_SEPARATOR . $themeDir . DIRECTORY_SEPARATOR . $template;
    }
    else {
      $path = $this->basePath() . DIRECTORY_SEPARATOR . $template;
    }
    
    if (is_file($path) && is_readable($path)) {
      $preparedVariables = $this->processVariables($variables);
      $content = $this->loadTemplate($path, $preparedVariables);
    }
    else {
      throw new FortissimoException(sprintf('Template not found: "%s".', $path));
    }
    
    // Store content in the context.
    return $content;
  }
  
  /**
   * Process variables before rendering.
   *
   * Do any necessary preprocessing on the variables before they are passed to 
   * the template.
   *
   * Subclasses may wish to override this to perform custom processing on variables.
   *
   * @param array $variables
   *  A reference to the variables array.
   * @return array 
   *  Whatever is returned here will be used as the variables for the template.
   */
  protected function processVariables(&$variables) {
    return $variables;
  }
  
  /**
   * Include the template, limiting variable scope to $variables.
   * @param string $template
   *  The complete and verified path to a template.
   * @param array $variables
   *  The variables to be brought into scope for the template.
   * @return string
   *  The rendered contents of the template.
   */
  protected function loadTemplate($template, &$variables) {
    
    if (!is_array($variables)) {
      throw new FortissimoException('Template variables are not an array.');
    }
    
    extract($variables, EXTR_SKIP);
    
    ob_start();
    include $template;
    $contents = ob_get_contents();
    ob_end_clean();
    return $contents;
  }
  
}