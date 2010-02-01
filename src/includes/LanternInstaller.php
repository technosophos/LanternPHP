<?php
/**
 * Install Lantern.
 */
 
class LanternInstaller extends BaseLanternCommand {
  
  public function expects() {
    return $this
      ->description('Installs Lantern Notes.')
      ;
  }
  
  public function doCommand() {
    
    $cols = array(Collections::users, Collections::sources, Collections::notes, Collections::journal);
    
    foreach ($cols as $c) {
      $this->db()->createCollection($c);
    }
    
    $body = 'System is now installed. ' . Util::link('Begin.', Util::url('default'));
    $style = 'body {background-color: #EFEFEF;}';
    
    $vars = array(
      'head_title' => 'Lantern is Installed.',
      'body' => $body,
      'inline_styles' => array($style),
    );
    
    $this->context->addAll($vars);
    
    return TRUE;
  }
}