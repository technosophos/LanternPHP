<?php
/**
 * Install Lantern.
 */
 
class LanternInstaller extends BaseLanternCommand {
  
  public function expects() {
    return $this
      ->description('Installs Lantern Notes.')
      ->usesParam('collections','A comma-separated list of collections to create. Generally you only need one.')
      ->withFilter('string')
      ->whichIsRequired()
      ;
  }
  
  public function doCommand() {
    
    /*
    $cols = array(Collections::users, Collections::sources, Collections::notes, Collections::journal);
    
    foreach ($cols as $c) {
      $this->db()->createCollection($c);
    }
    */
    $db = $this->db();
    $indices = array(
      'lanternType',
      'title',
      'tags',
    );
    $collections = explode(',', $this->param('collections'));
    foreach ($collections as $c) {
      $db->createCollection(trim($c));
      $db->$c->ensureIndex($indices);
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