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
    
    $cols = array(Collections::users, Collections::sources, Collections::notes);
    
    foreach ($cols as $c) {
      $this->db()->createCollection($c);
    }
    
    
    print 'System is now installed ' . Util::link('Begin', Util::url('default'));
  
  }
}