<?php
/**
 * Initialize Lantern.
 */
 
/**
 * Do any initialization necessary for bootstrapping.
 */
class LanternInitialize extends BaseLanternCommand {
  
  
  public function expects() {
    return $this
      ->description('Initialize the Lantern system.')
      ->usesParam('collection', 'The default collection, which will be loaded and put into the context.')
      ->withFilter('string')
      ->whichIsRequired()
    ;
  }
  
  public function doCommand() {
    // Check if we need to force user into installer.
    if (count($this->db()->listCollections()) == 0) {
      $this->context->add('collections', $this->param('collection'));
      throw new FortissimoForwardRequest('install', $this->context);
    }
    
    // Initialize the default connection, if necessary.
    $name = $this->param('collection');
    if (!empty($name)) {
      $collection = $this->collection($name);
      $this->context->add('collection', $name);
    }
    
  }
}