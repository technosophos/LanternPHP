<?php
/**
 * Uninstall Lantern.
 */

/**
 * 
 */
class LanternUninstall extends BaseLanternCommand {
  
  public function expects() {
    return $this->description('Purges data from the system.');
  }
  
  public function doCommand() {
    $this->db()->users->drop();
    $this->db()->sources->drop();
    $this->db()->notes->drop();
    $this->db()->Sources->drop();
    
    print 'All data has been deleted.';
  }
  
}